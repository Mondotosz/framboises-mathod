<?php

/**
 * This function is designed to execute a query received as parameter
 * @param $query : must be correctly build for sql (synthaxis) but the protection against sql injection will be done there
 * @return array|null : get the query result (can be null)
 */
function executeQuerySelect($query)
{
    $queryResult = null;

    $dbConnexion = openDBConnexion(); //open database connexion
    if ($dbConnexion != null) {
        $statement = $dbConnexion->prepare($query); //prepare query
        $statement->execute(); //execute query
        $queryResult = $statement->fetchAll(); //prepare result for client
    }
    $dbConnexion = null; //close database connexion
    return $queryResult;
}

/**
 * This function is designed to insert value in database
 * @param $query
 * @return bool|null : $statement->execute() returne true is the insert was successful
 */
function executeQueryIUD($query)
{
    $queryResult = null;

    $dbConnexion = openDBConnexion(); //open database connexion
    if ($dbConnexion != null) {
        $statement = $dbConnexion->prepare($query); //prepare query
        $queryResult = $statement->execute(); //execute query
    }
    $dbConnexion = null; //close database connexion
    return $queryResult;
}

// TODO export logins to config file
/**
 * This function is designed to manage the database connexion. Closing will be not proceeded there. The client is responsible of this.
 * @return PDO|null
 */
function openDBConnexion()
{
    $tempDbConnexion = null;

    $sqlDriver = 'mysql';
    $hostname = 'localhost';
    $port = 3306;
    $charset = 'utf8';
    $dbName = 'framboises';
    $userName = 'framboises'; //par compatibilité avec le dépôt swisscenter
    $userPwd = 'Pa$$w0rd';
    $dsn = $sqlDriver . ':host=' . $hostname . ';dbname=' . $dbName . ';port=' . $port . ';charset=' . $charset;

    try {
        $tempDbConnexion = new PDO($dsn, $userName, $userPwd);
    } catch (PDOException $exception) {
        echo 'Connection failed: ' . $exception->getMessage();
    }
    return $tempDbConnexion;
}

/**
 * @brief count entries in a table
 * @warning table must have an id column
 * @TODO handle failure
 * @param string table name
 */
function countEntries($table)
{
    $query = "SELECT COUNT(id) AS 'count' FROM $table";

    $res = executeQuerySelect($query);
    return $res[0]["count"];
}
