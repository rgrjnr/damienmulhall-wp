/**
 * Hero heading reveal: the words rise into a masked line box, then the
 * scribble under the highlighted phrase draws itself.
 *
 * The same rise runs on case study titles (they are the page's first h1).
 */

import { gsap } from 'gsap';
import { SplitText } from 'gsap/SplitText';
import { MOTION, query } from './env';

const HERO_SELECTORS = ['[data-hero-heading]', '.hero-heading', '.hero h1', 'header h1', 'h1'];

// Long titles must not drag: the whole cascade stays under this, however many words.
const MAX_CASCADE = 0.5;

function findHeroHeading(): HTMLElement | null {
  for (const selector of HERO_SELECTORS) {
    const element = query<HTMLElement>(selector);
    if (element && element.textContent && element.textContent.trim().length > 0) return element;
  }
  return null;
}

export function setupHeroText(enabled: boolean): void {
  if (!enabled) return;

  const heading = findHeroHeading();
  if (!heading) return;

  const scribble = query<HTMLElement>('.scribble', heading);
  const highlight = scribble?.textContent?.trim() ?? '';
  // Read at call time: a re-split replaces the elements.
  const drawScribble = (): void => query<HTMLElement>('.scribble', heading)?.classList.add('is-drawn');

  if (scribble) {
    document.documentElement.classList.add('motion');
    // Whatever happens to the tween, the stroke appears.
    window.setTimeout(drawScribble, 2500);
  }

  // autoSplit re-splits (and re-runs onSplit) when webfonts land or the box resizes,
  // so the mask never ends up clipping the wrong line boxes.
  SplitText.create(heading, {
    type: 'lines,words',
    autoSplit: true,
    linesClass: 'split-line',
    onSplit: (self: SplitText) => {
      const lines = self.lines.filter((line): line is HTMLElement => line instanceof HTMLElement);

      // SplitText splits on spaces, so "delivery." becomes one word that
      // straddles the span and leaves it empty. Move the scribble onto the word.
      if (highlight) {
        heading.querySelectorAll('.scribble').forEach((element) => element.classList.remove('scribble', 'is-drawn'));
        const word = self.words.find((w) => w instanceof HTMLElement && w.textContent?.includes(highlight));
        if (word instanceof HTMLElement) word.classList.add('scribble');
      }
      lines.forEach((line) => {
        line.style.overflow = 'hidden';
      });

      return gsap.from(self.words, {
        duration: 0.7,
        yPercent: 100,
        stagger: Math.min(MOTION.stagger * 2, MAX_CASCADE / Math.max(self.words.length, 1)),
        ease: MOTION.ease,
        // Whatever happens, the words end up visible and untransformed.
        clearProps: 'transform',
        onComplete: () => {
          // The mask has done its job; let the scribble hang below the line.
          lines.forEach((line) => {
            line.style.overflow = 'visible';
          });
          drawScribble();
        },
      });
    },
  });
}
