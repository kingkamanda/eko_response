<?php

class General
{
    /**
     * Trim and strip tags from user input. Values are stored via prepared
     * statements and escaped with htmlspecialchars() at output time.
     */
    public static function sanitizer($value)
    {
        return trim(strip_tags((string) $value));
    }
}
