<?php

/**
 * @source https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array
 */
function in_array_r($needle,$haystack, $strict = false){
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}