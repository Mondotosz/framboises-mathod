<?php

/**
 * @brief gets every users from the database
 * @warn 
 */
function getUsers($limit = null, $offset = null)
{
    require_once("model/dbConnector.php");
    if (isset($limit) && isset($offset)) {
        $query = "SELECT * FROM users LIMIT $offset, $limit";
    } else if (isset($limit)) {
        $query = "SELECT * FROM users LIMIT $limit";
    } else {
        $query = "SELECT * FROM users";
    }

    $res = executeQuerySelect($query);
    return $res;
}

function getUserByUsername($username)
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
