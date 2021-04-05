<?php

/**
 * @brief checks recursively if a needle is in an array
 * @source https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array
 * @param mixed $needle what's searched
 * @param array $haystack where it's searched
 * @return bool
 */
function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
