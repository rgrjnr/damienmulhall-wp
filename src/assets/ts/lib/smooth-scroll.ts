/**
 * Anchor-link scrolling on native browser scroll.
 *
 * ScrollSmoother used to own scrolling here. It was dropped in favour of the
 * browser's own scroll: lighter, never floaty on trackpads, and it keeps
 * position: fixed and keyboard scrolling behaving as visitors expect.
 */

import { queryAll } from './env';

export function scrollToElement(target: Element, animate: boolean): void {
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
      window.history.replaceState(window.history.state, '', href);
    });
  });
}
