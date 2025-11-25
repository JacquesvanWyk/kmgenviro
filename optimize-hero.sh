#!/bin/bash

# KMG Hero Image Optimization Script
# Uses macOS built-in sips tool for image processing

ORIGINAL="public/images/hero-1.jpg"

if [ ! -f "$ORIGINAL" ]; then
    echo "❌ Error: hero-1.jpg not found in public/images/"
    echo "Please add your hero image first, then run this script again."
    exit 1
fi

echo "🖼️  Optimizing hero image..."

# Get original dimensions
ORIGINAL_WIDTH=$(sips -g pixelWidth "$ORIGINAL" | tail -n1 | awk '{print $2}')
ORIGINAL_HEIGHT=$(sips -g pixelHeight "$ORIGINAL" | tail -n1 | awk '{print $2}')
ORIGINAL_SIZE=$(ls -lh "$ORIGINAL" | awk '{print $5}')

echo "📐 Original: ${ORIGINAL_WIDTH}x${ORIGINAL_HEIGHT} (${ORIGINAL_SIZE})"

# Create optimized versions with sips
echo "⚙️  Creating responsive versions..."

# Desktop (1920px wide, hero section)
sips -Z 1920 "$ORIGINAL" --out public/images/hero-1-desktop.jpg > /dev/null 2>&1
sips -s format jpeg -s formatOptions 85 public/images/hero-1-desktop.jpg > /dev/null 2>&1

# Tablet (1280px wide)
sips -Z 1280 "$ORIGINAL" --out public/images/hero-1-tablet.jpg > /dev/null 2>&1
sips -s format jpeg -s formatOptions 85 public/images/hero-1-tablet.jpg > /dev/null 2>&1

# Mobile (768px wide)
sips -Z 768 "$ORIGINAL" --out public/images/hero-1-mobile.jpg > /dev/null 2>&1
sips -s format jpeg -s formatOptions 85 public/images/hero-1-mobile.jpg > /dev/null 2>&1

echo "✅ Responsive JPEGs created:"
echo "   Desktop: $(ls -lh public/images/hero-1-desktop.jpg | awk '{print $5}')"
echo "   Tablet:  $(ls -lh public/images/hero-1-tablet.jpg | awk '{print $5}')"
echo "   Mobile:  $(ls -lh public/images/hero-1-mobile.jpg | awk '{print $5}')"

# Convert to WebP if available (requires imagemagick or cwebp)
if command -v cwebp &> /dev/null; then
    echo "⚙️  Creating WebP versions (better compression)..."
    cwebp -q 85 public/images/hero-1-desktop.jpg -o public/images/hero-1-desktop.webp > /dev/null 2>&1
    cwebp -q 85 public/images/hero-1-tablet.jpg -o public/images/hero-1-tablet.webp > /dev/null 2>&1
    cwebp -q 85 public/images/hero-1-mobile.jpg -o public/images/hero-1-mobile.webp > /dev/null 2>&1
    echo "✅ WebP versions created:"
    echo "   Desktop: $(ls -lh public/images/hero-1-desktop.webp | awk '{print $5}')"
    echo "   Tablet:  $(ls -lh public/images/hero-1-tablet.webp | awk '{print $5}')"
    echo "   Mobile:  $(ls -lh public/images/hero-1-mobile.webp | awk '{print $5}')"
else
    echo "ℹ️  WebP conversion skipped (install cwebp for even better compression)"
    echo "   Install with: brew install webp"
fi

echo ""
echo "✨ Optimization complete!"
echo ""
echo "Recommended next steps:"
echo "1. Run 'npm run build' to rebuild assets"
echo "2. Test the hero section at kmgenviro.test"
