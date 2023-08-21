<?php 

// Естественно скрипт можно оптимизировать и улучшить, но нет времени 

function env($key, $default = null) {
    $envFilePath = __basepath__ . DIRECTORY_SEPARATOR . '.env';

    if (file_exists($envFilePath)) {
        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                if ($name === $key) {
                    return $value;
                }
            }
        }
    }
    return $default;
}