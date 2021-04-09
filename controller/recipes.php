<?php

/**
 * @brief fetch a list of recipes and render a view with pagination
 * @param array $request with page and amount keys
 * @return void
 */
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

    $recipes = getRecipeList($amount, $page * $amount);
    foreach ($recipes as $key => $recipe) {
        foreach ($recipe["time"] as $timeKey => $time) {
            $recipes[$key]["time"][$timeKey] = readableTime($time);
        }
    }
    viewRecipeList($recipes, $pagination, canManageRecipes());
}

/**
 * @brief displays queried recipe
 * @param int $id representing the recipe id
 * @return void
 */
function recipe(int $id)
{
    require_once("view/recipe.php");
    require_once("model/recipes.php");

    // Fetch the recipe
    $recipe = getRecipe($id);
    // If it exists, add its relations
    if (!empty($recipe)) {
        // format time
        foreach ($recipe["time"] as $key => $time) {
            $recipe["time"][$key] = readableTime($time);
        }
        // fetch ingredients
        require_once("model/recipes_require_ingredients.php");
        $recipe["ingredients"] = getRecipeIngredients($id);
        // fetch images
        $recipe["images"] = getRecipeImages($id);
        // fetch steps
        $recipe["steps"] = getRecipeSteps($id);
        viewRecipe($recipe, canManageRecipes());
    } else {
        header("Location: /lost");
    }
}

/**
 * @brief handles recipe creation with optional ingredients/steps/images
 * @param array $request expect $_POST
 * @param array $files expect $_FILES
 * @return void
 */
function recipeAdd(array $request, array $files)
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
                    $recipeID = addRecipe($name, $description, $portions, $time["preparation"], $time["cooking"], $time["rest"]);
                    // Check if saving was successful
                    if ($recipeID === null) throw new Exception("Unable to save recipe");

                    // Images
                    if (!empty($files["images"])) {
                        // save images
                        require_once("lib/utils.php");
                        addImagesToRecipe($recipeID, reformatFiles($files["images"]));
                    }

                    // Ingredients
                    if (isset($request["ingredients"])) {
                        addIngredientsToRecipe($recipeID, $request["ingredients"]);
                    }

                    // Steps
                    if (isset($request["steps"])) {
                        addStepsToRecipe($recipeID, $request["steps"]);
                    }


                    header("Location: /recipes/$recipeID");
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


/**
 * @brief checks if the user has the rights to manage recipes
 * @return bool
 */
function canManageRecipes()
{
    require_once("model/users_possesses_roles.php");
    $roles = getUserRoles($_SESSION["username"]);
    return in_array_r("administrator", $roles) | in_array_r("editor", $roles);
}

/**
 * @brief stores images in the database and links to a recipe if successful
 * @param int $recipeID
 * @param array array of files (expects reformattedFiles from utils.php)
 * @return void
 */
function addImagesToRecipe(int $recipeID, array $files)
{
    // save images
    require_once("model/images.php");
    $images = [];
    // store image in upload and database
    foreach ($files as $file) {
        if (!$file["error"]) {
            array_push($images, addImage($file["name"], $file["tmp_name"]));
        }
    }

    // Check for returned id
    foreach ($images as $image) {
        if (isset($image)) {
            // Link image to recipe
            addRecipeImage($recipeID, $image);
        }
    }
}

/**
 * @brief stores ingredients in the database and associates them to a recipe if successful
 * @param int $recipeID id of the recipe in the database
 * @param array $ingredients list of ingredients
 * @return void
 */
function addIngredientsToRecipe(int $recipeID, array $ingredients)
{
    require_once("model/ingredients.php");
    require_once("model/recipes_require_ingredients.php");
    foreach ($ingredients as $ingredient) {
        // check content
        $amount = filter_var($ingredient["amount"], FILTER_VALIDATE_FLOAT);
        if ($amount === false) continue;
        $name = filter_var($ingredient["name"], FILTER_SANITIZE_STRING);
        if (empty($name)) continue;

        // Check if it's already in the database
        $tmp = getIngredientByName($name);
        if (!empty($tmp)) {
            $ingredientID = $tmp["id"];
        } else {
            // Store ingredient
            $ingredientID = addIngredient($name);
        }

        if (isset($ingredientID)) {
            // create relation
            associateRecipeIngredient($recipeID, $ingredientID, $amount);
        }
    }
}

/**
 * @brief stores steps in the database and assign them to a recipe if successful
 * @param int $recipeID id of the recipe
 * @param array $steps steps
 */
function addStepsToRecipe(int $recipeID, array $steps)
{
    require_once("model/steps.php");
    foreach ($steps as $step) {
        // check content
        $number = filter_var($step["number"], FILTER_VALIDATE_INT);
        if ($number === false) continue;
        $instruction = filter_var($step["instruction"], FILTER_SANITIZE_STRING);
        if (empty($instruction)) continue;

        // Store step
        addStep($number, $instruction, $recipeID);
    }
}

/**
 * @brief transforms timestamp to readable time like 36h25m
 * @param int $time timestamp
 * @return string|null formatted time | null when timestamp is < 0
 */
function readableTime(int $time)
{
    switch (true) {
        case $time >= strtotime("1:00:00", 0):
            $tmp = floor($time / 3600) . "h" . date("i", $time) . "m";
            break;
        case $time >= 0:
            $tmp = date("i", $time) . "m";
            break;
        default:
            $tmp = null;
    }

    return $tmp;
}
