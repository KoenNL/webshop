<?php

spl_autoload_register(function ($classname) {
    if (stripos(php_uname(), 'windows') !== false) {
        $file = dirname(__DIR__) . '\\' . $classname . '.php';
    } else {
        $file = dirname(__DIR__) . '/' . str_replace('\\', '/', $classname) . '.php';
    }
    if (!file_exists($file)) {
        return false;
    }
    require_once $file;
});