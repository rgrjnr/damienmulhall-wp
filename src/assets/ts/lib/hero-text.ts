/**
 * Hero heading reveal: the words rise into a masked line box.
 */

import { gsap } from 'gsap';
import { SplitText } from 'gsap/SplitText';
import { query } from './env';

const HERO_SELECTORS = ['[data-hero-heading]', '.hero-heading', '.hero h1', 'header h1', 'h1'];

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

  // autoSplit re-splits (and re-runs onSplit) when webfonts land or the box resizes,
  // so the mask never ends up clipping the wrong line boxes.
  SplitText.create(heading, {
    type: 'lines,words',
    autoSplit: true,
    linesClass: 'split-line',
    onSplit: (self: SplitText) => {
      self.lines.forEach((line) => {
        if (line instanceof HTMLElement) line.style.overflow = 'hidden';
      });

      return gsap.from(self.words, {
        duration: 0.8,
        yPercent: 100,
        stagger: 0.1,
        ease: 'power2.out',
        // Whatever happens, the words end up visible and untransformed.
        clearProps: 'transform',
      });
    },
  });
}
