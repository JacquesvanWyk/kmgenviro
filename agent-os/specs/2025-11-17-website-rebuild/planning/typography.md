# Typography Specification

## Overview

Modern, professional typography for KMG Environmental Solutions website that conveys:
- Scientific credibility and technical expertise
- Environmental consciousness
- Professional consultancy services
- Readability across devices and contexts

**Goal:** Move away from the old WordPress site fonts (Playfair Display + Roboto) to a more contemporary, versatile typeface system.

---

## Font Pairing Options

### Option 1: Inter (Recommended)

**Why Inter:**
- Designed specifically for computer screens
- Exceptional readability at all sizes
- Professional and modern without being trendy
- Excellent for technical/scientific content
- Wide range of weights available
- Open-source and free
- Fast loading with variable font option

**Font Family:**
- Primary: Inter (all weights)
- Fallback: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif

**Weights Needed:**
- 400 (Regular) - Body text
- 500 (Medium) - Emphasized body text, UI elements
- 600 (Semibold) - Subheadings, labels
- 700 (Bold) - Headings
- 800 (Extrabold) - Hero headings (optional)

**Usage:**
- Headings: Inter 700 or 800
- Body: Inter 400
- UI elements: Inter 500
- Labels/badges: Inter 600

**Implementation Method:** Variable font (recommended) or individual weights

---

### Option 2: Outfit + Geist Sans

**Why This Pairing:**
- Outfit: Geometric, friendly, modern - great for headings
- Geist Sans: Clean, readable, technical - perfect for body text
- Good contrast between display and text fonts
- Both are contemporary and professional

**Font Families:**
- Headings: Outfit (weights: 500, 600, 700)
- Body: Geist Sans (weights: 400, 500, 600)
- Fallback: system-ui, sans-serif

**Weights Needed:**
- Outfit: 500, 600, 700
- Geist Sans: 400, 500, 600

**Usage:**
- Hero headings: Outfit 700
- Section headings: Outfit 600
- Subheadings: Outfit 500 or Geist Sans 600
- Body text: Geist Sans 400
- UI elements: Geist Sans 500

**Considerations:**
- Geist Sans is from Vercel, excellent for technical content
- May require self-hosting or Vercel CDN
- Slightly larger file size than single-font approach

---

### Option 3: DM Sans

**Why DM Sans:**
- Geometric sans-serif optimized for low-resolution displays
- Clean, modern, professional
- Excellent for environmental/scientific content
- Good readability in data-heavy contexts
- Single font family for consistency
- Google Fonts hosted

**Font Family:**
- Primary: DM Sans (all weights)
- Fallback: system-ui, sans-serif

**Weights Needed:**
- 400 (Regular) - Body text
- 500 (Medium) - UI elements, emphasized text
- 700 (Bold) - All headings

**Usage:**
- All headings: DM Sans 700
- Body: DM Sans 400
- Buttons/labels: DM Sans 500

**Benefits:**
- Simplest implementation (one font family)
- Fast loading
- Consistent visual system
- Professional without being corporate

---

## Recommended Choice: Option 1 (Inter)

**Rationale:**
1. **Versatility:** Single font family works for everything
2. **Performance:** Variable font loads fast, covers all weights
3. **Readability:** Specifically designed for screens
4. **Professional:** Used by major tech and scientific organizations
5. **Accessibility:** Excellent legibility for all users
6. **Future-proof:** Active development, wide support

---

## Tailwind CSS Configuration

### Option 1 Implementation (Inter Variable Font)

**Step 1: Add Google Fonts Import**

In `resources/css/app.css`:

```css
@import "tailwindcss";

/* Import Inter variable font */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

/* Or for variable font (recommended): */
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900&display=swap');

@theme {
  /* Custom KMG theme variables */
  --color-brand-green: #1e7e34;
  --color-brand-blue: #2E5090;
  --color-brand-blue-light: #4A90C8;

  /* Typography */
  --font-family-sans: Inter, ui-sans-serif, system-ui, sans-serif;

  /* Font sizes with better hierarchy */
  --font-size-xs: 0.75rem;      /* 12px */
  --font-size-sm: 0.875rem;     /* 14px */
  --font-size-base: 1rem;       /* 16px */
  --font-size-lg: 1.125rem;     /* 18px */
  --font-size-xl: 1.25rem;      /* 20px */
  --font-size-2xl: 1.5rem;      /* 24px */
  --font-size-3xl: 1.875rem;    /* 30px */
  --font-size-4xl: 2.25rem;     /* 36px */
  --font-size-5xl: 3rem;        /* 48px */
  --font-size-6xl: 3.75rem;     /* 60px */

  /* Line heights */
  --line-height-tight: 1.25;
  --line-height-snug: 1.375;
  --line-height-normal: 1.5;
  --line-height-relaxed: 1.625;
  --line-height-loose: 2;

  /* Letter spacing for headings */
  --letter-spacing-tight: -0.025em;
  --letter-spacing-normal: 0;
  --letter-spacing-wide: 0.025em;
}
```

**Step 2: Configure Tailwind (if needed)**

Modern Tailwind CSS 4 uses the `@theme` directive above. No separate `tailwind.config.js` needed for basic typography.

**Step 3: Apply Global Styles**

In `resources/css/app.css`, after `@theme`:

```css
/* Base typography styles */
body {
  font-family: var(--font-family-sans);
  font-size: var(--font-size-base);
  line-height: var(--line-height-normal);
  color: #1f2937; /* gray-800 */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-family-sans);
  font-weight: 700;
  line-height: var(--line-height-tight);
  letter-spacing: var(--letter-spacing-tight);
  color: #111827; /* gray-900 */
}

h1 {
  font-size: var(--font-size-5xl);
  font-weight: 800;
}

h2 {
  font-size: var(--font-size-4xl);
}

h3 {
  font-size: var(--font-size-3xl);
}

h4 {
  font-size: var(--font-size-2xl);
}

h5 {
  font-size: var(--font-size-xl);
}

h6 {
  font-size: var(--font-size-lg);
}

/* Paragraph spacing */
p {
  margin-bottom: 1rem;
}

/* Link styles */
a {
  color: var(--color-brand-green);
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
```

---

### Option 2 Implementation (Outfit + Geist Sans)

**Step 1: Add Font Imports**

```css
@import "tailwindcss";

/* Import Outfit from Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&display=swap');

/* Self-host Geist Sans or use Vercel CDN */
/* Download from: https://vercel.com/font */

@theme {
  --font-family-heading: Outfit, ui-sans-serif, system-ui, sans-serif;
  --font-family-body: 'Geist Sans', ui-sans-serif, system-ui, sans-serif;

  /* Rest of theme config same as Option 1 */
}
```

**Step 2: Apply Different Fonts**

```css
body {
  font-family: var(--font-family-body);
}

h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-family-heading);
}
```

---

### Option 3 Implementation (DM Sans)

**Step 1: Add Google Fonts Import**

```css
@import "tailwindcss";

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');

@theme {
  --font-family-sans: 'DM Sans', ui-sans-serif, system-ui, sans-serif;

  /* Rest of theme config same as Option 1 */
}
```

---

## Utility Classes Reference

With the configuration above, use these Tailwind classes:

### Font Weights
```html
<p class="font-normal">Regular 400</p>
<p class="font-medium">Medium 500</p>
<p class="font-semibold">Semibold 600</p>
<p class="font-bold">Bold 700</p>
<p class="font-extrabold">Extrabold 800</p>
```

### Font Sizes
```html
<p class="text-xs">Extra small 12px</p>
<p class="text-sm">Small 14px</p>
<p class="text-base">Base 16px</p>
<p class="text-lg">Large 18px</p>
<p class="text-xl">XL 20px</p>
<p class="text-2xl">2XL 24px</p>
<p class="text-3xl">3XL 30px</p>
<p class="text-4xl">4XL 36px</p>
<p class="text-5xl">5XL 48px</p>
```

### Line Heights
```html
<p class="leading-tight">Tight 1.25</p>
<p class="leading-snug">Snug 1.375</p>
<p class="leading-normal">Normal 1.5</p>
<p class="leading-relaxed">Relaxed 1.625</p>
<p class="leading-loose">Loose 2</p>
```

### Letter Spacing
```html
<h1 class="tracking-tight">Tight spacing for large headings</h1>
<p class="tracking-normal">Normal spacing for body</p>
<p class="tracking-wide">Wide spacing for labels</p>
```

---

## Typography Scale Examples

### Homepage Hero
```html
<h1 class="text-5xl md:text-6xl font-extrabold leading-tight tracking-tight text-white">
  Accredited Environmental, ESG, Waste & Occupational Hygiene Consultants
</h1>
<p class="text-xl md:text-2xl font-normal leading-relaxed text-gray-100">
  DoEL asbestos approved | SACNASP/EAPASA training provider | GBCSA member
</p>
```

### Section Headings
```html
<h2 class="text-4xl font-bold leading-tight tracking-tight text-gray-900 mb-6">
  Our Core Services
</h2>
<p class="text-lg text-gray-600 leading-relaxed">
  Supporting paragraph text with comfortable line height
</p>
```

### Service Cards
```html
<h3 class="text-xl font-semibold leading-snug text-gray-900 mb-3">
  Environmental Monitoring Services
</h3>
<p class="text-base text-gray-600 leading-normal">
  Card description text at base size
</p>
```

### Body Content
```html
<article class="prose prose-lg max-w-none">
  <p class="text-base leading-relaxed text-gray-700">
    Body paragraphs with comfortable reading experience...
  </p>
</article>
```

### UI Elements
```html
<button class="text-sm font-medium uppercase tracking-wide">
  Request Quote
</button>

<span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
  Service Category
</span>
```

---

## Responsive Typography

Use Tailwind's responsive prefixes for better mobile typography:

```html
<!-- Heading that scales down on mobile -->
<h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold">
  Responsive Heading
</h1>

<!-- Body text that's slightly smaller on mobile -->
<p class="text-sm sm:text-base leading-relaxed">
  Responsive body text
</p>

<!-- Tighter line height on mobile for headings -->
<h2 class="text-2xl md:text-3xl leading-tight md:leading-normal">
  Mobile-optimized heading
</h2>
```

---

## Filament Admin Panel Typography

Filament uses its own typography system, but it will inherit your base font. To ensure consistency:

**In `resources/css/filament/admin/theme.css`** (if you create a custom theme):

```css
@import '../../../css/app.css';

/* Filament will use the Inter font from your global config */
```

**Or configure directly in Filament Panel:**

```php
// In AdminPanelProvider.php
->font('Inter') // Filament will load from Google Fonts
```

---

## Performance Considerations

### Variable Font (Recommended)

**Pros:**
- Single file contains all weights
- Smaller total file size than loading individual weights
- Smoother weight transitions
- Future-proof

**Cons:**
- Slightly larger initial download vs. loading only 2-3 weights
- Not needed if only using 2-3 specific weights

**Implementation:**
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900&display=swap" rel="stylesheet">
```

### Self-Hosting Fonts

For even better performance, download and self-host:

1. Download Inter from Google Fonts or GitHub
2. Place font files in `public/fonts/`
3. Use `@font-face` in CSS:

```css
@font-face {
  font-family: 'Inter';
  font-style: normal;
  font-weight: 100 900;
  font-display: swap;
  src: url('/fonts/Inter-Variable.woff2') format('woff2');
}
```

### Font Loading Strategy

Use `font-display: swap` to prevent FOIT (Flash of Invisible Text):

```css
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
```

Or in `@font-face`:

```css
@font-face {
  font-display: swap;
  /* ... */
}
```

---

## Accessibility Considerations

1. **Minimum Font Size:** Never go below 14px (0.875rem) for body text
2. **Line Height:** Use 1.5 or higher for body text (readability)
3. **Contrast:** Ensure text colors meet WCAG AA standards
4. **Scaling:** Support browser zoom up to 200%
5. **Dyslexia-Friendly:** Inter and DM Sans are good choices (geometric, clear letterforms)

**Color Contrast Examples:**

```css
/* Good contrast combinations */
.text-dark-on-light {
  color: #111827; /* gray-900 */
  background: #ffffff;
  /* Contrast ratio: 16.11:1 ✓ */
}

.text-green-on-white {
  color: #1e7e34; /* brand green */
  background: #ffffff;
  /* Contrast ratio: 4.77:1 ✓ (meets AA for normal text) */
}

.text-white-on-green {
  color: #ffffff;
  background: #1e7e34;
  /* Contrast ratio: 4.41:1 ✓ */
}
```

---

## Code/Monospace Font

For technical content, code blocks, data tables:

**Recommended:** System monospace stack

```css
@theme {
  --font-family-mono: ui-monospace, SFMono-Regular, 'SF Mono', Menlo, Consolas, 'Liberation Mono', monospace;
}
```

**Usage:**
```html
<code class="font-mono text-sm">API_KEY=your_key_here</code>
```

---

## Implementation Checklist

**Phase 1:**
- [ ] Choose font pairing (Inter recommended)
- [ ] Add font import to `resources/css/app.css`
- [ ] Configure `@theme` with typography variables
- [ ] Add global typography styles
- [ ] Configure Filament to use same font
- [ ] Test in admin panel
- [ ] Verify font loading performance

**Future Phases:**
- [ ] Apply typography to all public pages
- [ ] Create typography component library
- [ ] Test across devices and browsers
- [ ] Optimize font loading
- [ ] Consider self-hosting fonts

---

## Testing Checklist

After implementing typography:

**Visual Testing:**
- [ ] All headings (H1-H6) display correctly
- [ ] Body text is readable and comfortable
- [ ] Font weights render correctly (not too bold/light)
- [ ] No FOIT (flash of invisible text) on page load
- [ ] Fonts render crisply on retina displays

**Cross-Browser:**
- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari (Mac, iOS)
- [ ] Mobile browsers

**Accessibility:**
- [ ] Text scales with browser zoom
- [ ] Sufficient contrast ratios
- [ ] Readable at 200% zoom
- [ ] Screen reader compatible

**Performance:**
- [ ] Fonts load quickly (check Network tab)
- [ ] No layout shift during font load
- [ ] Page loads under 3 seconds

---

## Summary

**Final Recommendation: Inter Variable Font**

**Why:**
- Single font family for everything (simplicity)
- Excellent readability for technical/scientific content
- Professional and modern aesthetic
- Great performance with variable font
- Wide weight range for hierarchy
- Free and open-source

**Quick Start:**
1. Add Google Fonts import for Inter to `app.css`
2. Configure `@theme` with Inter as `--font-family-sans`
3. Configure Filament panel to use Inter
4. Done - typography system ready to use across entire application
