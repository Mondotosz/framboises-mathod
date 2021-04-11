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
