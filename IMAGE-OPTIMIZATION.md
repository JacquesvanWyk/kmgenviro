# Hero Image Optimization Guide

## Quick Start

1. **Add your hero image:**
   ```bash
   # Copy your original hero image to:
   public/images/hero-1.jpg
   ```

2. **Run the optimization script:**
   ```bash
   ./optimize-hero.sh
   ```

3. **Rebuild assets:**
   ```bash
   npm run build
   ```

## What the Script Does

The `optimize-hero.sh` script uses macOS built-in tools to create optimized versions:

### Created Files:
- `hero-1-desktop.jpg` (1920px wide) - For desktop screens
- `hero-1-tablet.jpg` (1280px wide) - For tablets
- `hero-1-mobile.jpg` (768px wide) - For mobile devices

### Optional WebP Conversion:
If you have `cwebp` installed (via `brew install webp`), it also creates:
- `hero-1-desktop.webp` - 25-35% smaller than JPEG
- `hero-1-tablet.webp` - 25-35% smaller than JPEG
- `hero-1-mobile.webp` - 25-35% smaller than JPEG

## Performance Benefits

**Responsive Images:**
- Mobile users download ~768px image instead of full 1920px
- Saves 60-70% bandwidth on mobile devices
- Faster page load times

**WebP Format:**
- 25-35% smaller file size than JPEG at same quality
- Automatic fallback to JPEG for older browsers
- Modern browsers get the smaller WebP version

**Optimized Quality:**
- JPEG quality set to 85% (optimal balance)
- Maintains visual quality while reducing file size

## Recommended Original Image Specs

- **Minimum width:** 1920px
- **Aspect ratio:** 16:9 or similar
- **Format:** JPEG or PNG
- **Quality:** High (will be optimized by script)

## Manual Optimization (Without Script)

If you prefer manual optimization:

```bash
# Resize with sips (macOS built-in)
sips -Z 1920 original.jpg --out hero-1-desktop.jpg
sips -s format jpeg -s formatOptions 85 hero-1-desktop.jpg

# Convert to WebP (requires brew install webp)
cwebp -q 85 hero-1-desktop.jpg -o hero-1-desktop.webp
```

## Testing

After optimization:
1. Clear browser cache
2. Visit kmgenviro.test
3. Open DevTools Network tab
4. Check image size loaded (should be appropriate for your screen size)
5. Verify WebP is loaded in modern browsers

## Troubleshooting

**Script says "command not found":**
```bash
chmod +x optimize-hero.sh
./optimize-hero.sh
```

**No WebP versions created:**
```bash
# Install webp tools
brew install webp

# Run script again
./optimize-hero.sh
```

**Image looks blurry:**
- Use a higher resolution original (at least 1920px wide)
- Increase quality in script (change 85 to 90-95)
