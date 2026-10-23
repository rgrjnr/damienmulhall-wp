/**
 * Theme animations for the static (Eleventy) build.
 *
 * Ported from the WordPress theme's `assets/ts/main.ts`. The AJAX/SPA page
 * navigation layer is deliberately gone: this site is static and real
 * navigations are already instant. Scrolling is the browser's own.
 * What remains: the hero SplitText reveal and scribble, scroll reveals, stat
 * counters, the logo marquee, the `.work-item` hover choreography, the crow
 * overlay and hover caw, the scroll-up header, copy-to-clipboard and anchor scrolling.
 */

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';

import { prefersReducedMotion, safely, yieldToMain } from './lib/env';
import { setupMobileMenu } from './lib/mobile-menu';
import { setupCrowLoader } from './lib/crow-loader';
import { setupHeroText } from './lib/hero-text';
import { forceVisible, setupReveals, setupRotations } from './lib/reveals';
import { setupAnchorLinks } from './lib/smooth-scroll';
import { setupWorkItems } from './lib/work-items';
import { setupCounters } from './lib/counters';
import { setupMarquee } from './lib/marquee';
import { setupCopyEmail } from './lib/copy-email';
import { setupScrollNav } from './lib/scroll-nav';
import { setupNavGlide } from './lib/nav-glide';
import { setupReceipts } from './lib/receipts';
import { setupCrowCaw } from './lib/crow-caw';

/** Plugin registration is itself fail-safe: without it we degrade to static. */
function registerPlugins(): boolean {
  try {
    gsap.registerPlugin(ScrollTrigger, SplitText);
    return true;
  } catch (error) {
    console.warn('[animations] GSAP plugin registration failed; running unanimated.', error);
    return false;
  }
}

/** One refresh after setup, one more once webfonts have settled the layout. */
function scheduleRefreshes(): void {
  ScrollTrigger.refresh();

  if ('fonts' in document) {
    void document.fonts.ready.then(() => {
      ScrollTrigger.refresh();
    });
  }
}

async function start(): Promise<void> {
  // `body.loaded` is the CSS escape hatch that puts every `.fade-in` /
  // `.scale-in` / `.slide-*` element into its final visible state. Set it first
  // so a later failure can never leave the page blank.
  document.body.classList.add('loaded');
  document.body.classList.remove('loading');

  // None of these are animations in their own right. Wire them before any
  // early return so they work regardless of reduced motion or GSAP.
  safely('mobile-menu', setupMobileMenu);
  safely('scroll-nav', setupScrollNav);
  safely('nav-glide', setupNavGlide);
  safely('copy-email', setupCopyEmail);
  safely('receipts', setupReceipts);

  const reduced = prefersReducedMotion();
  safely('crow-caw', () => setupCrowCaw(!reduced));

  if (!registerPlugins()) {
    safely('force-visible', forceVisible);
    safely('anchor-links', () => setupAnchorLinks(false));
    return;
  }

  // Reduced motion gets the gentle version: reveals become plain fades, and
  // everything that moves (text rise, counters, marquee, rotations) is skipped.
  const animate = !reduced;

  // Each step yields to the main thread afterwards. Run as one block these total
  // ~200ms of blocking time on a throttled mobile CPU, which is long enough to
  // hurt responsiveness; chunked, no single task is long enough to be counted.
  const steps: Array<[string, () => void]> = [
    ['hero-text', () => setupHeroText(animate)],
    ['reveals', () => setupReveals(animate ? 'full' : 'gentle')],
    ['counters', () => setupCounters(animate)],
    ['marquee', () => setupMarquee(animate)],
    ['rotations', () => setupRotations(animate)],
    ['work-items', () => setupWorkItems(animate)],
    ['anchor-links', () => setupAnchorLinks(animate)],
    ['scroll-trigger-refresh', scheduleRefreshes],
  ];

  for (const [name, step] of steps) {
    safely(name, step);
    await yieldToMain();
  }
}

/** Last line of defence: whatever failed, the page must end up readable. */
function onBootFailure(error: unknown): void {
  console.error('[animations] setup failed; falling back to a static page.', error);
  document.body.classList.add('loaded');
  safely('force-visible', forceVisible);
}

function boot(): void {
  try {
    void start().catch(onBootFailure);
  } catch (error) {
    onBootFailure(error);
  }
}

/**
 * Yield a frame before booting.
 *
 * Registering the GSAP plugins and building the ScrollTrigger graph is one long
 * task. Run it synchronously after DOMContentLoaded and the browser has no
 * paint opportunity until it finishes. On a throttled mobile CPU that pushed
 * LCP from 1.9s to 6.4s, entirely in render delay. Waiting for a rendered frame
 * (rAF, then a macrotask so the paint actually commits) costs nothing
 * perceptible and lets the hero paint on time.
 *
 * `body.loaded` is applied immediately so nothing depends on the deferred work.
 */
function scheduleBoot(): void {
  document.body.classList.add('loaded');
  // Resolve the intro splash immediately, not behind the deferred GSAP graph,
  // so on a first visit it covers the page promptly rather than flashing in late.
  safely('crow-loader', () => setupCrowLoader(!prefersReducedMotion()));
  requestAnimationFrame(() => {
    window.setTimeout(boot, 0);
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', scheduleBoot, { once: true });
} else {
  scheduleBoot();
}
