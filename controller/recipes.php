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
    foreach ($recipes as $key => $recipe) {
        foreach($recipe["time"] as $timekey=>$time){
            if ($time > strtotime("01:00:00")) {
                $recipes[$key]["time"]["$timekey"] = date("H", $time) . "h" . date("i", $time) . "m";
            } else {
                $recipes[$key]["time"][$timekey] = (1 * date("i", $time)) . "m";
            }
        }
    }
    viewRecipeList($recipes, $pagination);
}
