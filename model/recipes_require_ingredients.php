<?php

/**
 * fetch every ingredient from a recipe
 * @param int $recipeID id of the recipe
 * @return array|null array of ingredients|null on query failure
 */
function getRecipeIngredients($recipeID)
{
    require_once("model/dbConnector.php");
    $query =
        "SELECT ingredients.id AS 'id', ingredients.name AS 'name', join_table.amount AS 'amount' FROM recipes_requires_ingredients AS join_table
	    LEFT OUTER JOIN recipes
		    ON recipes.id = join_table.recipes_id
	    LEFT OUTER JOIN ingredients
		    ON ingredients.id = join_table.ingredients_id
	    WHERE recipes.id LIKE :recipeID";

    $res = executeQuerySelect($query, createBinds([[":recipeID", $recipeID, PDO::PARAM_INT]]));
    return $res;
}

/**
 * links a recipe and an ingredient
 * @param int $recipeID id of the recipe
 * @param int $ingredientID id of the ingredient
 * @param float $amount
 * @return int|null id of the insert | null on query failure
 */
function associateRecipeIngredient($recipeID, $ingredientID, $amount)
{
    require_once("model/dbConnector.php");
    $query = "INSERT INTO recipes_requires_ingredients (recipes_id, ingredients_id, amount) VALUES (:recipeID, :ingredientID, :amount)";

    $res = executeQueryInsert($query, createBinds([[":recipeID", $recipeID, PDO::PARAM_INT], [":ingredientID", $ingredientID, PDO::PARAM_INT], [":amount", $amount]]));
    return $res;
}

/**
 * check if a recipe has an ingredient
 * @param int $recipeID
 * @param int $ingredientID
 * @return bool|null
 */
function recipeHasIngredient($recipeID, $ingredientID)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM recipes_requires_ingredients WHERE recipes_id = :recipeID AND ingredients_id = :ingredientID LIMIT 1";

    $res = executeQuerySelect($query, createBinds([[":recipeID", $recipeID, PDO::PARAM_INT], [":ingredientID", $ingredientID, PDO::PARAM_INT]]));
    if (!is_null($res)) {
        $res = !empty($res);
    }
    return $res;
}

/**
 * unlinks a recipe and an ingredient
 * @param int $recipeID id of the recipe
 * @param int $ingredientID id of the ingredient
 * @return int|null affected rows | null on query failure
 */
function dissociateRecipeIngredient($recipeID, $ingredientID)
{
    require_once("model/dbConnector.php");
    $query = "DELETE FROM recipes_requires_ingredients WHERE recipes_id = :recipeID AND ingredients_id = :ingredientID";
    return executeQueryIUDAffected($query, createBinds([[":recipeID", $recipeID, PDO::PARAM_INT], [":ingredientID", $ingredientID, PDO::PARAM_INT]]));
}

function getRecipeIngredient($recipeID, $ingredientID)
{
    require_once("model/dbConnector.php");
    $query = "SELECT join_table.amount AS 'amount', ingredients.name AS 'name' FROM recipes_requires_ingredients AS join_table LEFT JOIN ingredients ON ingredients.id = join_table.ingredients_id WHERE join_table.recipes_id = :recipeID AND join_table.ingredients_id = :ingredientID LIMIT 1";
    $res = executeQuerySelect($query, createBinds([[":recipeID", $recipeID, PDO::PARAM_INT], [":ingredientID", $ingredientID, PDO::PARAM_INT]]));
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

function updateAmount($recipeID, $ingredientID, $amount)
{
    require_once("model/dbConnector.php");
    $query = "UPDATE recipes_requires_ingredients SET amount = :amount WHERE recipes_id = :recipeID AND ingredients_id = :ingredientID";
    return executeQueryIUDAffected($query, createBinds([[":amount", $amount], [":recipeID", $recipeID, PDO::PARAM_INT], [":ingredientID", $ingredientID, PDO::PARAM_INT]]));
}
