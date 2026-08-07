<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as [$loc, $lastmod, $priority, $frequency])
    <url>
        <loc>{{ $loc }}</loc>
@if ($lastmod)
        <lastmod>{{ $lastmod->toAtomString() }}</lastmod>
@endif
        <changefreq>{{ $frequency }}</changefreq>
        <priority>{{ $priority }}</priority>
    </url>
@endforeach
</urlset>
