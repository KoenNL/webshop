<?php

$config = array(
    'debug' => true,
    'path' => array(
        'base' => __DIR__ . '/',
        'host' => 'http://webshop.local',
    ),
    'database' => array (
        'username' => 'webshop',
        'password' => '',
        'host' => 'localhost',
        'name' => 'webshop',
        'characterset' => 'utf-8',
    ),
    'loader' => array(
        'default_controller' => 'main',
        'default_action' => 'index',
    )
);

return $config;