/**
 * The crow overlay — a first-visit intro splash.
 *
 * On the old WordPress site this covered AJAX page loads. The static site has no
 * such delay, so it is repurposed as a deliberate branding moment: on the first
 * page view of a session it holds full-screen for ~1.5s, then fades to the page.
 * Later navigations in the same session skip it, as does reduced motion.
 *
 * It never blocks interaction beyond its hold — a tap dismisses it early — and it
 * always tears itself down.
 */

import { query } from './env';

const HOLD_MS = 1500;
const SESSION_KEY = 'dm-crow-shown';

function seenThisSession(): boolean {
  try {
    return window.sessionStorage.getItem(SESSION_KEY) === '1';
  } catch {
    // sessionStorage can throw in private modes; treat as not-yet-seen.
    return false;
  }
}

function markSeen(): void {
  try {
    window.sessionStorage.setItem(SESSION_KEY, '1');
  } catch {
    // Non-fatal: worst case the splash shows again on the next view.
  }
}

export function setupCrowLoader(enabled: boolean): void {
  const loader = query<HTMLElement>('#crow-loader');
  if (!loader) return;

  const dismiss = (): void => {
    loader.classList.remove('active');
    loader.setAttribute('aria-hidden', 'true');
  };

  // The splash is an intro for the front door only. Deep-linking straight to a
  // case study should not stage a splash over its hero (and it would delay that
  // page's LCP for no reason). Reduced motion and repeat views also skip it.
  const isHomepage = window.location.pathname === '/';
  if (!enabled || !isHomepage || seenThisSession()) {
    dismiss();
    return;
  }

  markSeen();
  loader.classList.add('active');
  loader.setAttribute('aria-hidden', 'true');

  const video = query<HTMLVideoElement>('#crow-video', loader);
  if (video) {
    // play() is best-effort; its rejection is expected when autoplay is blocked.
    void video.play().catch(() => undefined);
  }

  let dismissed = false;
  const dismissOnce = (): void => {
    if (dismissed) return;
    dismissed = true;
    window.clearTimeout(timer);
    window.removeEventListener('pointerdown', dismissOnce);
    dismiss();
  };

  // Deliberate hold, then fade; a tap during the hold dismisses early so the
  // splash can never trap the visitor.
  const timer = window.setTimeout(dismissOnce, HOLD_MS);
  window.addEventListener('pointerdown', dismissOnce, { once: true });
}
