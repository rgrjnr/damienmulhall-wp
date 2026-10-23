/**
 * Slim header that slides back in when the visitor scrolls up, and gets out of
 * the way again as soon as they carry on reading down. It stays hidden near
 * the top, where the full header is already on screen.
 */

import { query } from './env';

const TOP_ZONE = 400;
// Ignore trackpad jitter: only a deliberate scroll changes the state.
const THRESHOLD = 6;

export function setupScrollNav(): void {
  const bar = query<HTMLElement>('[data-scroll-nav]');
  if (!bar) return;

  let lastY = window.scrollY;
  let ticking = false;

  const update = (): void => {
    ticking = false;
    const y = window.scrollY;

    if (y < TOP_ZONE) {
      bar.classList.remove('is-visible');
    } else if (y < lastY - THRESHOLD) {
      bar.classList.add('is-visible');
    } else if (y > lastY + THRESHOLD) {
      bar.classList.remove('is-visible');
    } else {
      return;
    }
    lastY = y;
  };

  window.addEventListener(
    'scroll',
    () => {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(update);
    },
    { passive: true },
  );
}
