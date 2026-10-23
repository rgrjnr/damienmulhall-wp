/**
 * Receipts: the claims in the homepage tiles reveal their proof.
 *
 * Mouse users get it on hover, keyboard users on focus, touch users on tap.
 * Only one receipt per tile is open at a time. Without this script every
 * proof is simply shown under its line.
 */

import { hasFinePointer, queryAll } from './env';

export function setupReceipts(): void {
  const finePointer = hasFinePointer();

  queryAll<HTMLElement>('[data-receipts]').forEach((tile) => {
    const items = queryAll<HTMLElement>('.receipt-item', tile);
    if (items.length === 0) return;

    tile.classList.add('is-interactive');
    let active: number | null = null;

    const activate = (index: number | null): void => {
      active = index;
      tile.classList.toggle('has-active', index !== null);
      items.forEach((item, i) => {
        const on = i === index;
        item.classList.toggle('is-active', on);
        item.querySelector('.receipt-line')?.setAttribute('aria-expanded', String(on));
      });
    };

    items.forEach((item, i) => {
      const line = item.querySelector<HTMLButtonElement>('.receipt-line');
      if (!line) return;

      if (finePointer) line.addEventListener('pointerenter', () => activate(i));
      // Keyboard focus only: a tap also focuses the button, and the click
      // handler below would then immediately toggle it shut again.
      line.addEventListener('focus', () => {
        if (line.matches(':focus-visible')) activate(i);
      });
      // Tap (and click) toggles, so touch users can close a receipt again.
      line.addEventListener('click', () => {
        if (finePointer) {
          activate(i);
          return;
        }
        activate(active === i ? null : i);
      });
    });

    if (finePointer) tile.addEventListener('pointerleave', () => activate(null));

    tile.addEventListener('focusout', (event) => {
      if (!tile.contains(event.relatedTarget as Node | null)) activate(null);
    });

    tile.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') activate(null);
    });
  });
}
