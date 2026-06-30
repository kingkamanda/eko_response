<?php
/**
 * Trim and strip tags from user input. Values are stored via prepared
 * statements (so no slash-escaping is needed here) and escaped with
 * htmlspecialchars() at the point of output.
 */
function sanitizer($value)
{
    return trim(strip_tags((string) $value));
}
