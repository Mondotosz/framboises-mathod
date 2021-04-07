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
        foreach ($recipe["time"] as $timekey => $time) {
            if ($time > strtotime("01:00:00")) {
                $recipes[$key]["time"]["$timekey"] = date("H", $time) . "h" . date("i", $time) . "m";
            } else {
                $recipes[$key]["time"][$timekey] = (1 * date("i", $time)) . "m";
            }
        }
    }
    viewRecipeList($recipes, $pagination);
}

/**
 * @brief displays queried recipe
 * @param int $id representing the recipe id
 */
function recipe($id)
{
    require_once("view/recipe.php");
    require_once("model/recipes.php");

    // Fetch the recipe
    $recipe = getRecipe($id);
    // If it exists, add its relations
    if (!empty($recipe)) {
        // format time
        foreach ($recipe["time"] as $key => $time) {
            if ($time > strtotime("01:00:00")) {
                $recipe["time"][$key] = date("H", $time) . "h" . date("i", $time) . "m";
            } else {
                $recipe["time"][$key] = (1 * date("i", $time)) . "m";
            }
        }
        // fetch ingredients
        require_once("model/recipes_require_ingredients.php");
        $recipe["ingredients"] = getRecipeIngredients($id);
        // fetch images
        $recipe["images"] = getRecipeImages($id);
        // fetch steps
        $recipe["steps"] = getRecipeSteps($id);
        viewRecipe($recipe);
    } else {
        header("Location: /lost");
    }
}
