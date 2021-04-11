<?php

/**
 * adds a step to a recipe
 * @param int $number step number
 * @param string $instruction
 * @param int $recipeID id of the recipe
 * @return int|null id of the last insert| null on failure
 */
function addStep($number, $instruction, $recipeID)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO steps (number, instruction, recipes_id) VALUES(:number, :instruction, :recipeID)";

    $res = executeQueryInsert($query, createBinds([[":number", $number, PDO::PARAM_INT], [":instruction", $instruction], [":recipeID", $recipeID, PDO::PARAM_INT]]));
    return $res;
}

function deleteStep($id)
{
    require_once("model/dbConnector.php");
    $query = "DELETE FROM steps WHERE id = :id";
    return executeQueryIUDAffected($query, createBinds([[":id", $id, PDO::PARAM_INT]]));
}

function getStep($id)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM steps WHERE id = :id LIMIT 1";
    $res = executeQuerySelect($query, createBinds([[":id", $id, PDO::PARAM_INT]]));
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

function setStep($id,$number,$instruction){
    require_once("model/dbConnector.php");
    $query = "UPDATE steps SET number = :number, instruction = :instruction WHERE id = :id";
    return executeQueryIUDAffected($query,createBinds([[":number",$number,PDO::PARAM_INT],[":instruction",$instruction],[":id",$id,PDO::PARAM_INT]]));
}