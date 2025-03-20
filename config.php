<?php
function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception("Missing .env file");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), "#") === 0) continue; // Ignore comments
        list($key, $value) = explode("=", $line, 2);
        $_ENV[trim($key)] = trim($value);
        putenv("$key=$value");
    }
}

// Load .env file
loadEnv(__DIR__ . '/.env');
?>