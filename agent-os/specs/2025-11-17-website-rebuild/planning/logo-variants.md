# Logo Variants Specification

## Source Asset

**File:** `kmg-logo-primary.png`
**Dimensions:** 1216 × 438 pixels (approximately 2.78:1 aspect ratio)
**Format:** PNG with transparency

**Visual Description:**
- Left side: Earth/leaf icon (circular) with blue, green, and gold/tan elements
- Right side: "KMG" in navy blue italic font, followed by "Environmental Solutions Services" in blue below

**Brand Colors Identified:**
- Navy Blue: #2E5090 (approx) - "KMG" text
- Medium Blue: #4A90C8 (approx) - Secondary text
- Lime Green: #A4C639 (approx) - Earth element
- Gold/Tan: #C9A35E (approx) - Earth accent

---

## Required Logo Variants

### 1. Main Admin Panel Logo

**File Name:** `logo.png`
**Source:** Use existing `kmg-logo-primary.png`
**Dimensions:** Keep original (1216 × 438px) or optimize to 800 × 288px
**Usage:**
- Filament admin panel header (top left)
- Login page
- Email headers (future)

**Implementation:**
```php
// In AdminPanelProvider.php
->brandLogo(asset('images/logo.png'))
->brandLogoHeight('3rem') // Adjust based on final size
```

**Location:** `public/images/logo.png`

**Action:** Copy existing file to this location

---

### 2. Square Icon Version

**File Name:** `icon.png`
**Dimensions:** 200 × 200 pixels (square)
**Content:** Just the earth/leaf icon from the left portion of the main logo

**Cropping Strategy:**
1. Open `kmg-logo-primary.png` in image editor
2. Crop to isolate just the circular earth/leaf icon (left portion)
3. Add minimal padding (10-15px) around the circle
4. Resize to 200 × 200px square
5. Maintain transparency around the circle
6. Save as PNG with transparency

**Alternative Approach (if cropping is difficult):**
- Use the circular icon portion
- Center it in a 200×200 canvas
- Ensure the icon is approximately 170px in diameter within the 200px square
- Background: Transparent

**Usage:**
- Compact admin panel sidebar (when collapsed)
- Mobile admin panel navigation
- Base for favicon generation
- Admin panel breadcrumbs
- Browser tab icon

**Implementation:**
```php
// In AdminPanelProvider.php (for collapsed sidebar)
->brandLogo(asset('images/icon.png'), shouldBeCompact: true)
```

**Location:** `public/images/icon.png`

**Quality Requirements:**
- Crisp edges on the circle
- Maintain color vibrancy
- Sharp details on leaf element
- Transparent background

---

### 3. Dark Mode Logo (White Version)

**File Name:** `logo-white.png`
**Dimensions:** Same as main logo (1216 × 438px or 800 × 288px)
**Content:** Full logo with inverted colors for dark backgrounds

**Color Inversion Strategy:**

**Option A - Full White (Recommended):**
- Convert all colored elements to white (#FFFFFF)
- Maintain the same shapes and layout
- Keep transparency intact
- Result: Clean, professional look on dark backgrounds

**Option B - Selective Inversion:**
- Text ("KMG" and company name): White (#FFFFFF)
- Earth icon: Keep earth green and blue, but lighter shades
  - Blue → Light blue (#6DB3E8)
  - Green → Lighter green (#C5E86D)
  - Gold → Light gold (#E8D19B)
- More colorful but may clash with some dark mode UI colors

**Recommendation:** Use Option A (Full White) for consistency with Filament's dark mode aesthetics.

**Creation Steps:**
1. Duplicate `kmg-logo-primary.png`
2. Use image editor to:
   - Select all non-transparent pixels
   - Change color to white (#FFFFFF)
   - Or use "Color Overlay" layer set to white
3. Save as `logo-white.png`

**Usage:**
- Filament admin panel header when dark mode is enabled
- Dark-themed email templates (future)
- Dark sections of public website (future)

**Implementation:**
```php
// In AdminPanelProvider.php
->darkModeBrandLogo(asset('images/logo-white.png'))
```

**Location:** `public/images/logo-white.png`

**Testing:**
- View against dark gray background (#1F2937)
- Ensure readability and contrast
- Check all elements are visible

---

### 4. Favicon Set

**Base File:** Generated from `icon.png`

**Required Sizes:**

**favicon.ico (Multi-resolution ICO file):**
- Contains: 16×16px, 32×32px, 48×48px versions
- Location: `public/favicon.ico`

**favicon-16x16.png:**
- Dimensions: 16 × 16px
- Location: `public/favicon-16x16.png`

**favicon-32x32.png:**
- Dimensions: 32 × 32px
- Location: `public/favicon-32x32.png`

**apple-touch-icon.png:**
- Dimensions: 180 × 180px
- Location: `public/apple-touch-icon.png`
- Usage: iOS home screen icon

**android-chrome-192x192.png:**
- Dimensions: 192 × 192px
- Location: `public/android-chrome-192x192.png`

**android-chrome-512x512.png:**
- Dimensions: 512 × 512px
- Location: `public/android-chrome-512x512.png`

**Generation Method:**

**Option 1 - Online Tool (Easiest):**
1. Use https://realfavicongenerator.net/
2. Upload `icon.png` (200×200px square icon)
3. Download generated favicon package
4. Extract files to `public/` directory

**Option 2 - Manual Creation:**
1. Resize `icon.png` to each required dimension
2. Use ImageMagick or similar to create .ico file:
   ```bash
   convert icon-16.png icon-32.png icon-48.png favicon.ico
   ```

**HTML Implementation:**
```html
<!-- In app layout head section -->
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">
```

**site.webmanifest:**
```json
{
  "name": "KMG Environmental Solutions",
  "short_name": "KMG Enviro",
  "icons": [
    {
      "src": "/android-chrome-192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/android-chrome-512x512.png",
      "sizes": "512x512",
      "type": "image/png"
    }
  ],
  "theme_color": "#1e7e34",
  "background_color": "#ffffff",
  "display": "standalone"
}
```

---

## File Structure

After creating all variants, the file structure should be:

```
public/
├── images/
│   ├── logo.png                    (Main admin logo - 800×288px)
│   ├── logo-white.png              (Dark mode logo - 800×288px)
│   └── icon.png                    (Square icon - 200×200px)
├── favicon.ico                     (Multi-resolution ICO)
├── favicon-16x16.png
├── favicon-32x32.png
├── apple-touch-icon.png            (180×180px)
├── android-chrome-192x192.png
├── android-chrome-512x512.png
└── site.webmanifest
```

---

## Filament Configuration

**Complete logo configuration in `app/Providers/Filament/AdminPanelProvider.php`:**

```php
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->brandName('KMG Environmental')
        ->brandLogo(asset('images/logo.png'))
        ->darkModeBrandLogo(asset('images/logo-white.png'))
        ->brandLogoHeight('3rem')
        ->favicon(asset('favicon.ico'))
        ->colors([
            'primary' => '#1e7e34',
        ])
        // ... rest of configuration
}
```

---

## Image Optimization Tips

**For PNG files:**
- Use tools like TinyPNG or ImageOptim to reduce file size
- Maintain transparency
- Ensure crisp edges (no jagged pixels)
- Save at 72 DPI (web standard)

**Quality Checklist:**
- [ ] All logos have transparent backgrounds
- [ ] No white halos or artifacts around edges
- [ ] Colors are vibrant and accurate
- [ ] Text is crisp and readable (especially at small sizes)
- [ ] File sizes optimized (main logo under 50KB, icons under 10KB)

---

## Testing Checklist

After creating all logo variants:

**Admin Panel Testing:**
- [ ] Main logo displays correctly in admin header
- [ ] Logo scales appropriately at different screen sizes
- [ ] Square icon shows when sidebar is collapsed (if applicable)
- [ ] Dark mode logo displays when dark mode is enabled
- [ ] Favicon appears in browser tab
- [ ] Favicon appears in bookmarks

**Cross-Browser Testing:**
- [ ] Chrome/Edge (Windows, Mac)
- [ ] Firefox
- [ ] Safari (Mac, iOS)
- [ ] Mobile browsers (Android Chrome, iOS Safari)

**Device Testing:**
- [ ] Desktop (1920px, 1440px, 1024px widths)
- [ ] Tablet (iPad, Android tablet)
- [ ] Mobile (iPhone, Android phone)
- [ ] Check iOS home screen icon (add to home screen)
- [ ] Check Android home screen icon

---

## Timeline

**Logo Creation:** 1-2 hours

**Breakdown:**
- Square icon crop and resize: 15 minutes
- Dark mode logo creation: 15 minutes
- Favicon set generation: 30 minutes (using online tool)
- File placement and optimization: 15 minutes
- Filament configuration: 15 minutes
- Testing across devices: 30 minutes

---

## Tools Recommended

**Image Editing:**
- Adobe Photoshop (professional)
- GIMP (free alternative)
- Figma (web-based, free tier available)
- Sketch (Mac only)

**Favicon Generation:**
- https://realfavicongenerator.net/ (recommended)
- https://favicon.io/
- ImageMagick (command-line)

**Image Optimization:**
- TinyPNG (https://tinypng.com/)
- ImageOptim (Mac)
- Squoosh (https://squoosh.app/)

---

## Future Considerations

**Phase 3+ (Public Website):**
- May need additional logo sizes for different page sections
- Consider social media profile images (square versions)
- Open Graph images for social sharing (1200×630px)
- Email signature version (smaller file size)

**Branding Consistency:**
- Maintain consistent logo usage across all platforms
- Use provided brand colors for UI elements
- Ensure logo always has appropriate padding/clear space
