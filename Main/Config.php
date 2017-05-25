<?php

namespace Main;

class Config
{

    const KORE_VERSION = '0.1';
    
    private static $config = array();

    /**
     * Set the content of the config file.
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * Get a config setting.
     * @param string $name recusive name of the setting using "." as delimiter.
     * @return mixed
     */
    public static function getValue($name)
    {
        $keys = explode('.', $name);

        $config = self::$config;
        foreach ($keys as $key) {
            if (!isset($config[$key])) {
                return null;
            }

            // Search recursively
            if (is_array($config[$key])) {
                $config = $config[$key];
                continue;
            }

            return $config[$key];
        }
    }
}
