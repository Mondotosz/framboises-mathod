<?php

function getUserRoles($username)
{
    require_once("model/dbConnector.php");
    $query =
        "SELECT roles.name as 'role' FROM users_possesses_roles AS join_table
	    LEFT OUTER JOIN users
		    ON users.id = join_table.users_id
	    LEFT OUTER JOIN roles
		    ON roles.id = join_table.roles_id
	    WHERE users.username LIKE '$username'";

    $res = executeQuerySelect($query);
    return $res;
}

function getRoleUsers($role)
{
    require_once("model/dbConnector.php");
    $query =
        "SELECT users.username AS 'username', users.email AS 'email' FROM users_possesses_roles AS join_table
        LEFT OUTER JOIN users
            ON users.id = join_table.users_id
        LEFT OUTER JOIN roles
            ON roles.id = join_table.roles_id
        WHERE roles.name LIKE '$role'";

    $res = executeQuerySelect($query);
    return $res;
}

function addRoleToUser($username,$role){
    require_once("model/dbConnector.php");

    require_once("model/users.php");
    $userID = getUseByUsername($username)["id"];
    if(empty($userID)){
        throw new Exception("Couldn't find user");
    }
    
    require_once("model/users.php");
    $roleID = getUseByUsername($role);
    if(empty($roleID)){
        throw new Exception("Couldn't find role");
    }

    $query = 
        "INSERT INTO users_possesses_roles (users_id, roles_id)
        VALUES ($userID, $roleID)";

    $res = executeQueryIUD($query);
    return $res;

}