# damienmulhall.com

Static site for Damien Mulhall, creative project manager. Built with [Eleventy](https://www.11ty.dev/), deployed to DigitalOcean App Platform.

Rebuilt from the original WordPress theme after the host was lost. Content was recovered from a `wp_posts` database dump — see `MISSING-ASSETS.md` for what did not survive.

---

## Adding a case study

1. Create a new file in `src/work/`, e.g. `src/work/my-project.md`.
2. Copy this and fill it in:

```markdown
---
title: 'The full project title'
shortTitle: 'Short version for the work list'
excerpt: 'One sentence that appears under the title and in search results.'
client: 'Client name'
duration: '3 months'
date: 2026-01-15
order: 6
hero: '/assets/images/work/my-project/hero.jpg'
highlights: [megaphone, increase, star]
---

## Intro & Goal

What the project was and what it needed to achieve.

## Challenges

- First challenge
- Second challenge

## Solution

- What you did

## My Role

- What you owned

## Results

- The outcome, with **numbers in bold**
```

3. Put the images in `src/assets/images/work/my-project/` and reference them in the body with `![description](/assets/images/work/my-project/photo.jpg)`.
4. Commit and push. The site rebuilds and redeploys automatically.

`order` controls the position in the work list (lower is higher up). `highlights` picks the coloured badges — the available keys are in `src/_data/highlights.json`.

## Editing the homepage

All homepage copy lives in `src/_data/home.json` — hero, about blocks, the three services cards, the tools block, the four dark cards, the call to action, and the nav links. Site-wide details (name, description, email, LinkedIn, social image) are in `src/_data/site.json`.

## Replacing a placeholder image

Images marked "IMAGE PENDING" are stand-ins. Save the real file at the exact path listed in `MISSING-ASSETS.md`, overwriting the placeholder. Nothing else needs to change.

---

## Development

```bash
npm install
npm start          # dev server at localhost:8080 with live reload
npm run build      # production build into public/
npm run lighthouse # build, serve, and audit every page
```

Other commands:

| Command | Does |
| --- | --- |
| `npm run migrate` | Regenerates `src/work/*.md` from `dm_posts.csv` (one-off recovery, kept for reference) |
| `node tools/build-placeholders.mjs` | Generates stand-ins for any still-missing image |
| `node tools/build-icons.mjs` | Regenerates the highlight badge icons |

## Structure

```
src/
  _data/        site.json, home.json, highlights.json — all editable content
  _includes/    layouts and partials (Nunjucks)
  work/         one markdown file per case study
  assets/       scss, ts, fonts, icons, images
tools/          build and migration scripts
.do/app.yaml    DigitalOcean App Platform spec
```
