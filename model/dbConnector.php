<?php
//TODO refactor with bind params

/**
 * This function is designed to execute a query received as parameter
 * @param $query : must be correctly build for sql (synthaxis) but the protection against sql injection will be done there
 * @param array $params [":queryBind",$value] for sql injection prevention
 * @return array|null : get the query result (can be null)
 */
function executeQuerySelect($query, $binds = [])
{
    $queryResult = null;

    $dbConnexion = openDBConnexion(); //open database connexion
    if ($dbConnexion != null) {
        $statement = $dbConnexion->prepare($query); //prepare query

        // Bind params for safety
        foreach ($binds as $bind) {
            $statement->bindParam($bind["name"], $bind["value"], $bind["type"] ?? PDO::PARAM_STR);
        }

        $statement->execute(); //execute query
        $queryResult = $statement->fetchAll(); //prepare result for client
    }
    $dbConnexion = null; //close database connexion
    return $queryResult;
}

/**
 * This function is designed to insert value in database
 * @param $query
 * @param array $binds [":queryBind",$value] for sql injection prevention
 * @return bool|null : $statement->execute() return true is the insert was successful
 */
function executeQueryIUD($query, $binds = [])
{
    $queryResult = null;

    $dbConnexion = openDBConnexion(); //open database connexion
    if ($dbConnexion != null) {
        $statement = $dbConnexion->prepare($query); //prepare query

        // bind params for safety
        foreach ($binds as $bind) {
            $statement->bindParam($bind["name"], $bind["value"], $bind["type"] ?? PDO::PARAM_STR);
        }

        $queryResult = $statement->execute(); //execute query
    }
    $dbConnexion = null; //close database connexion
    return $queryResult;
}

/**
 * This function is designed to insert value in database
 * @param $query
 * @param array $binds [":queryBind",$value] for sql injection prevention
 * @return int|null : last inserted id | $statement->execute() return true is the insert was successful
 */
function executeQueryInsert($query, $binds = [])
{
    $queryResult = null;

    $dbConnexion = openDBConnexion(); //open database connexion
    if ($dbConnexion != null) {
        $statement = $dbConnexion->prepare($query); //prepare query

        // bind params for safety
        foreach ($binds as $bind) {
            $statement->bindParam($bind["name"], $bind["value"], $bind["type"] ?? PDO::PARAM_STR);
        }

        $queryResult = $statement->execute(); //execute query

        if ($queryResult) {
            $queryResult = $dbConnexion->lastInsertId();
        } else {
            $queryResult = null;
        }
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

    $res = executeQuerySelect($query, []);
    return $res[0]["count"];
}

/**
 * @brief creates a binds array ["name" => $name, "value" => $value, "type" => $type]
 * @param string binding name in sql Eg. ":id"
 * @param mixed value to be checked and stored
 * @param int PDO::PARAM_type datatype in the database, defaults to string
 * @return array array with key/value pairs to be stored in an array passed to query execution
 */
function createBind($name, $value, $type = PDO::PARAM_STR)
{
    return ["name" => $name, "value" => $value, "type" => $type];
}

/**
 * @brief creates a 2d array with binds for query execution
 * @param array expected [[":param",value,PDO::PARAM_INT],[":otherParam",otherValue]]
 * @return array 2d array ready for query execution
 */
function createBinds($arr)
{
    $binds = [];
    foreach ($arr as $bind) {
        if (count($bind) < 2) {
            throw new Exception("Binds expect 2-3 values");
        } else {
            $tmp = createBind($bind[0], $bind[1], isset($bind[2]) ? $bind[2] : PDO::PARAM_STR);
            array_push($binds, $tmp);
        }
    }
    return $binds;
}
