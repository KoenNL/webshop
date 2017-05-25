<?php

spl_autoload_register(function($classname) {
    $file = dirname(__DIR__) . '/' . str_replace('\\', '/', $classname) . '.php';
    if (!file_exists($file)) {
        return false;
    }
    require_once $file;
});