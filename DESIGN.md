# Design System

## Mood

Agency case-study calm — recruiter opens tab, reads hierarchy in seconds, like [Mors](https://www.mors.design/) typography-led restraint meets [Trajectory](https://www.trajectorywebdesign.com/) clear section rhythm. Not editorial maximalism; not dark SaaS.

## Color strategy

Restrained. Pure white surface; indigo-violet primary from brand seed; accent for links and badges only.

## Tokens (OKLCH)

```css
--color-bg: oklch(1 0 0);
--color-surface: oklch(0.975 0.006 280);
--color-ink: oklch(0.22 0.025 280);
--color-muted: oklch(0.48 0.02 280);
--color-primary: oklch(0.46 0.14 280);
--color-primary-hover: oklch(0.40 0.15 280);
--color-accent: oklch(0.52 0.11 250);
--color-border: oklch(0.90 0.008 280);
--color-focus: oklch(0.46 0.14 280);
```

Filled buttons: white text on `--color-primary`.

## Typography

- Display: "Libre Baskerville", Georgia, serif — hero name only
- Body/UI: "Schibsted Grotesk", system-ui, sans-serif
- Scale: hero `clamp(2.5rem, 5vw + 1rem, 4.5rem)`, h2 `clamp(1.75rem, 2vw + 1rem, 2.25rem)`, body 1.0625rem, line-height 1.65 (body), 1.15 (headings)
- Max prose width: 68ch

## Layout

- Max content width: 72rem, horizontal padding `clamp(1.25rem, 4vw, 2.5rem)`
- Section spacing: `clamp(4rem, 10vw, 7rem)` vertical
- Projects: stacked feature rows (not uniform card grid)

## Motion

- Entry: opacity + translateY 12px, 0.5s ease-out, stagger 80ms max 3 items
- Hover: border/color transitions 0.2s
- `@media (prefers-reduced-motion: reduce)`: no transform animations

## Components

- Header: sticky, blur backdrop, border on scroll
- Hero: typographic, no photo background
- Project row: title, stack tags, summary, thumbnail, "View gallery"
- Modal: gallery carousel, focus trap, Escape closes
- Contact: mailto link only
