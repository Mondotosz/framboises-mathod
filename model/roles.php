<?php

/**
 * @brief gets all users from the database with optional limits
 * @warning limits and anf offset must be >= 0
 * @param int $limit maximum amount of entries returned
 * @param int $offset entries to be skipped
 * @return array|null array of roles | null on query fail
 */
function getRoles($limit = null, $offset = null)
{
    require_once("model/dbConnector.php");
    if (isset($limit) && isset($offset)) {
        $query = "SELECT * FROM roles LIMIT $offset, $limit";
    } else if (isset($limit)) {
        $query = "SELECT * FROM roles LIMIT $limit";
    } else {
        $query = "SELECT * FROM roles";
    }
    file_put_contents("log.log", $query ."\n", FILE_APPEND);
    $res = executeQuerySelect($query);
    return $res;
}

/**
 * @brief gets roles with a given name
 * @param string role name
 * @return array|null array of roles (empty if no matches) | null on query fail
 */
function getRoleByName($name)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM roles WHERE name LIKE '$name'";

    $res = executeQuerySelect($query);
    return $res;
}

/**
 * @brief count roles in database
 * @return int number of entries
 */
function countRoles()
{
    require_once("model/dbConnector.php");
    return countEntries('roles');
}

/**
 * @brief adds a role to the database
 * @param string role name
 * @return bool|null success status | null on query fail
 */
function addRole($name)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO roles (name) VALUES ('$name')";

    $res = executeQueryIUD($query);
    return $res;
}
