/**
 * Mobile navigation toggle.
 *
 * Runs independently of GSAP — it must work even when animations are disabled,
 * reduced-motion is on, or plugin registration fails. Pure display toggle driven
 * by the `.is-open` class defined in `_site.scss`.
 */

import { query, queryAll } from './env';

export function setupMobileMenu(): void {
  const toggle = query<HTMLButtonElement>('#mobile-menu-toggle');
  const menu = query<HTMLElement>('#mobile-menu');
  if (!toggle || !menu) return;

  const setOpen = (open: boolean): void => {
    menu.classList.toggle('is-open', open);
    menu.setAttribute('aria-hidden', String(!open));
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  };

  toggle.addEventListener('click', () => {
    setOpen(!menu.classList.contains('is-open'));
  });

  // Choosing a destination or pressing Escape closes the panel.
  for (const link of queryAll<HTMLAnchorElement>('a', menu)) {
    link.addEventListener('click', () => setOpen(false));
  }

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menu.classList.contains('is-open')) {
      setOpen(false);
      toggle.focus();
    }
  });
}
