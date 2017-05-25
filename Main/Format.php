<?php

namespace Main;

class Format
{

    /**
     * Format a undercase_spaced_string to a CamelCaseString.
     * @param string $string string to format.
     * @param boolean $start_uppercase first letter uppercase or not. True by default.
     * @return string formatted string
     */
    public static function underscoreToCamelCase($string, $start_uppercase = true)
    {
        if ($start_uppercase) {
            return str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($string))));
        }
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($string)))));
    }
    
    /**
     * Minifi the given string by removing spaces and new lines.
     * @param string $string
     * @return string
     */
    public static function minifi($string)
    {
        return str_replace(array("\r\n", "\r", "\n", ' '), '', $string);
    }
}
