/**
 * JS pipeline: esbuild bundles the TypeScript entry (GSAP + theme animations)
 * to an ES module. Run with --watch during development.
 */

import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import * as esbuild from 'esbuild';

const __dirname = dirname(fileURLToPath(import.meta.url));
const ROOT = resolve(__dirname, '..');
const watching = process.argv.includes('--watch');

const options = {
  entryPoints: [resolve(ROOT, 'src/assets/ts/main.ts')],
  outfile: resolve(ROOT, '_site/assets/js/main.js'),
  bundle: true,
  format: 'esm',
  target: ['es2020'],
  minify: !watching,
  sourcemap: watching,
  logLevel: 'info',
};

if (watching) {
  const context = await esbuild.context(options);
  await context.watch();
  console.log('js   watching…');
} else {
  await esbuild.build(options);
}
