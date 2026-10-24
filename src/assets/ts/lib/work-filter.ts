/**
 * Category filter on the work index. Each card lists its `categories` in
 * `data-categories`; picking a button hides the cards outside that category.
 * The row ships `hidden`, so with no JS the page is simply the full grid.
 */

import { query, queryAll } from './env';

export function setupWorkFilter(): void {
  const root = query<HTMLElement>('[data-work-filter]');
  if (!root) return;

  const buttons = queryAll<HTMLButtonElement>('[data-filter]', root);
  const cards = queryAll<HTMLElement>('[data-categories]');
  const status = query<HTMLElement>('[data-work-filter-status]', root);

  const apply = (filter: string): void => {
    let shown = 0;
    cards.forEach((card) => {
      const match = filter === 'All' || (card.dataset.categories ?? '').split('|').includes(filter);
      card.hidden = !match;
      if (match) shown += 1;
    });
    buttons.forEach((button) => {
      button.setAttribute('aria-pressed', String(button.dataset.filter === filter));
    });
    if (status) status.textContent = `Showing ${shown} ${shown === 1 ? 'project' : 'projects'}`;
  };

  buttons.forEach((button) => {
    button.addEventListener('click', () => apply(button.dataset.filter ?? 'All'));
  });

  root.hidden = false;
}
