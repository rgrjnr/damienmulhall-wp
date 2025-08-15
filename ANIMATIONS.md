# GSAP Animations for WordPress Theme

This theme includes comprehensive GSAP animations with ScrollTrigger and SplitText plugins for creating smooth, engaging user experiences.

## Features

- **Automatic Text Animations**: Headings and paragraphs animate on scroll using SplitText
- **Scroll-Triggered Animations**: Elements fade in, scale in, and slide in as they enter the viewport
- **Interactive Animations**: Button and image hover effects
- **Page Transitions**: Smooth fade transitions between pages
- **Performance Optimized**: Uses `will-change` and respects `prefers-reduced-motion`

## How to Use

### Automatic Animations

The following elements are automatically animated:

- **Headings** (`h1`, `h2`, `h3`, `h4`, `h5`, `h6`): Characters animate in with stagger effect
- **Paragraphs**: Lines animate in with stagger effect
- **Images** (`.wp-block-image`, `.wp-block-gallery`): Fade in from bottom
- **Buttons** (`.wp-block-button`): Scale in with bounce effect
- **Interactive elements**: Hover effects on buttons and images

### CSS Classes for Manual Control

Add these classes to any element to trigger specific animations:

```html
<!-- Fade in from bottom -->
<div class="fade-in">Content</div>

<!-- Scale in with bounce -->
<div class="scale-in">Content</div>

<!-- Slide in from left -->
<div class="slide-left">Content</div>

<!-- Slide in from right -->
<div class="slide-right">Content</div>

<!-- Text animation container -->
<div class="text-animate">
  <h2>This text will be split and animated</h2>
</div>
```

### JavaScript API

Access the animation system through the global `window.themeAnimations` object:

```javascript
// Animate a specific element
window.themeAnimations.animateElement('.my-element', {
  duration: 1,
  y: 50,
  opacity: 0,
  ease: 'power2.out',
});

// Create a custom timeline
const timeline = window.themeAnimations.createTimeline('my-animation');
timeline
  .from('.element1', { opacity: 0, y: 30 })
  .from('.element2', { opacity: 0, x: -50 }, '-=0.5');

// Get an existing timeline
const existingTimeline = window.themeAnimations.getTimeline('my-animation');

// Kill an animation
window.themeAnimations.killAnimation('my-animation');

// Refresh ScrollTrigger (useful after dynamic content changes)
window.themeAnimations.refresh();
```

### Custom ScrollTrigger Animations

```javascript
// Custom scroll-triggered animation
gsap.fromTo(
  '.my-element',
  { opacity: 0, y: 100 },
  {
    opacity: 1,
    y: 0,
    duration: 1,
    scrollTrigger: {
      trigger: '.my-element',
      start: 'top 80%',
      end: 'bottom 20%',
      toggleActions: 'play none none reverse',
    },
  }
);
```

### SplitText Examples

```javascript
// Split text by characters
const split = new SplitText('.my-text', { type: 'chars' });
gsap.from(split.chars, {
  duration: 0.8,
  y: 50,
  opacity: 0,
  stagger: 0.02,
});

// Split text by words
const splitWords = new SplitText('.my-text', { type: 'words' });
gsap.from(splitWords.words, {
  duration: 0.6,
  y: 30,
  opacity: 0,
  stagger: 0.1,
});

// Split text by lines
const splitLines = new SplitText('.my-text', { type: 'lines' });
gsap.from(splitLines.lines, {
  duration: 1,
  y: 40,
  opacity: 0,
  stagger: 0.15,
});
```

## Performance Tips

1. **Use `will-animate` class** on elements that will be animated:

   ```html
   <div class="fade-in will-animate">Content</div>
   ```

2. **Add animation delays** using utility classes:

   ```html
   <div class="fade-in animate-delay-1">First</div>
   <div class="fade-in animate-delay-2">Second</div>
   <div class="fade-in animate-delay-3">Third</div>
   ```

3. **Refresh ScrollTrigger** after dynamic content changes:
   ```javascript
   // After loading new content
   window.themeAnimations.refresh();
   ```

## Accessibility

The animations respect the `prefers-reduced-motion` media query. When users have this preference enabled, animations are disabled or significantly reduced.

## Browser Support

- Modern browsers with ES2020 support
- GSAP 3.13.0+
- ScrollTrigger plugin
- SplitText plugin

## Troubleshooting

### Animations not working?

1. Check that GSAP is properly loaded
2. Ensure elements exist in the DOM when animations are triggered
3. Verify ScrollTrigger is registered: `gsap.registerPlugin(ScrollTrigger)`

### Performance issues?

1. Use `will-animate` class on animated elements
2. Limit the number of simultaneous animations
3. Use `ScrollTrigger.refresh()` after dynamic content changes

### Text splitting issues?

1. Ensure text content exists before splitting
2. Check for proper CSS overflow handling
3. Verify SplitText plugin is registered

## Examples

See the main TypeScript file (`assets/ts/main.ts`) for complete implementation examples and the SCSS file (`assets/scss/_animations.scss`) for styling examples.
