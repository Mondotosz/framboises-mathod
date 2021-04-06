<?php

/**
 * @brief gets every users from the database
 * @warning limits and anf offset must be >= 0
 * @param int $limit maximum amount of entries returned
 * @param int $offset entries to be skipped
 * @return array|null array of users | null on query fail
 */
function getUsers($limit = null, $offset = null)
{
    require_once("model/dbConnector.php");
    $bindValue = [];
    if (isset($limit) && isset($offset)) {
        $query = "SELECT * FROM users LIMIT :offset, :limit";
        $bindValue = createBinds([[":offset", $offset, PDO::PARAM_INT], [":limit", $limit, PDO::PARAM_INT]]);
    } else if (isset($limit)) {
        $query = "SELECT * FROM users LIMIT :limit";
        $bindValue = createBinds([[":limit", $limit, PDO::PARAM_INT]]);
    } else {
        $query = "SELECT * FROM users";
    }

    $res = executeQuerySelect($query, $bindValue);
    return $res;
}

/**
 * @brief gets user with a given name
 * @param string username
 * @return array|null array of user | null on query fail/no match
 */
function getUserByUsername($username)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM users WHERE username like :username";
    $res = executeQuerySelect($query, createBinds([[":username",$username]]));
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

/**
 * @brief gets user with a given email
 * @param string email
 * @return array|null array of user | null on query fail/no match
 */
function getUserByEmail($email)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM users WHERE email like :email";

    $res = executeQuerySelect($query, createBinds([[":email",$email]]));
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

/**
 * @brief count users in database
 * @return int number of entries
 */
function countUsers()
{
    require_once("model/dbConnector.php");
    return countEntries('users');
}

/**
 * @brief adds an user to the database
 * @param string username
 * @param string email
 * @param string password (encrypt password)
 * @return bool|null success | null on query failure
 */
function addUser($username, $email, $password)
{
    require_once("model/dbConnector.php");
    // hash password
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";


    $res = executeQueryIUD($query, createBinds([[":username",$username],[":email",$email],[":password",$password]]));

    return $res;
}
