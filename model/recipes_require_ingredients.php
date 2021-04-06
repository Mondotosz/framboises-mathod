<?php

function getRecipeIngredients($recipeID)
{
    require_once("model/dbConnector.php");
    $query =
        "SELECT ingredients.id as 'id', ingredients.name as 'name' FROM recipes_requires_ingredients AS join_table
	    LEFT OUTER JOIN recipes
		    ON recipes.id = join_table.recipes_id
	    LEFT OUTER JOIN ingredients
		    ON ingredients.id = join_table.ingredients_id
	    WHERE recipes.id LIKE :recipeID";

    $res = executeQuerySelect($query, createBinds([[":recipeID", $recipeID, PDO::PARAM_INT]]));
    return $res;
}
