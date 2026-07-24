/**
 * Small shared helpers: motion preference and fail-safe step execution.
 */

/** True when the visitor asked the OS to reduce motion. */
export function prefersReducedMotion(): boolean {
  if (typeof window.matchMedia !== 'function') return false;
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

/**
 * Runs a setup step in isolation. A throw inside one animation must never
 * prevent the remaining steps (or the page itself) from working.
 */
export function safely(name: string, step: () => void): void {
  try {
    step();
  } catch (error) {
    console.warn(`[animations] "${name}" failed and was skipped.`, error);
  }
}

/** Typed, null-safe single-element query. */
export function query<T extends Element>(selector: string, root: ParentNode = document): T | null {
  return root.querySelector<T>(selector);
}

/** Typed query returning a real array (never a live NodeList). */
export function queryAll<T extends Element>(selector: string, root: ParentNode = document): T[] {
  return Array.from(root.querySelectorAll<T>(selector));
}

/**
 * Hand control back to the browser between setup steps so a long run of work is
 * split into several short tasks instead of one blocking one. Uses the native
 * scheduler where available and falls back to a macrotask everywhere else.
 */
export function yieldToMain(): Promise<void> {
  const scheduler = (globalThis as { scheduler?: { yield?: () => Promise<void> } }).scheduler;
  if (typeof scheduler?.yield === 'function') return scheduler.yield();
  return new Promise((resolve) => {
    window.setTimeout(resolve, 0);
  });
}
