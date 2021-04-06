<?php

function recipeList($request)
{
    require_once("view/recipeList.php");
    require_once("model/recipes.php");
    require_once("view/assets/components/pagination.php");

    // Filters/default page
    $page = filter_var(@$request["page"], FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
    // Filters/default amount of roles per page
    $amount = filter_var(@$request["amount"], FILTER_VALIDATE_INT, ["options" => ["default" => 5, "min_range" => 1]]);

    $rowCount = countRecipes();

    // Generate pagination
    $pagination = componentPagination(ceil($rowCount / $amount), $page + 1, $amount, "/recipes");

    $recipes = getRecipeList();
    viewRecipeList($recipes,$pagination);
}
