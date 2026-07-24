# Fonts

The site uses **Neue Haas Grotesk** (Display and Text), self-hosted from `src/assets/fonts/`.

## Files currently in place

| File | Used for |
| --- | --- |
| `NeueHaasGroteskDisplay-SemiBold-600.woff2` | all `font-haas-display` text (weights 500–700) |
| `NeueHaasGroteskText-Regular-400.woff2` | `font-haas-text` weights 400–500 |
| `NeueHaasGroteskText-Italic-400.woff2` | italic body text |
| `NeueHaasGroteskText-Bold-700.woff2` | `font-haas-text` weights 600–700 |
| `NeueHaasGroteskText-BoldItalic-700.woff2` | bold italic body text |

`@font-face` declarations are in `src/assets/scss/_fonts.scss`. They use **weight ranges** rather than single values, so the available files answer for neighbouring weights instead of the browser synthesising a fake bold.

## Known gaps

Two weights the original design used are not present:

- **Display Medium 500** — services grid, work item titles, section headings
- **Display Bold 700** — the hero `<h1>` (84px) and the CTA heading

Both currently render from the SemiBold 600 file. The hero headline therefore reads slightly lighter than the WordPress original. Adding `NeueHaasGroteskDisplay-Medium-500.woff2` and `NeueHaasGroteskDisplay-Bold-700.woff2` to `src/assets/fonts/` and splitting the Display rule in `_fonts.scss` into three would restore it exactly.

**Text Medium 500** is likewise served by the Regular 400 file.

## Licensing

The files in `src/assets/fonts/` were supplied from Adobe Fonts–served originals (`copyright: Monotype Imaging Inc.`, EULA at `https://fonts.adobe.com/eulas/`). That licence covers web use **served from Adobe's CDN**, not self-hosting.

Before this site is public on a custom domain, either:

1. buy a webfont licence for Neue Haas Grotesk (Monotype / Linotype) and drop the licensed woff2 files in at the same filenames — no code change needed; or
2. revert to the Adobe Fonts embed by adding `<link rel="stylesheet" href="https://use.typekit.net/utx2cks.css">` to `src/_includes/layouts/base.njk` and changing the two font family names in `tailwind.config.js` and `src/assets/scss/_variables.scss` back to `neue-haas-grotesk-display` / `neue-haas-grotesk-text`.

The `Neue_Haas_Grotesk_Collection/` folder in the repository root contains **trial** fonts (Commercial Type, `-Trial.otf`). Those are for evaluation only and are not used by the build. They should not be deployed.
