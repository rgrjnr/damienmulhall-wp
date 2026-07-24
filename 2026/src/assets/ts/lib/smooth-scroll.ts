/**
 * ScrollSmoother setup plus anchor-link scrolling.
 *
 * This is a static site: real navigations are browser navigations. The only
 * scripted scrolling left is in-page anchors and the hash present on first load.
 */

import { ScrollSmoother } from 'gsap/ScrollSmoother';
import { query, queryAll } from './env';

let smoother: ScrollSmoother | null = null;

export function getSmoother(): ScrollSmoother | null {
  return smoother;
}

export function setupSmoothScroll(enabled: boolean): void {
  if (!enabled) return;

  const wrapper = query<HTMLElement>('#smooth-wrapper');
  const content = query<HTMLElement>('#smooth-content');
  if (!wrapper || !content) return;

  smoother = ScrollSmoother.create({
    wrapper,
    content,
    smooth: 1.5,
    effects: true,
    normalizeScroll: true,
    smoothTouch: 0.1,
    ignoreMobileResize: true,
  });
}

/** Scrolls to an element through ScrollSmoother when present, natively otherwise. */
export function scrollToElement(target: Element, animate: boolean): void {
  if (smoother) {
    smoother.scrollTo(target, animate, 'top top');
    return;
  }
  target.scrollIntoView({ behavior: animate ? 'smooth' : 'auto', block: 'start' });
}

/** Resolves a `#foo` href to an element, tolerating ids that are not valid selectors. */
function resolveHash(hash: string): Element | null {
  const id = hash.slice(1);
  if (!id) return null;
  try {
    return document.querySelector(hash) ?? document.getElementById(id);
  } catch {
    return document.getElementById(id);
  }
}

export function setupAnchorLinks(animate: boolean): void {
  queryAll<HTMLAnchorElement>('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', (event: MouseEvent) => {
      if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey) return;

      const href = link.getAttribute('href');
      if (!href || href === '#') return;

      const target = resolveHash(href);
      if (!target) return;

      event.preventDefault();
      scrollToElement(target, animate);
      // Keep the URL shareable without letting the browser jump the scroller.
      window.history.replaceState(window.history.state, '', href);
    });
  });
}

/** Honours a `#section` already present in the URL on first load. */
export function handleInitialHash(animate: boolean): void {
  const { hash } = window.location;
  if (!hash) return;

  window.setTimeout(() => {
    const target = resolveHash(hash);
    if (target) scrollToElement(target, animate);
  }, 100);
}
