<?php

/**
 * check if the user has administrator permissions
 * @return bool
 */
function isAdmin()
{
    require_once("model/users_possesses_roles.php");
    return hasRole($_SESSION["username"], "administrator");
}

/**
 * checks if the user has editor permissions
 * @return bool
 */
function canEdit()
{
    require_once("model/users_possesses_roles.php");
    $roles = getUserRoles($_SESSION["username"]);
    return in_array_r("administrator", $roles) | in_array_r("editor", $roles);
}
