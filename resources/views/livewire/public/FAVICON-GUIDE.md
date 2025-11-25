# Favicon Files Guide

The site is configured to use the following favicon files. Place them in the `public/` folder:

## Required Files

### Browser Icons
- `favicon.ico` - 32x32px ICO format (for older browsers)
- `favicon-16x16.png` - 16x16px PNG
- `favicon-32x32.png` - 32x32px PNG

### Apple Touch Icon
- `apple-touch-icon.png` - 180x180px PNG (for iOS home screen)

### Android Chrome Icons
- `android-chrome-192x192.png` - 192x192px PNG
- `android-chrome-512x512.png` - 512x512px PNG

### Manifest
- `site.webmanifest` - Already created ✓

## Quick Generation

You can generate all these files from your logo using online tools:

1. **RealFaviconGenerator** (recommended)
   - Visit: https://realfavicongenerator.net/
   - Upload: `public/images/logo.png`
   - Download the generated package
   - Extract files to `public/` folder

2. **Favicon.io**
   - Visit: https://favicon.io/
   - Upload your logo
   - Download and extract to `public/`

## File Locations

All favicon files should be in the root of the `public/` folder:

```
public/
├── favicon.ico
├── favicon-16x16.png
├── favicon-32x32.png
├── apple-touch-icon.png
├── android-chrome-192x192.png
├── android-chrome-512x512.png
└── site.webmanifest
```

## Current Status

Theme color is set to green (#22c55e) to match KMG's brand.

The public layout already includes all necessary <link> and <meta> tags.
