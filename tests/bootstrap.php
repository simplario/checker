<?php

// Bootstrap
// =========================================
$deep = 5;
$file = 'vendor/autoload.php';
while ($deep--) {
    $prefix = str_repeat('../', $deep);
    if (is_file($prefix . $file)) {
        require_once $prefix . $file;
        return null;
    }
}
die('Can\'t find composer "vendor/autoload.php".');