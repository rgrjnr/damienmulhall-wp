/**
 * Headline stats count up once as they scroll into view.
 *
 * Only plain numbers animate ("67", "120+", "100,000+", "$0.22"). Anything else
 * ("#1", "5 of 5", "Q3") is left exactly as written. Screen readers get the final
 * value straight away from a visually hidden copy.
 */

import { gsap } from 'gsap';
import { queryAll } from './env';

const SELECTOR = '.cs-stat__value, .work-card__stat-value';
const PATTERN = /^([$€£]?)(\d[\d,]*(?:\.\d+)?)([+%]?)$/;

interface Parsed {
  prefix: string;
  value: number;
  suffix: string;
  decimals: number;
  grouped: boolean;
}

function parse(text: string): Parsed | null {
  const match = PATTERN.exec(text.trim());
  if (!match) return null;

  const [, prefix = '', digits = '', suffix = ''] = match;
  const value = Number(digits.replace(/,/g, ''));
  // Counting from zero to one or two looks like a glitch rather than a flourish.
  if (!Number.isFinite(value) || value < 3) return null;

  return {
    prefix,
    value,
    suffix,
    decimals: digits.split('.')[1]?.length ?? 0,
    grouped: digits.includes(','),
  };
}

function format(n: number, parsed: Parsed): string {
  const fixed = n.toFixed(parsed.decimals);
  const body = parsed.grouped ? Number(fixed).toLocaleString('en-GB', { minimumFractionDigits: parsed.decimals }) : fixed;
  return `${parsed.prefix}${body}${parsed.suffix}`;
}

export function setupCounters(enabled: boolean): void {
  if (!enabled) return;

  queryAll<HTMLElement>(SELECTOR).forEach((element) => {
    const finalText = element.textContent?.trim() ?? '';
    const parsed = parse(finalText);
    if (!parsed) return;

    const spoken = document.createElement('span');
    spoken.className = 'sr-only';
    spoken.textContent = finalText;
    const shown = document.createElement('span');
    shown.setAttribute('aria-hidden', 'true');
    shown.textContent = format(0, parsed);
    element.replaceChildren(shown, spoken);

    const counter = { n: 0 };
    gsap.to(counter, {
      n: parsed.value,
      duration: 1.4,
      ease: 'power3.out',
      onUpdate: () => {
        shown.textContent = format(counter.n, parsed);
      },
      onComplete: () => {
        element.textContent = finalText;
      },
      scrollTrigger: { trigger: element, start: 'top 90%', once: true },
    });
  });
}
