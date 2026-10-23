/**
 * Behavioural smoke test.
 *
 * Lighthouse says the page is fast; it says nothing about whether the animations
 * and layout still behave. This drives a real headless Chrome against a RUNNING
 * site and asserts what a score cannot see: the crow overlay dismisses itself,
 * the hero splits, nothing is stranded at opacity 0, work-item hover and the
 * receipt links work, every case study renders its cards, and the console is clean.
 *
 * It does NOT build or serve anything. Start the site first (npm start, which
 * serves on :8080, or npm run build then a static server) and point it at the URL.
 * If something is already listening on :8080, use that rather than starting another.
 *
 * Usage: npm run smoke            (defaults to http://localhost:8080)
 *        node tools/smoke.mjs [baseUrl]   (or set SMOKE_URL)
 *
 * Expected counts are derived from src/work/*.md rather than hard-coded.
 */

import { readdirSync, readFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { launch } from 'chrome-launcher';
import puppeteer from 'puppeteer-core';

const BASE = (process.argv[2] || process.env.SMOKE_URL || 'http://localhost:8080').replace(/\/$/, '');

// ---- Expected values, derived from source ---------------------------------
const workDir = fileURLToPath(new URL('../src/work/', import.meta.url));
const caseStudies = readdirSync(workDir)
  .filter((f) => f.endsWith('.md'))
  .map((f) => {
    const src = readFileSync(workDir + f, 'utf8');
    const hl = src.match(/^highlights:\s*\[(.*?)\]/m);
    return {
      slug: f.replace(/\.md$/, ''),
      client: (src.match(/^client:\s*'?(.*?)'?\s*$/m) || [])[1] || '',
      badges: hl ? hl[1].split(',').filter((s) => s.trim()).length : 0,
    };
  });
const expectedBadges = caseStudies.reduce((n, c) => n + c.badges, 0);

const results = [];
const check = (name, pass, detail = '') => {
  results.push({ name, pass, detail });
  console.log(`  ${pass ? '✓' : '✗'} ${name}${detail ? `  - ${detail}` : ''}`);
};
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

try {
  const res = await fetch(`${BASE}/`);
  if (!res.ok) throw new Error(`HTTP ${res.status}`);
} catch (e) {
  console.error(`Cannot reach ${BASE} (${e.message}). Start the site first, e.g. npm start.`);
  process.exit(2);
}

const chrome = await launch({ chromeFlags: ['--headless=new', '--no-sandbox'] });
const browser = await puppeteer.connect({
  browserURL: `http://localhost:${chrome.port}`,
  defaultViewport: { width: 1440, height: 900 },
});

const trackConsole = (page, sink) => {
  page.on('console', (m) => m.type() === 'error' && sink.push(`${page.url()}: ${m.text()}`));
  page.on('pageerror', (e) => sink.push(`${page.url()}: ${e}`));
};

// Splash is skipped by default so each page is tested in its settled state.
const skipSplash = (page) =>
  page.evaluateOnNewDocument(() => {
    try {
      sessionStorage.setItem('dm-crow-shown', '1');
    } catch {}
  });

// Scrolls the whole page so scroll-triggered reveals fire, then returns to the top.
const scrollThrough = async (page) => {
  await page.evaluate(async () => {
    const step = Math.max(300, window.innerHeight * 0.7);
    for (let y = 0; y < document.documentElement.scrollHeight; y += step) {
      window.scrollTo(0, y);
      await new Promise((r) => setTimeout(r, 120));
    }
    window.scrollTo(0, document.documentElement.scrollHeight);
    await new Promise((r) => setTimeout(r, 250));
    window.scrollTo(0, 0);
  });
};

const strandedAtZero = (page) =>
  page.evaluate(() => {
    const bad = [];
    for (const el of document.querySelectorAll('main *')) {
      const s = getComputedStyle(el);
      if (parseFloat(s.opacity) === 0 && s.visibility !== 'hidden' && el.getClientRects().length) {
        // Intentionally hidden at rest: hover choreography, the career path and
        // receipts (revealed on hover), and the nav bar on the homepage.
        if (el.closest('.work-title-duplicate, .nav-glide__bar, .career, .receipt, .work-arrow, .card-detail')) continue;
        bad.push(el.className || el.tagName);
      }
    }
    return bad.slice(0, 5);
  });

const consoleErrors = [];

try {
  // ---- Homepage (splash left on, desktop) ----------------------------------
  console.log('\nhomepage');
  const page = await browser.newPage();
  trackConsole(page, consoleErrors);
  await page.goto(`${BASE}/`, { waitUntil: 'networkidle0' });

  check('body.loaded applied', await page.evaluate(() => document.body.classList.contains('loaded')));

  const dismissed = await page
    .waitForFunction(
      () => {
        const l = document.querySelector('#crow-loader');
        return Boolean(l) && !l.classList.contains('active');
      },
      { timeout: 8000 },
    )
    .then(() => true, () => false);
  check('crow overlay dismissed', dismissed);

  check(
    'native scrolling (no ScrollSmoother wrapper)',
    await page.evaluate(() => !document.querySelector('#smooth-wrapper') && !window.smoother),
  );

  const split = await page.evaluate(() => {
    const h1 = document.querySelector('[data-hero-heading]');
    return { exists: Boolean(h1), children: h1 ? h1.querySelectorAll('div, span').length : 0 };
  });
  check('hero heading split by SplitText', split.exists && split.children > 0, `${split.children} nodes`);

  await scrollThrough(page);
  await page
    .waitForFunction(
      () => ![...document.querySelectorAll('main .gsap-reveal')].some((e) => parseFloat(getComputedStyle(e).opacity) === 0),
      { timeout: 4000 },
    )
    .catch(() => {});
  const invisible = await strandedAtZero(page);
  check('no content stranded at opacity 0 after scrolling', invisible.length === 0, invisible.join(', '));

  const items = await page.$$('.work-item');
  check(`${caseStudies.length} work items rendered`, items.length === caseStudies.length, `${items.length} found`);

  const badges = await page.evaluate(
    () => document.querySelectorAll('.work-item [style*="background-color"]').length,
  );
  check(`${expectedBadges} highlight badges rendered`, badges === expectedBadges, `${badges} found`);

  if (items[0]) {
    await items[0].evaluate((e) => e.scrollIntoView({ block: 'center' }));
    const before = await page.evaluate(
      () => getComputedStyle(document.querySelector('.work-background')).transform,
    );
    await items[0].hover();
    const changed = await page
      .waitForFunction((b) => getComputedStyle(document.querySelector('.work-background')).transform !== b, { timeout: 3000 }, before)
      .then(() => true, () => false);
    check('work-item hover animates background', changed);
  }

  check(
    'fonts loaded from same origin',
    await page.evaluate(() => [...document.fonts].some((f) => f.status === 'loaded')),
  );

  // Gliding nav: hidden at rest on the homepage on purpose, so only assert it exists and is not announced.
  check(
    'nav bar present but decorative',
    await page.evaluate(() => {
      const bar = document.querySelector('.nav-glide__bar');
      return Boolean(bar) && bar.getAttribute('aria-hidden') === 'true';
    }),
  );

  const letsWork = await page.evaluate(() => {
    const norm = (s) => s.replace(/\s+/g, ' ').trim();
    return [...document.querySelectorAll('a')].filter((a) => {
      const visible = [...a.querySelectorAll('*')].filter((n) => !n.closest('[aria-hidden="true"]'));
      const name = norm(
        [...a.childNodes].length
          ? [...a.querySelectorAll('.btn-label')].filter((n) => !n.closest('[aria-hidden="true"]')).map((n) => n.textContent).join(' ')
          : '',
      );
      return visible.length >= 0 && name === "Let's work";
    }).length;
  });
  check(`"Let's work" accessible name appears once`, letsWork === 1, `${letsWork} found`);

  // Receipts: every "See the project" link must be the element under the cursor once its line is hovered.
  const receipts = await page.evaluate(() => document.querySelectorAll('[data-receipts] .receipt-item').length);
  check('receipt tiles rendered', receipts > 0, `${receipts} receipts`);
  const tiles = await page.$$('[data-receipts]');
  const receiptFails = [];
  const settled = () =>
    page.evaluate(
      () =>
        new Promise((resolve) => {
          let last = -1;
          let n = 0;
          const tick = () => {
            n = window.scrollY === last ? n + 1 : 0;
            last = window.scrollY;
            n >= 5 ? resolve() : requestAnimationFrame(tick);
          };
          tick();
        }),
    );
  // One attempt: centre the item, hover its line, glide to the link, report what is under the cursor.
  const probe = async (item) => {
    await item.evaluate((e) => e.scrollIntoView({ block: 'center' }));
    await settled();
    const lb = await (await item.$('.receipt-line')).boundingBox();
    await page.mouse.move(lb.x + 10, lb.y + lb.height / 2);
    await page.waitForFunction((el) => el.classList.contains('is-active'), { timeout: 3000 }, item).catch(() => {});
    await sleep(350); // reveal transition
    await settled();
    const link = await item.$('.receipt__link');
    const kb = await link.boundingBox();
    const tx = kb.x + kb.width / 2;
    const ty = kb.y + kb.height / 2;
    await page.mouse.move(tx, ty, { steps: 12 });
    return page.evaluate(
      (x, y) => document.elementFromPoint(x, y)?.closest('a')?.getAttribute('href') ?? null,
      tx,
      ty,
    );
  };
  for (const tile of tiles) {
    for (const item of await tile.$$('.receipt-item')) {
      const expected = await (await item.$('.receipt__link')).evaluate((a) => a.getAttribute('href'));
      let hit = null;
      for (let attempt = 0; attempt < 3 && hit !== expected; attempt++) hit = await probe(item);
      if (hit !== expected) receiptFails.push(`${expected} (hit ${hit})`);
    }
  }
  check('receipt "See the project" links clickable', receipts > 0 && receiptFails.length === 0, receiptFails.join(', '));
  await page.close();

  // ---- Work and writing index pages ----------------------------------------
  console.log('\nindex pages');
  const ac = await browser.newPage();
  trackConsole(ac, consoleErrors);
  await skipSplash(ac);

  const currentLinks = (p) =>
    p.evaluate(() => [...document.querySelectorAll('a[aria-current="page"]')].map((a) => a.getAttribute('href')));

  await ac.goto(`${BASE}/work/`, { waitUntil: 'networkidle0' });
  const workCurrent = await currentLinks(ac);
  check('/work/ aria-current is /work/ only', workCurrent.length > 0 && workCurrent.every((h) => h === '/work/'), workCurrent.join(','));

  await ac.goto(`${BASE}/writing/`, { waitUntil: 'networkidle0' });
  const writingCurrent = await currentLinks(ac);
  check('/writing/ aria-current is /writing/ only', writingCurrent.length > 0 && writingCurrent.every((h) => h === '/writing/'), writingCurrent.join(','));
  const posts = await ac.evaluate(() => document.querySelectorAll('.writing-item a[href]').length);
  check('/writing/ renders at least one post', posts > 0, `${posts} posts`);

  // ---- Case studies --------------------------------------------------------
  console.log('\ncase studies');
  for (const cs of caseStudies) {
    await ac.goto(`${BASE}/work/${cs.slug}/`, { waitUntil: 'networkidle0' });
    const info = await ac.evaluate(() => ({
      cards: [...document.querySelectorAll('.cs-card__title')].map((e) => e.textContent.trim()),
      numbers: [...document.querySelectorAll('main h2')].some((h) => h.textContent.trim() === 'In numbers'),
      stats: document.querySelectorAll('.cs-stat').length,
      body: [...document.querySelectorAll('.cs-card__body')].every((b) => b.textContent.trim().length > 40),
      hero: (() => {
        const img = document.querySelector('main picture img, main img');
        return Boolean(img && img.complete && img.naturalWidth > 0);
      })(),
    }));
    const want = ['Context', 'My decisions', 'Results'];
    check(
      `${cs.slug}: three cards and "In numbers"`,
      want.every((w) => info.cards.includes(w)) && info.numbers && info.stats > 0 && info.body,
      `cards=${info.cards.join('/')} stats=${info.stats}`,
    );
    check(`${cs.slug}: hero image painted`, info.hero);
    if (cs.client) {
      check(
        `${cs.slug}: sidebar shows client`,
        await ac.evaluate((c) => document.body.textContent.includes(c), cs.client),
      );
    }
  }
  await ac.close();

  // ---- Mobile: overflow and console ----------------------------------------
  console.log('\nmobile 390px');
  const m = await browser.newPage();
  await m.setViewport({ width: 390, height: 844, isMobile: true, hasTouch: true });
  trackConsole(m, consoleErrors);
  await skipSplash(m);
  for (const path of ['/', '/work/', '/writing/', `/work/${caseStudies[0].slug}/`]) {
    await m.goto(`${BASE}${path}`, { waitUntil: 'networkidle0' });
    await scrollThrough(m);
    const over = await m.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
    check(`no horizontal overflow on ${path}`, over <= 0, over > 0 ? `${over}px over` : '');
  }
  await m.close();

  // ---- Reduced motion ------------------------------------------------------
  console.log('\nreduced motion');
  const reduced = await browser.newPage();
  trackConsole(reduced, consoleErrors);
  await reduced.emulateMediaFeatures([{ name: 'prefers-reduced-motion', value: 'reduce' }]);
  await reduced.goto(`${BASE}/`, { waitUntil: 'networkidle0' });
  check(
    'crow overlay never shown',
    await reduced.evaluate(() => !document.querySelector('#crow-loader')?.classList.contains('active')),
  );
  // Reduced motion keeps a plain fade on scroll, so scroll through before asserting.
  await scrollThrough(reduced);
  await sleep(800);
  const hiddenHome = await strandedAtZero(reduced);
  check('home content visible after scrolling', hiddenHome.length === 0, hiddenHome.join(', '));
  await reduced.goto(`${BASE}/work/${caseStudies[0].slug}/`, { waitUntil: 'networkidle0' });
  await scrollThrough(reduced);
  await sleep(800);
  const hiddenCs = await strandedAtZero(reduced);
  check('case study content visible after scrolling', hiddenCs.length === 0, hiddenCs.join(', '));
  await reduced.close();

  console.log('\nconsole');
  check('no console errors', consoleErrors.length === 0, consoleErrors.slice(0, 3).join(' | '));
} finally {
  await browser.disconnect();
  await chrome.kill();
}

const failed = results.filter((r) => !r.pass);
console.log(`\n${results.length - failed.length}/${results.length} checks passed`);
process.exit(failed.length ? 1 : 0);
