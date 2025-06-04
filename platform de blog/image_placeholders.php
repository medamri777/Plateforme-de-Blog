<?php
/**
 * Image Placeholder Generator
 * 
 * This script generates placeholder images for the blog.
 * It creates colorful images with text labels.
 */

// Set header to output an image
header('Content-Type: image/png');

// Get image parameters from URL or use defaults
$width = isset($_GET['width']) ? intval($_GET['width']) : 1200;
$height = isset($_GET['height']) ? intval($_GET['height']) : 600;
$text = isset($_GET['text']) ? $_GET['text'] : 'Nador, Maroc';
$type = isset($_GET['type']) ? $_GET['type'] : 'view';

// Limit dimensions for security
$width = min(max($width, 50), 2000);
$height = min(max($height, 50), 1000);

// Create the image
$image = imagecreatetruecolor($width, $height);

// Define colors based on type (Moroccan flag colors)
switch ($type) {
    case 'tourism':
        $bg_color = imagecolorallocate($image, 50, 100, 168); // Blue
        break;
    case 'culture':
        $bg_color = imagecolorallocate($image, 193, 39, 45); // Moroccan red
        break;
    case 'gastronomy':
        $bg_color = imagecolorallocate($image, 110, 60, 30); // Brown
        break;
    case 'contact':
        $bg_color = imagecolorallocate($image, 80, 130, 180); // Light blue
        break;
    case 'panorama':
        $bg_color = imagecolorallocate($image, 0, 98, 51); // Moroccan green
        break;
    default:
        $bg_color = imagecolorallocate($image, 0, 98, 51); // Moroccan green
}

// Fill background
imagefill($image, 0, 0, $bg_color);

// Add pattern
for ($i = 0; $i < $width; $i += 30) {
    for ($j = 0; $j < $height; $j += 30) {
        // Draw small rectangles or circles for texture
        if (($i + $j) % 60 == 0) {
            $pattern_color = imagecolorallocatealpha($image, 255, 255, 255, 110);
            imagefilledrectangle($image, $i, $j, $i + 15, $j + 15, $pattern_color);
        }
    }
}

// Add text
$text_color = imagecolorallocate($image, 255, 255, 255);
$font_size = 5;
$font = 5; // Built-in font (1-5)

// Calculate text position
$text_width = imagefontwidth($font) * strlen($text);
$text_height = imagefontheight($font);
$text_x = ($width - $text_width) / 2;
$text_y = ($height - $text_height) / 2;

// Draw text
imagestring($image, $font, $text_x, $text_y, $text, $text_color);

// Draw border
$border_color = imagecolorallocate($image, 255, 255, 255);
imagerectangle($image, 0, 0, $width - 1, $height - 1, $border_color);

// Output the image
imagepng($image);

// Free memory
imagedestroy($image);
?> 