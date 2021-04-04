<?php

function getRoles()
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM roles";

    $res = executeQuerySelect($query);
    return $res;
}

function getRoleByName($name)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM roles WHERE name LIKE '$name'";

    $res = executeQuerySelect($query);
    return $res;
}

function addRole($name)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO roles (name) VALUES ('$name')";

    $res = executeQueryIUD($query);
    return $res;
}
