<?php

$files = [
    'frontend/assets/css/vendors/bootstrap.css',
    'frontend/assets/css/animate.min.css',
    'frontend/assets/css/bulk-style.css',
    'frontend/assets/css/vendors/animate.css',
    'frontend/assets/css/style.css',
    'frontend/assets/css/gd-style.css',
];

$combined = '';

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file; // Use __DIR__ to get the current script directory
    if (file_exists($path)) {
        $css = file_get_contents($path);
        // Remove comments, spaces, and line breaks
        $css = preg_replace('!/\*.*?\*/!s', '', $css);
        $css = preg_replace('/\n\s*\n/', "\n", $css);
        $css = preg_replace('/[\n\r \t]/', ' ', $css);
        $css = preg_replace('/ +/', ' ', $css);
        $css = preg_replace('/ ?([,:;{}]) ?/', '$1', $css);
        $css = str_replace(';}', '}', $css);

        $combined .= $css;
    } else {
        echo "File not found: $file\n";
    }
}

$outputPath = __DIR__ . '/frontend/assets/css/all.min.css';
file_put_contents($outputPath, $combined);

echo "✅ Minified CSS generated successfully!";
