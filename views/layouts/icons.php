<?php
/**
 * Icon garis (outline) untuk sidebar, mengikuti gaya referensi:
 * garis tebal, ujung membulat, tanpa isi warna.
 * Pemakaian: <?= sidebar_icon('home') ?>
 */
if (!function_exists('sidebar_icon')) {
    function sidebar_icon(string $name): string
    {
        $paths = [
            // rumah dengan cerobong, jendela bulat & pintu
            'home' =>
                '<path d="M3 11.5 12 4l9 7.5"/>' .
                '<path d="M5.5 10v10h13V10"/>' .
                '<path d="M16 6.5V4h2v4.2"/>' .
                '<circle cx="12" cy="11.2" r="1.5"/>' .
                '<path d="M10 20v-4.5h4V20"/>',

            // kaca pembesar
            'search' =>
                '<circle cx="10.5" cy="10.5" r="6.5"/>' .
                '<path d="m15.5 15.5 5 5"/>',

            // siluet orang
            'user' =>
                '<circle cx="12" cy="7.5" r="4"/>' .
                '<path d="M4.5 20.5c0-4 2-6.5 7.5-6.5s7.5 2.5 7.5 6.5z"/>',

            // pesawat kertas
            'send' =>
                '<path d="M21 3 3 10.5l7 3 3 7z"/>' .
                '<path d="M21 3 10 13.5"/>',

            // amplop
            'mail' =>
                '<rect x="3" y="5.5" width="18" height="13" rx="2"/>' .
                '<path d="m3.5 7 8.5 6 8.5-6"/>',

            // hati
            'heart' =>
                '<path d="M12 20.5C5 15.5 3 12 3 9a4.5 4.5 0 0 1 9-1.5A4.5 4.5 0 0 1 21 9c0 3-2 6.5-9 11.5z"/>',
        ];

        $inner = $paths[$name] ?? '';

        return '<svg class="menu-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" '
             . 'stroke-width="2" stroke-linecap="round" stroke-linejoin="round" '
             . 'aria-hidden="true" focusable="false">' . $inner . '</svg>';
    }
}
