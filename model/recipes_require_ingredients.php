<?php

/**
 * @brief fetch every ingredient from a recipe
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

function associateRecipeIngredient($recipeID,$ingredientID,$amount){
    require_once("model/dbConnector.php");
    $query = "INSERT INTO recipes_requires_ingredients (recipes_id, ingredients_id, amount) VALUES (:recipeID, :ingredientID, :amount)";

    $res = executeQueryInsert($query, createBinds([[":recipeID",$recipeID,PDO::PARAM_INT],[":ingredientID",$ingredientID,PDO::PARAM_INT],[":amount",$amount]]));
    return $res;
}