/**
 * `.work-item` hover choreography — the signature interaction of the site.
 *
 * On hover the cyan `.work-background` fills the row (from the edge the cursor
 * entered), the `.work-title` slides out downwards while `.work-title-duplicate`
 * drops in from above, the highlight pills slide out, and the `.work-arrow`
 * slides in while its `.arrow-path` stroke draws itself.
 *
 * Unlike the original, the timeline is built once per item and simply
 * played/reversed; the old code appended tweens on every mouseenter.
 */

import { gsap } from 'gsap';
import { query, queryAll } from './env';

interface WorkItemParts {
  background: HTMLElement;
  title: HTMLElement;
  titleDuplicate: HTMLElement;
  highlights: HTMLElement[];
  arrow: HTMLElement | null;
  arrowPaths: SVGPathElement[];
}

function readParts(item: HTMLElement): WorkItemParts | null {
  const background = query<HTMLElement>('.work-background', item);
  const title = query<HTMLElement>('.work-title', item);
  const titleDuplicate = query<HTMLElement>('.work-title-duplicate', item);

  if (!background || !title || !titleDuplicate) return null;

  return {
    background,
    title,
    titleDuplicate,
    highlights: queryAll<HTMLElement>('.work-highlights > div > div', item),
    arrow: query<HTMLElement>('.work-arrow', item),
    arrowPaths: queryAll<SVGPathElement>('.arrow-path', item),
  };
}

function buildTimeline(item: HTMLElement, parts: WorkItemParts): gsap.core.Timeline {
  const { background, title, titleDuplicate, highlights, arrow, arrowPaths } = parts;
  // Function-based values are re-read on invalidate(), so resizes stay correct.
  const height = (): number => item.getBoundingClientRect().height;

  const timeline = gsap.timeline({ paused: true });

  timeline.fromTo(
    background,
    { scaleY: 0 },
    { scaleY: 1, duration: 0.5, ease: 'expo.inOut' },
    0,
  );

  timeline.fromTo(title, { y: 0 }, { y: height, duration: 0.5, ease: 'expo.inOut' }, 0);

  timeline.fromTo(
    titleDuplicate,
    { y: () => -height(), opacity: 1 },
    { y: 0, opacity: 1, duration: 0.5, ease: 'expo.inOut' },
    0,
  );

  if (highlights.length > 0) {
    timeline.fromTo(
      highlights,
      { y: 0 },
      { y: height, duration: 0.2, ease: 'power2.inOut', stagger: 0.05 },
      0,
    );
  }

  if (arrow) {
    timeline.fromTo(
      arrow,
      { autoAlpha: 0, x: 24 },
      { autoAlpha: 1, x: 0, duration: 0.4, ease: 'power2.out' },
      0.2,
    );
  }

  if (arrowPaths.length > 0) {
    timeline.fromTo(
      arrowPaths,
      { strokeDashoffset: 100 },
      { strokeDashoffset: 0, duration: 0.4, ease: 'power2.out' },
      0.3,
    );
  }

  return timeline;
}

export function setupWorkItems(enabled: boolean): void {
  // Reduced motion keeps the CSS-only hover (title colour change); the duplicate
  // title and the arrow stay hidden by their stylesheet defaults, as intended.
  if (!enabled) return;

  queryAll<HTMLElement>('.work-item').forEach((item) => {
    const parts = readParts(item);
    if (!parts) return;

    const timeline = buildTimeline(item, parts);

    const enter = (event: MouseEvent): void => {
      const rect = item.getBoundingClientRect();
      const fromTop = event.clientY - rect.top < rect.height / 2;

      // The fill grows away from the edge the pointer crossed.
      gsap.set(parts.background, { transformOrigin: fromTop ? 'top' : 'bottom' });
      if (timeline.progress() === 0) timeline.invalidate();
      timeline.play();
    };

    const leave = (): void => {
      timeline.reverse();
    };

    item.addEventListener('mouseenter', enter);
    item.addEventListener('mouseleave', leave);

    // Keyboard parity: the row is a link, so focus should show the same state.
    item.addEventListener('focusin', () => {
      gsap.set(parts.background, { transformOrigin: 'top' });
      timeline.play();
    });
    item.addEventListener('focusout', leave);
  });
}
