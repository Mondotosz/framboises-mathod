<?php

function getIngredientByName($name){
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM ingredients WHERE name LIKE :name";

    $res = executeQuerySelect($query,createBinds([[":name",$name]]));
    return $res;
}

/**
 * @brief adds an ingredient
 * @param string $name
 * @return int|null id of the last insert| null on failure
 */
function addIngredient($name)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO ingredients (name) VALUES(:name)";

    $res = executeQueryInsert($query, createBinds([[":name",$name]]));
    return $res;
}
