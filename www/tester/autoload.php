<?php

define("__basepath__", __DIR__);


spl_autoload_register(function ($class) {
    $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (file_exists($classFile)) {
        require_once $classFile;
    }
});

