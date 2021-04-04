<?php

function getUsers()
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM users";

    $res = executeQuerySelect($query);
    return $res;
}

function getUseByUsername($username)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM users WHERE username like '$username'";
    $res = executeQuerySelect($query);
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

function getUserByEmail($email)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM users WHERE email like '$email'";

    $res = executeQuerySelect($query);
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

function countUsers()
{
    require_once("model/dbConnector.php");
    return countEntries('users');
}

function addUser($username, $email, $password)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    $res = executeQueryIUD($query);
    return $res;
}
