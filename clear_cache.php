<?php
require 'vendor/autoload.php';

// Clear the rate limiting cache
$pdo = new PDO('sqlite:database/database.sqlite');

// Get all sessions to clear cache entries
$sessions_dir = 'storage/framework/cache/data';
if (is_dir($sessions_dir)) {
    $files = glob($sessions_dir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "Cache cleared\n";
} else {
    echo "Cache directory not found\n";
}
?>
