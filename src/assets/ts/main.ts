/**
 * Theme animations for the static (Eleventy) build.
 *
 * Ported from the WordPress theme's `assets/ts/main.ts`. The AJAX/SPA page
 * navigation layer is deliberately gone — this site is static, real navigations
 * are already instant, and the fetch/innerHTML swap fought ScrollSmoother.
 * What remains: ScrollSmoother, the hero SplitText reveal, scroll reveals, the
 * `.work-item` hover choreography, the crow overlay, and anchor scrolling.
 */

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';
import { ScrollSmoother } from 'gsap/ScrollSmoother';

import { prefersReducedMotion, safely, yieldToMain } from './lib/env';
import { setupMobileMenu } from './lib/mobile-menu';
import { setupCrowLoader } from './lib/crow-loader';
import { setupHeroText } from './lib/hero-text';
import { forceVisible, setupReveals, setupRotations } from './lib/reveals';
import {
  getSmoother,
  handleInitialHash,
  setupAnchorLinks,
  setupSmoothScroll,
} from './lib/smooth-scroll';
import { setupWorkItems } from './lib/work-items';

declare global {
  interface Window {
    smoother: ScrollSmoother | null;
  }
}

/** Plugin registration is itself fail-safe: without it we degrade to static. */
function registerPlugins(): boolean {
  try {
    gsap.registerPlugin(ScrollTrigger, SplitText, ScrollSmoother);
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

  // The mobile menu is not an animation — wire it before any early return so it
  // works regardless of reduced motion or GSAP availability.
  safely('mobile-menu', setupMobileMenu);

  const reduced = prefersReducedMotion();
  const animate = registerPlugins() && !reduced;

  if (!animate) {
    // Reduced motion (or no GSAP): render everything final, no smoother, no
    // SplitText. Anchors still work, just without easing. (The crow splash was
    // already resolved in scheduleBoot.)
    safely('force-visible', forceVisible);
    safely('anchor-links', () => setupAnchorLinks(false));
    safely('initial-hash', () => handleInitialHash(false));
    return;
  }

  // Each step yields to the main thread afterwards. Run as one block these total
  // ~200ms of blocking time on a throttled mobile CPU, which is long enough to
  // hurt responsiveness; chunked, no single task is long enough to be counted.
  const steps: Array<[string, () => void]> = [
    ['smooth-scroll', () => setupSmoothScroll(true)],
    ['hero-text', () => setupHeroText(true)],
    ['reveals', () => setupReveals(true)],
    ['rotations', () => setupRotations(true)],
    ['work-items', () => setupWorkItems(true)],
    ['anchor-links', () => setupAnchorLinks(true)],
    ['initial-hash', () => handleInitialHash(true)],
    ['scroll-trigger-refresh', scheduleRefreshes],
  ];

  for (const [name, step] of steps) {
    safely(name, step);
    await yieldToMain();
  }

  // Handy for debugging in the console; harmless in production.
  window.smoother = getSmoother();
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
 * Registering the GSAP plugins and building the ScrollSmoother/ScrollTrigger graph
 * is one long task. Run it synchronously after DOMContentLoaded and the browser
 * has no paint opportunity until it finishes — on a throttled mobile CPU that
 * pushed LCP from 1.9s to 6.4s, entirely in render delay. Waiting for a rendered
 * frame (rAF, then a macrotask so the paint actually commits) costs nothing
 * perceptible and lets the hero paint on time.
 *
 * `body.loaded` is applied immediately so nothing depends on the deferred work.
 */
function scheduleBoot(): void {
  document.body.classList.add('loaded');
  // Resolve the intro splash immediately — not behind the deferred GSAP graph —
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
