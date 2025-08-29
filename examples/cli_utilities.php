<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Phastron\Cli\Color;

echo Color::gradient("🎨 Phastron CLI Utilities Demo", '#ff6b6b', '#4ecdc4') . "\n\n";

// 1. Basic Color Usage
echo Color::bold("1. Basic Color Usage:\n");
echo Color::colorize("Red text", 'red') . "\n";
echo Color::colorize("Green text", 'green') . "\n";
echo Color::colorize("Blue text", 'blue') . "\n";
echo Color::colorize("Yellow text", 'yellow') . "\n";
echo Color::colorize("Magenta text", 'magenta') . "\n";
echo Color::colorize("Cyan text", 'cyan') . "\n";
echo Color::colorize("White text", 'white') . "\n";
echo Color::colorize("Black text", 'black') . "\n\n";

// 2. Background Colors
echo Color::bold("2. Background Colors:\n");
echo Color::background("Red background", 'red') . "\n";
echo Color::background("Green background", 'green') . "\n";
echo Color::background("Blue background", 'blue') . "\n";
echo Color::background("Yellow background", 'yellow') . "\n";
echo Color::background("Magenta background", 'magenta') . "\n";
echo Color::background("Cyan background", 'cyan') . "\n";
echo Color::background("White background", 'white') . "\n";
echo Color::background("Black background", 'black') . "\n\n";

// 3. Text Formatting
echo Color::bold("3. Text Formatting:\n");
echo Color::bold("Bold text") . "\n";
echo Color::italic("Italic text") . "\n";
echo Color::underline("Underlined text") . "\n";
echo Color::bold(Color::colorize("Bold and colored", 'red')) . "\n";
echo Color::italic(Color::background("Italic with background", 'blue')) . "\n\n";

// 4. Gradient Examples
echo Color::bold("4. Gradient Examples:\n");
echo Color::gradient("Rainbow gradient text!", '#ff0000', '#00ff00') . "\n";
echo Color::gradient("Blue to purple gradient", '#0066ff', '#9900ff') . "\n";
echo Color::gradient("Sunset colors", '#ff6b6b', '#feca57') . "\n";
echo Color::gradient("Ocean colors", '#48dbfb', '#0abde3') . "\n";
echo Color::gradient("Forest colors", '#1dd1a1', '#10ac84') . "\n\n";

// 5. Custom Hex Colors
echo Color::bold("5. Custom Hex Colors:\n");
echo Color::gradient("Custom red to blue", '#ff0000', '#0000ff') . "\n";
echo Color::gradient("Gold to silver", '#ffd700', '#c0c0c0') . "\n";
echo Color::gradient("Pink to cyan", '#ff69b4', '#00ffff') . "\n";
echo Color::gradient("Orange to green", '#ffa500', '#008000') . "\n\n";

// 6. Color Combinations
echo Color::bold("6. Color Combinations:\n");
echo Color::colorize(Color::bold("Bold red text"), 'red') . "\n";
echo Color::background(Color::italic("Italic blue background"), 'blue') . "\n";
echo Color::underline(Color::colorize("Underlined green text", 'green')) . "\n";
echo Color::bold(Color::background("Bold text with background", 'yellow')) . "\n\n";

// 7. Status Messages
echo Color::bold("7. Status Messages:\n");
echo Color::colorize("✓ Success message", 'green') . "\n";
echo Color::colorize("⚠ Warning message", 'yellow') . "\n";
echo Color::colorize("✗ Error message", 'red') . "\n";
echo Color::colorize("ℹ Info message", 'cyan') . "\n";
echo Color::colorize("🔒 Security notice", 'magenta') . "\n\n";

// 8. Progress Indicators
echo Color::bold("8. Progress Indicators:\n");
for ($i = 0; $i <= 100; $i += 10) {
    $progress = str_repeat('█', $i / 10) . str_repeat('░', 10 - ($i / 10));
    $color = $i < 30 ? 'red' : ($i < 70 ? 'yellow' : 'green');
    echo "\r" . Color::colorize("Progress: [{$progress}] {$i}%", $color);
    usleep(100000); // 0.1 second delay
}
echo "\n\n";

// 9. Table-like Output
echo Color::bold("9. Table-like Output:\n");
$headers = ['Name', 'Age', 'City', 'Status'];
$data = [
    ['John Doe', '30', 'New York', 'Active'],
    ['Jane Smith', '25', 'Los Angeles', 'Active'],
    ['Bob Johnson', '35', 'Chicago', 'Inactive'],
    ['Alice Brown', '28', 'Houston', 'Active']
];

// Print headers
foreach ($headers as $header) {
    echo Color::bold(Color::background(str_pad($header, 15), 'blue')) . " ";
}
echo "\n";

// Print data rows
foreach ($data as $row) {
    foreach ($row as $cell) {
        echo str_pad($cell, 15) . " ";
    }
    echo "\n";
}
echo "\n";

// 10. Interactive Elements
echo Color::bold("10. Interactive Elements:\n");
echo Color::colorize("→ Click here to continue", 'cyan') . "\n";
echo Color::colorize("← Go back", 'blue') . "\n";
echo Color::colorize("↑ Scroll up", 'green') . "\n";
echo Color::colorize("↓ Scroll down", 'green') . "\n";
echo Color::colorize("⌫ Delete", 'red') . "\n";
echo Color::colorize("⏎ Enter", 'yellow') . "\n\n";

// 11. Code Highlighting
echo Color::bold("11. Code Highlighting:\n");
echo Color::colorize("function", 'magenta') . " " . 
     Color::colorize("sortArray", 'cyan') . "(" . 
     Color::colorize("array", 'yellow') . " " . 
     Color::colorize("\$data", 'green') . ") {\n";
echo "    " . Color::colorize("return", 'magenta') . " " . 
     Color::colorize("Engine", 'cyan') . "::" . 
     Color::colorize("sort", 'cyan') . "(" . 
     Color::colorize("\$data", 'green') . ");\n";
echo "}\n\n";

// 12. ASCII Art with Colors
echo Color::bold("12. ASCII Art with Colors:\n");
$asciiArt = [
    "  ⭐  ",
    " ⭐⭐⭐ ",
    "⭐⭐⭐⭐⭐",
    " ⭐⭐⭐ ",
    "  ⭐  "
];

foreach ($asciiArt as $line) {
    echo Color::gradient($line, '#ffd700', '#ff6b6b') . "\n";
}
echo "\n";

// 13. Terminal Detection
echo Color::bold("13. Terminal Capabilities:\n");
$term = getenv('TERM');
$colorterm = getenv('COLORTERM');

echo "Terminal: " . ($term ?: 'Unknown') . "\n";
echo "Color support: " . ($colorterm ?: 'Unknown') . "\n";

if (function_exists('posix_isatty')) {
    echo "Is TTY: " . (posix_isatty(STDOUT) ? 'Yes' : 'No') . "\n";
}

echo "\n";

// 14. Color Palette Demo
echo Color::bold("14. Color Palette Demo:\n");
$colors = ['red', 'green', 'blue', 'yellow', 'magenta', 'cyan'];
$sampleText = "Sample";

foreach ($colors as $color) {
    echo Color::colorize($sampleText, $color) . " ";
}
echo "\n";

foreach ($colors as $color) {
    echo Color::background($sampleText, $color) . " ";
}
echo "\n\n";

// 15. Performance Test
echo Color::bold("15. Performance Test:\n");
$iterations = 1000;
$start = microtime(true);

for ($i = 0; $i < $iterations; $i++) {
    Color::gradient("Performance test", '#ff0000', '#00ff00');
}

$end = microtime(true);
$time = ($end - $start) * 1000;

echo "Generated {$iterations} gradients in " . round($time, 2) . " ms\n";
echo "Average: " . round($time / $iterations, 4) . " ms per gradient\n\n";

echo Color::gradient("🎨 CLI utilities demo complete!", '#4ecdc4', '#ff6b6b') . "\n";
echo "Run 'php examples/cli_utilities.php' to see this demo again.\n";
