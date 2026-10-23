/**
 * Nav marker: a 3px bar that rests under the current page's link and glides to
 * whichever link is hovered (fine pointers only) or keyboard-focused, then back
 * on leave. With no current page (the homepage) it is hidden at rest.
 *
 * Motion lives in CSS (_flourishes.scss), so reduced motion is handled there:
 * the bar still moves, it just doesn't travel.
 */

import { hasFinePointer, queryAll } from './env';

function setupList(list: HTMLElement): void {
  const bar = list.querySelector<HTMLElement>('.nav-glide__bar');
  if (!bar) return;

  const links = queryAll<HTMLAnchorElement>('a', list);
  const current = links.find((link) => link.getAttribute('aria-current') === 'page') ?? null;
  let target: HTMLAnchorElement | null = null;

  const place = (link: HTMLAnchorElement | null, instant = false): void => {
    target = link;
    if (!link) {
      bar.classList.remove('is-visible');
      return;
    }

    // Coming from hidden (or remeasuring), jump straight to the link rather than
    // sliding across from wherever the bar last was.
    const jump = instant || !bar.classList.contains('is-visible');
    if (jump) bar.classList.add('is-instant');

    bar.style.setProperty('--glide-x', `${link.offsetLeft}px`);
    bar.style.setProperty('--glide-w', String(link.offsetWidth));

    if (jump) {
      void bar.offsetWidth;
      bar.classList.remove('is-instant');
    }
    bar.classList.add('is-visible');
  };

  const rest = (): void => place(current);

  if (hasFinePointer()) {
    for (const link of links) {
      link.addEventListener('pointerenter', () => place(link));
    }
    list.addEventListener('pointerleave', () => {
      const focused = links.find((link) => link === document.activeElement && link.matches(':focus-visible'));
      place(focused ?? current);
    });
  }

  list.addEventListener('focusin', (event) => {
    const link = event.target as HTMLElement;
    if (link instanceof HTMLAnchorElement && link.matches(':focus-visible')) place(link);
  });
  list.addEventListener('focusout', (event) => {
    if (!list.contains(event.relatedTarget as Node | null)) rest();
  });

  // Link widths settle once the webfonts load, and shift on resize.
  const remeasure = (): void => {
    if (target) place(target, true);
  };
  window.addEventListener('resize', remeasure, { passive: true });
  if ('fonts' in document) void document.fonts.ready.then(remeasure);

  // First placement takes over from the CSS underline, so it shouldn't fade in.
  bar.style.transition = 'none';
  rest();
  list.classList.add('is-ready');
  void bar.offsetWidth;
  bar.style.transition = '';
}

export function setupNavGlide(): void {
  queryAll<HTMLElement>('[data-nav-glide]').forEach(setupList);
}
