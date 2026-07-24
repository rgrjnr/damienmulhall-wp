/**
 * CSS pipeline: Sass -> Tailwind -> autoprefixer -> cssnano.
 *
 * Sass passes the @tailwind at-rules through untouched, so PostCSS can expand them
 * afterwards. Run with --watch during development.
 */

import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import * as sass from 'sass';
import postcss from 'postcss';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';

const __dirname = dirname(fileURLToPath(import.meta.url));
const ROOT = resolve(__dirname, '..');
const ENTRY = resolve(ROOT, 'src/assets/scss/main.scss');
const OUT = resolve(ROOT, '_site/assets/css/main.css');

const isProduction = process.env.NODE_ENV === 'production' || !process.argv.includes('--watch');

const plugins = [tailwindcss, autoprefixer];
if (isProduction) plugins.push(cssnano({ preset: 'default' }));

async function build() {
  const started = Date.now();
  const compiled = sass.compile(ENTRY, {
    loadPaths: [resolve(ROOT, 'src/assets/scss')],
    style: 'expanded',
    quietDeps: true,
  });

  const result = await postcss(plugins).process(compiled.css, { from: ENTRY, to: OUT });

  mkdirSync(dirname(OUT), { recursive: true });
  writeFileSync(OUT, result.css);
  console.log(`css  ${(result.css.length / 1024).toFixed(1)} kB  ${Date.now() - started}ms`);
}

await build();

if (process.argv.includes('--watch')) {
  const { watch } = await import('node:fs');
  const watched = [resolve(ROOT, 'src/assets/scss'), resolve(ROOT, 'src')];
  let queued;
  for (const dir of watched) {
    watch(dir, { recursive: true }, () => {
      clearTimeout(queued);
      queued = setTimeout(() => build().catch((error) => console.error(error.message)), 80);
    });
  }
  console.log('css  watching…');
}
