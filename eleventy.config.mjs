import { existsSync } from 'node:fs';
import { resolve, dirname, extname } from 'node:path';
import { fileURLToPath } from 'node:url';
import Image from '@11ty/eleventy-img';
import feedPlugin from '@11ty/eleventy-plugin-rss';
import { minify } from 'html-minifier-terser';

const __dirname = dirname(fileURLToPath(import.meta.url));
const isProduction = process.env.NODE_ENV === 'production';

/** Widths we actually render at; the hero frame is 1120px wide at most. */
const IMAGE_WIDTHS = [480, 768, 1120, 1600];

/**
 * Responsive <picture> from a site-absolute path. Falls back to a plain <img> with
 * the placeholder class when the file is missing — the server was lost without
 * backups, so many originals do not exist yet (see MISSING-ASSETS.md).
 */
async function responsiveImage(src, alt = '', options = {}) {
  const { sizes = '100vw', className = '', eager = false } = options;
  const onDisk = resolve(__dirname, 'src', src.replace(/^\//, ''));

  const attributes = [
    `alt="${alt.replace(/"/g, '&quot;')}"`,
    `class="${className}"`.trim(),
    `loading="${eager ? 'eager' : 'lazy'}"`,
    `decoding="async"`,
    eager ? 'fetchpriority="high"' : '',
  ]
    .filter(Boolean)
    .join(' ');

  if (!existsSync(onDisk) || extname(onDisk).toLowerCase() === '.svg') {
    return `<img src="${src}" ${attributes} width="1120" height="630">`;
  }

  const metadata = await Image(onDisk, {
    widths: [...IMAGE_WIDTHS, null],
    formats: ['avif', 'webp', 'jpeg'],
    outputDir: resolve(__dirname, '_site/assets/img/'),
    urlPath: '/assets/img/',
    sharpOptions: { animated: false },
  });

  return Image.generateHTML(metadata, {
    alt,
    sizes,
    class: className,
    loading: eager ? 'eager' : 'lazy',
    decoding: 'async',
    ...(eager ? { fetchpriority: 'high' } : {}),
  });
}

export default function (eleventyConfig) {
  eleventyConfig.addPlugin(feedPlugin);

  eleventyConfig.addPassthroughCopy({ 'src/assets/fonts': 'assets/fonts' });
  eleventyConfig.addPassthroughCopy({ 'src/assets/icons': 'assets/icons' });
  eleventyConfig.addPassthroughCopy({ 'src/assets/images': 'assets/images' });
  eleventyConfig.addPassthroughCopy({ 'src/assets/files': 'assets/files' });
  eleventyConfig.addPassthroughCopy({ 'src/robots.txt': 'robots.txt' });

  // The CSS and JS pipelines write straight into _site; watch them for reloads.
  eleventyConfig.addWatchTarget('src/assets/scss/');
  eleventyConfig.addWatchTarget('src/assets/ts/');
  eleventyConfig.setServerOptions({ watch: ['_site/assets/css/*.css', '_site/assets/js/*.js'] });

  eleventyConfig.addAsyncShortcode('image', responsiveImage);

  // Markdown images in case study bodies get the same responsive treatment.
  eleventyConfig.addTransform('responsiveMarkdownImages', async function (content) {
    if (!this.page.outputPath?.endsWith('.html')) return content;

    const matches = [...content.matchAll(/<img src="(\/assets\/images\/[^"]+)"([^>]*)>/g)];
    let output = content;
    for (const [tag, src, rest] of matches) {
      if (rest.includes('data-raw')) continue;
      const alt = /alt="([^"]*)"/.exec(rest)?.[1] ?? '';
      output = output.replace(tag, await responsiveImage(src, alt, { sizes: '(min-width: 1120px) 720px, 100vw' }));
    }
    return output;
  });

  eleventyConfig.addCollection('work', (collectionApi) =>
    collectionApi
      .getFilteredByGlob('src/work/*.md')
      .sort((a, b) => (a.data.order ?? 0) - (b.data.order ?? 0)),
  );

  eleventyConfig.addFilter('year', (value) => new Date(value).getFullYear());
  eleventyConfig.addFilter('isoDate', (value) => new Date(value).toISOString());

  eleventyConfig.addFilter('absoluteUrl', (path, base) => new URL(path, base).href);

  if (isProduction) {
    eleventyConfig.addTransform('minifyHtml', async function (content) {
      if (!this.page.outputPath?.endsWith('.html')) return content;
      return minify(content, {
        collapseWhitespace: true,
        removeComments: true,
        minifyCSS: true,
        minifyJS: true,
sortAttributes: true,
        sortClassName: true,
      });
    });
  }

  return {
    dir: {
      input: 'src',
      output: '_site',
      includes: '_includes',
      data: '_data',
    },
    markdownTemplateEngine: 'njk',
    htmlTemplateEngine: 'njk',
    templateFormats: ['njk', 'md', 'html'],
  };
}
