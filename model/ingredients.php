<?php

/**
 * @brief get an ingredient by its name
 * @param string $name ingredient name
 * @return array|null array with the first occurrence | null on query failure
 */
function getIngredientByName(string $name)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM ingredients WHERE name LIKE :name LIMIT 1";

    $res = executeQuerySelect($query, createBinds([[":name", $name]]));
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

/**
 * @brief adds an ingredient
 * @param string $name ingredient name
 * @return int|null id of the last insert| null on failure
 */
function addIngredient(string $name)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO ingredients (name) VALUES(:name)";

    $res = executeQueryInsert($query, createBinds([[":name", $name]]));
    return $res;
}
