/**
 * Highlight badge icons.
 *
 * The original site used icons8 SVGs (recorded in the attachment manifest as
 * icons8-mic.svg, icons8-spotify.svg, …). Those binaries died with the server, and
 * icons8 assets carry an attribution requirement, so these are drawn in-house to
 * the same names and the same 24x24 grid.
 *
 * Icons are solid black — the badge component recolours them to white with
 * `filter: brightness(0) invert(1)` on darker background swatches.
 *
 * Existing files are never overwritten: where a real icons8 original was supplied
 * it stays put, and only the gaps get drawn.
 *
 * Usage: node tools/build-icons.mjs
 */

import { existsSync, mkdirSync, writeFileSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const OUT = resolve(dirname(fileURLToPath(import.meta.url)), '../src/assets/icons');

/** Path data only — everything shares one 24x24 viewBox. */
const ICONS = {
  mic: '<path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M6 11a1 1 0 0 0-2 0 8 8 0 0 0 7 7.94V21H8a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2h-3v-2.06A8 8 0 0 0 20 11a1 1 0 0 0-2 0 6 6 0 0 1-12 0z"/>',
  spotify:
    '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm4.35 14.43a.75.75 0 0 1-1.03.26c-2.83-1.72-6.39-2.11-10.59-1.16a.75.75 0 1 1-.33-1.46c4.58-1.04 8.52-.59 11.69 1.34.35.21.46.67.26 1.02zm1.4-3.03a.94.94 0 0 1-1.29.31c-3.24-1.99-8.17-2.57-12-1.4a.94.94 0 1 1-.54-1.79c4.37-1.33 9.81-.69 13.52 1.59.44.27.58.85.31 1.29zm.12-3.16C14.03 8.03 7.9 7.82 4.19 8.95a1.12 1.12 0 1 1-.65-2.15C7.8 5.5 14.57 5.75 19.1 8.44a1.12 1.12 0 1 1-1.15 1.93z"/>',
  megaphone:
    '<path d="M20 4.5a1 1 0 0 0-1.57-.82L10.7 9H7a4 4 0 0 0-1 7.87V20a1 1 0 0 0 1 1h2.5a1 1 0 0 0 1-1v-2.87l7.93 5.32A1 1 0 0 0 20 21.5zM8.5 19H8v-2h.5z"/>',
  movie:
    '<path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm2 2v2h2V5zm0 5v4h14v-4zm0 7v2h2v-2zm12 0v2h2v-2zM17 5v2h2V5z"/>',
  star: '<path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/>',
  heart:
    '<path d="M12 21s-8-4.94-8-10.5A4.5 4.5 0 0 1 12 7a4.5 4.5 0 0 1 8 3.5C20 16.06 12 21 12 21z"/>',
  increase:
    '<path d="M3 20a1 1 0 0 1-1-1V5a1 1 0 0 1 2 0v13h17a1 1 0 0 1 0 2z"/><path d="M21 6h-5a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V7.4l-6.3 6.3a1 1 0 0 1-1.4 0L10 11.4l-3.3 3.3a1 1 0 1 1-1.4-1.4l4-4a1 1 0 0 1 1.4 0l2.3 2.3z"/>',
  education:
    '<path d="M12 3 1 8l11 5 9-4.09V15a1 1 0 0 0 2 0V8zM5 13.18v3.32c0 .76.43 1.45 1.1 1.79A12.6 12.6 0 0 0 12 19.5c2.1 0 4.11-.42 5.9-1.21A2 2 0 0 0 19 16.5v-3.32l-7 3.18z"/>',
  code: '<path d="M9.4 16.6 4.8 12l4.6-4.6a1 1 0 1 0-1.4-1.4l-5.3 5.3a1 1 0 0 0 0 1.4l5.3 5.3a1 1 0 0 0 1.4-1.4zm5.2 0 4.6-4.6-4.6-4.6a1 1 0 1 1 1.4-1.4l5.3 5.3a1 1 0 0 1 0 1.4l-5.3 5.3a1 1 0 0 1-1.4-1.4z"/>',
  '4k': '<path d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm5.5 3.5a.9.9 0 0 0-.9.9v2.7H6.4V9.4a.9.9 0 0 0-1.8 0v3.6c0 .5.4.9.9.9h2.1v1.1a.9.9 0 0 0 1.8 0V9.4a.9.9 0 0 0-.9-.9zm4.6 0a.9.9 0 0 0-.9.9v5.6a.9.9 0 0 0 1.8 0v-1.6l.7-.7 1.6 2.7a.9.9 0 1 0 1.5-.9l-1.9-3.1 1.7-1.7a.9.9 0 0 0-1.3-1.3L14 11.1V9.4a.9.9 0 0 0-.9-.9z"/>',
  'my-computer':
    '<path d="M3 4h18a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1zm1 2v8h16V6z"/><path d="M8 18h8a1 1 0 0 1 1 1v1H7v-1a1 1 0 0 1 1-1z"/>',
  'video-card':
    '<path d="M2 6h16a1 1 0 0 1 1 1v3h2a1 1 0 0 1 0 2h-2v2h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-1 1H6v-2h11V8H2zM2 8h2v12H2z"/><circle cx="10" cy="12" r="3"/>',
  instagram:
    '<path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm5 3.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9zm0 2a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM17.8 6a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4z"/>',
};

mkdirSync(OUT, { recursive: true });

let drawn = 0;

for (const [name, paths] of Object.entries(ICONS)) {
  const target = resolve(OUT, `icons8-${name}.svg`);
  if (existsSync(target)) continue;
  const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#000" role="img"><title>${name}</title>${paths}</svg>\n`;
  writeFileSync(target, svg);
  drawn += 1;
}

console.log(`✓ ${drawn} icons drawn, ${Object.keys(ICONS).length - drawn} originals left untouched`);
