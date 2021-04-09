<?php

/**
 * gets all role from a given user
 * @param string $username username of the user
 * @return array|null array of roles | null on query failure
 */
function getUserRoles($username)
{
    require_once("model/dbConnector.php");
    $query =
        "SELECT roles.name as 'role' FROM users_possesses_roles AS join_table
	    LEFT OUTER JOIN users
		    ON users.id = join_table.users_id
	    LEFT OUTER JOIN roles
		    ON roles.id = join_table.roles_id
	    WHERE users.username LIKE :username";

    $res = executeQuerySelect($query, createBinds([[":username", $username]]));
    return $res;
}

/**
 * get all users from a given role
 * @param string $role role name
 * @return array|null array of users | null on query failure
 */
function getRoleUsers($role)
{
    require_once("model/dbConnector.php");
    $query =
        "SELECT users.username AS 'username', users.email AS 'email' FROM users_possesses_roles AS join_table
        LEFT OUTER JOIN users
            ON users.id = join_table.users_id
        LEFT OUTER JOIN roles
            ON roles.id = join_table.roles_id
        WHERE roles.name LIKE :role";

    $res = executeQuerySelect($query, createBinds([[":role", $role]]));
    return $res;
}

/**
 * adds a role to an user
 * @param string $username username of the target user
 * @param string $role name of given role
 * @throws Exception "Couldn't find user"
 * @throws Exception "Couldn't find role"
 * @return bool|null success status | null on query failure
 */
function addRoleToUser($username, $role)
{
    require_once("model/dbConnector.php");

    // Fetch user
    require_once("model/users.php");
    $userID = getUserByUsername($username)["id"];
    // Check if user exists
    if (empty($userID)) {
        throw new Exception("Couldn't find user");
    }

    // Fetch role
    require_once("model/users.php");
    $roleID = getUserByUsername($role);
    // Check if role exists
    if (empty($roleID)) {
        throw new Exception("Couldn't find role");
    }

    // Prepare statement
    $query =
        "INSERT INTO users_possesses_roles (users_id, roles_id)
        VALUES (:userID, :roleID)";

    // Execute insertion query
    $res = executeQueryIUD($query, createBinds([[":userID", $userID, PDO::PARAM_INT], [":roleID", $roleID, PDO::PARAM_INT]]));
    return $res;
}

/**
 * check if a given user has a given role
 * @param string $username username
 * @param string $role role name
 * @return bool
 */
function hasRole($username, $role)
{
    require_once("model/dbConnector.php");
    $query =
        "SELECT users.username AS 'username', roles.name AS 'role' FROM users_possesses_roles AS join_table
        LEFT OUTER JOIN users
            ON users.id = join_table.users_id
        LEFT OUTER JOIN roles
            ON roles.id = join_table.roles_id
        WHERE users.username LIKE :username AND roles.name LIKE :role";

    $res = executeQuerySelect($query, createBinds([[":username", $username], [":role", $role]]));
    // Check if there were any matches
    return (!empty($res));
}
