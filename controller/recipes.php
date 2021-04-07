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

function recipeAdd($request, $files)
{
    // check permissions
    if (canManageRecipes()) {
        // check if user sent data
        if (!empty($request)) {
            // Check required fields for each insert
            // Recipe
            if (!empty($request["name"]) && !empty($request["portions"]) && !empty($request["time"]["preparation"]) && !empty($request["time"]["cooking"]) && !empty($request["time"]["rest"])) {
                try {

                    // Sanitize/Validate inputs
                    // Sanitize for xss and verify for empty after sanitization
                    $name = filter_var($request["name"], FILTER_SANITIZE_STRING);
                    if (empty($name)) throw new Exception("Name is a required field");
                    // Portions require float and not null
                    $portions = filter_var($request["portions"], FILTER_VALIDATE_FLOAT);
                    if ($portions === false) throw new Exception("Portions expects a float");
                    // Description only needs xss prevention
                    $description = filter_var($request["description"], FILTER_SANITIZE_STRING);

                    // translate input to time
                    $time = [];
                    foreach ($request["time"] as $key => $element) {
                        $time[$key] = strtotime($element, 0);
                        // strict comparison since 0 == false 
                        if (filter_var($time[$key], FILTER_VALIDATE_INT) === false) {
                            throw new Exception("Incorrect time format passed for $key");
                        }
                        $time[$key] = date("H:i:s", $time[$key]);
                    }

                    // Check unique constraints
                    require_once("model/recipes.php");
                    if (!empty(getRecipeByName($name))) throw new Exception("Recipe name already taken");
                    // store recipe
                    if (addRecipe($name, $description, $portions, $time["preparation"], $time["cooking"], $time["rest"])) {
                        // successfully added recipe
                    } else {
                        throw new Exception("Unable to save recipe");
                    }

                    // get id for redirect
                    $recipeID = getRecipeByName($name);

                    if (!empty($files["images"])) {
                        // save images
                        require_once("model/images.php");
                        $images = [];
                        for ($i = 0; $i < count($files["images"]["error"]); $i++) {
                            if (!$files["images"]["error"][$i]) {
                                $images[$i] = addImage($files["images"]["name"][$i], $files["images"]["tmp_name"][$i]);
                            }
                        }
                        print_r($images);
                    }

                    // TODO images and other
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                header("Location: /recipes/new?error=required");
            }
        } else {
            // display creation view
            require_once("view/recipeCreate.php");
            viewRecipeCreate();
        }
    } else {
        header("Location: /forbidden");
    }
}


function canManageRecipes()
{
    require_once("model/users_possesses_roles.php");
    $roles = getUserRoles($_SESSION["username"]);
    return in_array_r("administrator", $roles) | in_array_r("editor", $roles);
}
