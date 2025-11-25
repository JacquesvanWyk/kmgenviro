@props(['name', 'size' => '24'])

@php
    $sizeClass = match($size) {
        '16' => 'w-4 h-4',
        '20' => 'w-5 h-5',
        '24' => 'w-6 h-6',
        '32' => 'w-8 h-8',
        '40' => 'w-10 h-10',
        '48' => 'w-12 h-12',
        '64' => 'w-16 h-16',
        default => 'w-6 h-6',
    };
@endphp

<span {{ $attributes->merge(['class' => "iconify $sizeClass inline-block"]) }} data-icon="solar:{{ $name }}-duotone"></span>

@once
    @push('scripts')
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    @endpush
@endonce
