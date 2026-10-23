/**
 * Click the footer email to copy it: a "Copied" stamp lands on it and screen
 * readers hear a status message. Touch devices keep the plain mailto link,
 * where opening the mail app is what people expect.
 */

import { hasFinePointer, query, queryAll } from './env';

const STAMP_MS = 1600;

export function setupCopyEmail(): void {
  if (!hasFinePointer() || !navigator.clipboard) return;

  const status = query<HTMLElement>('[data-copy-status]');

  queryAll<HTMLAnchorElement>('[data-copy]').forEach((link) => {
    let timer = 0;

    link.addEventListener('click', (event) => {
      if (event.metaKey || event.ctrlKey || event.shiftKey) return;
      event.preventDefault();

      navigator.clipboard.writeText(link.dataset.copy ?? '').then(
        () => {
          const stamp = query<HTMLElement>('.copy-email__stamp', link);
          stamp?.style.setProperty('--stamp-rotate', `${Math.round((Math.random() - 0.5) * 24)}deg`);

          // Restart the stamp even on a quick second click.
          link.classList.remove('is-copied');
          void link.offsetWidth;
          link.classList.add('is-copied');
          if (status) status.textContent = 'Email address copied';

          window.clearTimeout(timer);
          timer = window.setTimeout(() => {
            link.classList.remove('is-copied');
            if (status) status.textContent = '';
          }, STAMP_MS);
        },
        () => {
          // Clipboard refused (permissions, insecure origin): fall back to mail.
          window.location.href = link.href;
        },
      );
    });
  });
}
