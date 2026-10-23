/**
 * Logo wall as a slow marquee.
 *
 * Clones the names until one set is wider than the strip, then doubles that set
 * so a -50% translate loops without a seam. Speed is constant in pixels per
 * second, so it reads the same however many names there are. Clones are hidden
 * from screen readers; the original list still reads once.
 */

import { query } from './env';

const PX_PER_SECOND = 40;

function build(wall: HTMLElement, viewport: HTMLElement, list: HTMLElement, originals: Element[]): void {
  list.replaceChildren(...originals);
  wall.classList.add('is-marquee');

  const setWidth = list.scrollWidth;
  if (setWidth === 0) return;

  const copies = Math.max(1, Math.ceil(viewport.clientWidth / setWidth));
  const cloneSet = (): Element[] =>
    originals.map((item) => {
      const clone = item.cloneNode(true) as HTMLElement;
      clone.setAttribute('aria-hidden', 'true');
      return clone;
    });

  for (let i = 1; i < copies; i += 1) list.append(...cloneSet());
  const half = Array.from(list.children);
  half.forEach((item) => {
    const clone = item.cloneNode(true) as HTMLElement;
    clone.setAttribute('aria-hidden', 'true');
    list.append(clone);
  });

  list.style.setProperty('--marquee-duration', `${((setWidth * copies) / PX_PER_SECOND).toFixed(2)}s`);
}

export function setupMarquee(enabled: boolean): void {
  if (!enabled) return;

  const wall = query<HTMLElement>('.logo-wall');
  const viewport = wall ? query<HTMLElement>('.logo-wall__viewport', wall) : null;
  const list = viewport ? query<HTMLElement>('.logo-wall__list', viewport) : null;
  if (!wall || !viewport || !list) return;

  const originals = Array.from(list.children);
  build(wall, viewport, list, originals);

  let lastWidth = viewport.clientWidth;
  let timer = 0;
  new ResizeObserver(() => {
    if (viewport.clientWidth === lastWidth) return;
    lastWidth = viewport.clientWidth;
    window.clearTimeout(timer);
    timer = window.setTimeout(() => build(wall, viewport, list, originals), 200);
  }).observe(viewport);

  if ('fonts' in document) {
    void document.fonts.ready.then(() => build(wall, viewport, list, originals));
  }
}
