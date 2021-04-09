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
    $bindValue = [];
    if (isset($limit) && isset($offset)) {
        $query = "SELECT * FROM roles LIMIT :offset , :limit";
        $bindValue = createBinds([[":offset", $offset, PDO::PARAM_INT],[":limit", $limit, PDO::PARAM_INT]]);
    } else if (isset($limit)) {
        $query = "SELECT * FROM roles LIMIT :limit";
        $bindValue = createBinds([[":limit", $limit, PDO::PARAM_INT]]);
    } else {
        $query = "SELECT * FROM roles";
    }
    $res = executeQuerySelect($query, $bindValue);
    return $res;
}

/**
 * @brief gets roles with a given name
 * @param string $name role name
 * @return array|null array of roles (empty if no matches) | null on query fail
 */
function getRoleByName($name)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM roles WHERE name LIKE :name";

    $res = executeQuerySelect($query, createBinds([[":name",$name]]));
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
 * @param string $name role name
 * @return bool|null success status | null on query fail
 */
function addRole($name)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO roles (name) VALUES (:name)";

    $res = executeQueryIUD($query, [":name" => $name]);
    return $res;
}
