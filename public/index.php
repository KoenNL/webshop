<?php
require_once '../Main/AutoLoader.php';
session_start();
try {
    Main\Config::setConfig(require_once '../config.php');
    $loader = new Main\Loader();
    $loader->run($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    exit($e->getMessage());
}