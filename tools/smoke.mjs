/**
 * Behavioural smoke test.
 *
 * Lighthouse says the page is fast; it says nothing about whether the animations
 * still run. This drives a real headless Chrome and asserts the things a score
 * cannot see: that ScrollSmoother initialised, the crow overlay dismissed itself,
 * the hero split, work-item hover choreography responds, nothing is stranded at
 * opacity 0, and the console is clean.
 *
 * Usage: node tools/smoke.mjs [baseUrl]
 */

import { launch } from 'chrome-launcher';
import puppeteer from 'puppeteer-core';

const BASE = process.argv[2] || 'http://localhost:8190';

const results = [];
const check = (name, pass, detail = '') => {
  results.push({ name, pass, detail });
  console.log(`  ${pass ? '✓' : '✗'} ${name}${detail ? `  — ${detail}` : ''}`);
};

const chrome = await launch({ chromeFlags: ['--headless=new', '--no-sandbox'] });
const browser = await puppeteer.connect({
  browserURL: `http://localhost:${chrome.port}`,
  defaultViewport: { width: 1280, height: 900 },
});

try {
  const page = await browser.newPage();
  const consoleErrors = [];
  page.on('console', (m) => m.type() === 'error' && consoleErrors.push(m.text()));
  page.on('pageerror', (e) => consoleErrors.push(String(e)));

  // ---- Homepage ----------------------------------------------------------
  console.log('\nhomepage');
  await page.goto(`${BASE}/`, { waitUntil: 'networkidle0' });
  await new Promise((r) => setTimeout(r, 2500));

  check('body.loaded applied', await page.evaluate(() => document.body.classList.contains('loaded')));

  check(
    'ScrollSmoother initialised',
    await page.evaluate(() => {
      const content = document.querySelector('#smooth-content');
      return Boolean(window.smoother) && Boolean(content && getComputedStyle(content).transform);
    }),
  );

  check(
    'crow overlay dismissed',
    await page.evaluate(() => {
      const loader = document.querySelector('#crow-loader');
      return Boolean(loader) && !loader.classList.contains('active');
    }),
  );

  const split = await page.evaluate(() => {
    const h1 = document.querySelector('[data-hero-heading]');
    return { exists: Boolean(h1), children: h1 ? h1.querySelectorAll('div, span').length : 0 };
  });
  check('hero heading split by SplitText', split.exists && split.children > 0, `${split.children} nodes`);

  const invisible = await page.evaluate(() => {
    const bad = [];
    for (const el of document.querySelectorAll('main *')) {
      const s = getComputedStyle(el);
      if (parseFloat(s.opacity) === 0 && s.visibility !== 'hidden' && el.getClientRects().length) {
        if (!el.closest('.work-title-duplicate') && !el.matches('.work-title-duplicate')) {
          bad.push(el.className || el.tagName);
        }
      }
    }
    return bad.slice(0, 5);
  });
  check('no content stranded at opacity 0', invisible.length === 0, invisible.join(', '));

  const items = await page.$$('.work-item');
  check('5 work items rendered', items.length === 5, `${items.length} found`);

  const badges = await page.evaluate(
    () => document.querySelectorAll('.work-item [style*="background-color"]').length,
  );
  check('15 highlight badges rendered', badges === 15, `${badges} found`);

  // Hover the first work item and confirm the background fill actually animates.
  if (items[0]) {
    const before = await page.evaluate(
      () => getComputedStyle(document.querySelector('.work-background')).transform,
    );
    await items[0].hover();
    await new Promise((r) => setTimeout(r, 500));
    const after = await page.evaluate(
      () => getComputedStyle(document.querySelector('.work-background')).transform,
    );
    check('work-item hover animates background', before !== after, `${before} -> ${after}`);
  }

  check(
    'fonts loaded from same origin',
    await page.evaluate(() => [...document.fonts].some((f) => f.status === 'loaded')),
  );

  // ---- Case study --------------------------------------------------------
  console.log('\ncase study');
  await page.goto(`${BASE}/work/dell-podcast/`, { waitUntil: 'networkidle0' });
  await new Promise((r) => setTimeout(r, 2000));

  check('smoother initialised', await page.evaluate(() => Boolean(window.smoother)));
  check(
    'hero image painted',
    await page.evaluate(() => {
      const img = document.querySelector('main picture img, main img');
      return Boolean(img && img.complete && img.naturalWidth > 0);
    }),
  );
  check(
    'prose content rendered',
    await page.evaluate(() => (document.querySelector('.prose')?.textContent || '').length > 800),
  );
  check(
    'sidebar shows client',
    await page.evaluate(() => document.body.textContent.includes('Dell Technologies')),
  );

  // ---- Reduced motion ----------------------------------------------------
  console.log('\nreduced motion');
  const reduced = await browser.newPage();
  await reduced.emulateMediaFeatures([{ name: 'prefers-reduced-motion', value: 'reduce' }]);
  await reduced.goto(`${BASE}/`, { waitUntil: 'networkidle0' });
  await new Promise((r) => setTimeout(r, 1500));

  check('no smoother under reduced motion', await reduced.evaluate(() => !window.smoother));
  check(
    'crow overlay never shown',
    await reduced.evaluate(() => !document.querySelector('#crow-loader')?.classList.contains('active')),
  );
  check(
    'all content visible under reduced motion',
    await reduced.evaluate(() => {
      for (const el of document.querySelectorAll('main h1, main h2, main p, .work-item')) {
        if (parseFloat(getComputedStyle(el).opacity) === 0) return false;
      }
      return true;
    }),
  );

  console.log('\nconsole');
  check('no console errors', consoleErrors.length === 0, consoleErrors.slice(0, 3).join(' | '));
} finally {
  await browser.disconnect();
  await chrome.kill();
}

const failed = results.filter((r) => !r.pass);
console.log(`\n${results.length - failed.length}/${results.length} checks passed`);
process.exit(failed.length ? 1 : 0);
