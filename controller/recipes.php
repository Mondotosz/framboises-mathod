<?php

// ANCHOR Entry points

/**
 * fetch a list of recipes and render a view with pagination
 * @param array $request with page and amount keys
 * @return void
 */
function recipeList($request)
{
    require_once("view/recipeList.php");
    require_once("model/recipes.php");
    require_once("view/assets/components/pagination.php");
    require_once("controller/permissions.php");

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
    viewRecipeList($recipes, $pagination, canEdit());
}

/**
 * displays queried recipe
 * @param int $id representing the recipe id
 * @return void
 */
function recipe($id)
{
    require_once("view/recipe.php");
    require_once("model/recipes.php");
    require_once("controller/permissions.php");

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
        viewRecipe($recipe, canEdit());
    } else {
        header("Location: /lost");
    }
}

/**
 * handles recipe creation with optional ingredients/steps/images
 * @param array $request expect $_POST
 * @param array $files expect $_FILES
 * @return void
 */
function recipeAdd($request,  $files)
{
    require_once("controller/permissions.php");
    // check permissions
    if (canEdit()) {
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
 * displays recipe edition or edit recipe
 * @param int $recipeID
 * @param array $request
 */
function recipeEdit($recipeID, $request)
{
    require_once("controller/permissions.php");
    if (canEdit()) {
        // check id
        if (filter_var($recipeID, FILTER_VALIDATE_INT) !== false) {
            if (empty($request)) {
                // view edit page
                require_once("model/recipes.php");
                // fetch recipe
                $recipe = getRecipe($recipeID);

                if (!empty($recipe)) {
                    require_once("model/recipes_require_ingredients.php");
                    require_once("view/recipeEdit.php");
                    // format time for input
                    foreach ($recipe["time"] as $key => $time) {
                        $recipe[$key] = date("H:i", $time);
                    }

                    // fetch images
                    $recipe["images"] = getRecipeImages($recipeID);

                    // fetch ingredients
                    $recipe["ingredients"] = getRecipeIngredients($recipeID);

                    // fetch steps
                    $recipe["steps"] = getRecipeSteps($recipeID);

                    viewRecipeEdit($recipe);
                } else {
                    echo "no recipe with this id";
                }
            } else {
                // process edition request
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

                    // update
                    require_once("model/recipes.php");
                    $rows = updateRecipe($recipeID, $name, $description, $portions, $time["preparation"], $time["cooking"], $time["rest"]);
                    if (!is_null($rows) && $rows > 0) {
                        header("Location: /recipes/$recipeID");
                    } else {
                        header("Location: /recipes/edit/$recipeID");
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        } else {
            echo "provided id isn't an int";
        }
    } else {
        header("Location: /forbidden");
    }
}

/**
 * add an ingredient to a recipe through request
 * @param int $recipeID
 * @param array $request expects $_POST
 * @return void
 */
function recipeAddIngredient($recipeID, $request)
{
    require_once("controller/permissions.php");
    if (canEdit()) {
        if (filter_var($recipeID, FILTER_VALIDATE_INT) !== false) {
            if (empty($request)) {
                //TODO view for adding an ingredient
            } else {
                try {
                    // check content
                    $amount = filter_var($request["amount"], FILTER_VALIDATE_FLOAT);
                    if ($amount === false) throw new Exception("amount must be a float");
                    $name = filter_var($request["name"], FILTER_SANITIZE_STRING);
                    if (empty($name)) throw new Exception("name cannot be empty");

                    // Check if it's already in the database
                    require_once("model/ingredients.php");
                    $tmp = getIngredientByName($name);
                    if (!empty($tmp)) {
                        $ingredientID = $tmp["id"];
                    } else {
                        // Store ingredient
                        $ingredientID = addIngredient($name);
                    }

                    if (isset($ingredientID)) {
                        require_once("model/recipes_require_ingredients.php");
                        if (recipeHasIngredient($recipeID, $ingredientID)) {
                            throw new Exception("ingredient already in recipe");
                        } else {
                            // create relation
                            associateRecipeIngredient($recipeID, $ingredientID, $amount);
                        }
                    } else {
                        throw new Exception("couldn't find or create ingredient");
                    }

                    if (@$request["handler"] == "ajax") {
                        echo json_encode(["success" => true, "message" => "successfully added ingredient to the recipe"]);
                    } else {
                        header("Location: " . $request["redirection"] ?? "/recipes/edit/$recipeID");
                    }
                } catch (Exception $e) {
                    if (@$request["handler"] == "ajax") {
                        echo json_encode(["success" => false, "message" => $e->getMessage()]);
                    } else {
                        echo $e->getMessage();
                    }
                }
            }
        } else {
            echo "id not an int";
        }
    } else {
        header("Location: /forbidden");
    }
}

/**
 * add a step to the recipe
 * @param int $recipeID id of the recipe
 * @param array $request expects $_POST
 */
function recipeAddStep($recipeID, $request)
{
    require_once("controller/permissions.php");
    if (canEdit()) {
        if (filter_var($recipeID, FILTER_VALIDATE_INT) !== false) {
            if (empty($request)) {
                //TODO
            } else {
                try {
                    addStepToRecipe($recipeID, $request["number"], $request["instruction"]);
                    if (@$request["handler"] == "ajax") {
                        echo json_encode(["success" => true, "message" => "successfully added step to the recipe"]);
                    } else {
                        header("Location: " . $request["redirection"] ?? "/recipes/edit/$recipeID");
                    }
                } catch (Exception $e) {
                    if (@$request["handler"] == "ajax") {
                        echo json_encode(["response" => "fail", "message" => $e->getMessage()]);
                    } else {
                        echo $e->getMessage();
                    }
                }
            }
        } else {
            echo "id is not an int";
        }
    } else {
        header("Location: /forbidden");
    }
}


/**
 * deletes a recipe
 * @param array $request expects $_POST
 * @return void
 */
function recipeDelete($request)
{
    require_once("controller/permissions.php");
    // checks for permissions
    if (canEdit()) {
        if (filter_var(@$request["id"], FILTER_VALIDATE_INT) !== false && filter_var(@$request["confirmation"], FILTER_VALIDATE_BOOL)) {
            // delete recipe
            require_once("model/recipes.php");
            $rows = deleteRecipe($request["id"]);

            // redirects based on result
            if (!is_null($rows) && $rows > 0) {
                header("Location: " . $request["redirection"] ?? "/");
            } else {
                header("Location: " . $request["origin"] ?? "/");
            }
        } else {
            echo "request doesn't have an id or confirmation";
        }
    } else {
        header("Location: /forbidden");
    }
}

function removeIngredientFromRecipe($recipeID, $request)
{
    require_once("controller/permissions.php");
    // check for permissions
    if (canEdit()) {
        if (filter_var($recipeID, FILTER_VALIDATE_INT) !== false && filter_var(@$request["ingredientID"], FILTER_VALIDATE_INT) !== false && filter_var(@$request["confirmation"], FILTER_VALIDATE_BOOL)) {
            // delete ingredient
            require_once("model/recipes_require_ingredients.php");
            $rows = dissociateRecipeIngredient($recipeID, $request["ingredientID"]);

            // response based on result
            if (!is_null($rows) && $rows > 0) {
                if ($request["handler"] == "ajax") {
                    echo json_encode(["success" => true, "id" => $request["ingredientID"]]);
                } else {
                    header("Location: " . $request["redirection"] ?? "/");
                }
            } else {
                if ($request["handler"] == "ajax") {
                    echo json_encode(["success" => false]);
                } else {
                    header("Location: " . $request["origin"] ?? "/");
                }
            }
        } else {
            echo "request doesn't have an id or confirmation";
        }
    } else {
        header("Location: /forbidden");
    }
}

function removeStepFromRecipe($recipeID, $request)
{
    require_once("controller/permissions.php");
    // check for permissions
    if (canEdit()) {
        if (filter_var($recipeID, FILTER_VALIDATE_INT) !== false && filter_var(@$request["stepID"], FILTER_VALIDATE_INT) !== false && filter_var(@$request["confirmation"], FILTER_VALIDATE_BOOL)) {
            // delete ingredient
            require_once("model/steps.php");
            $rows = deleteStep($request["stepID"]);

            // response based on result
            if (!is_null($rows) && $rows > 0) {
                if ($request["handler"] == "ajax") {
                    echo json_encode(["success" => true, "id" => $request["stepID"]]);
                } else {
                    header("Location: " . $request["redirection"] ?? "/");
                }
            } else {
                if ($request["handler"] == "ajax") {
                    echo json_encode(["success" => false]);
                } else {
                    header("Location: " . $request["origin"] ?? "/");
                }
            }
        } else {
            echo "request doesn't have an id or confirmation";
        }
    } else {
        header("Location: /forbidden");
    }
}

// ANCHOR Insert

/**
 * stores images in the database and links to a recipe if successful
 * @param int $recipeID
 * @param array array of files (expects reformattedFiles from utils.php)
 * @return void
 */
function addImagesToRecipe($recipeID,  $files)
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
 * stores an ingredient in the database and link it to a recipe if successful
 * @param int $recipeID
 * @param float $amount
 * @param string $name
 */
function addIngredientToRecipe($recipeID, $amount, $name)
{
    // check content
    $amount = filter_var($amount, FILTER_VALIDATE_FLOAT);
    if ($amount === false) throw new Exception("amount is not a float");
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    if (empty($name)) throw new Exception("empty name");

    // Check if it's already in the database
    $tmp = getIngredientByName($name);
    if (!empty($tmp)) {
        $ingredientID = $tmp["id"];
    } else {
        // Store ingredient
        $ingredientID = addIngredient($name);
    }

    $res = null;

    if (isset($ingredientID)) {
        // create relation
        require_once("model/recipes_require_ingredients.php");
        $res = associateRecipeIngredient($recipeID, $ingredientID, $amount);
    }

    return $res;
}

/**
 * stores ingredients in the database and associates them to a recipe if successful
 * @param int $recipeID id of the recipe in the database
 * @param array $ingredients list of ingredients
 * @return void
 */
function addIngredientsToRecipe($recipeID,  $ingredients)
{
    require_once("model/ingredients.php");
    require_once("model/recipes_require_ingredients.php");
    foreach ($ingredients as $ingredient) {
        try {
            addIngredientToRecipe($recipeID, $ingredient["amount"], $ingredient["name"]);
        } catch (Exception $e) {
            continue;
        }
    }
}

/**
 * stores a step in the database
 * @param int $recipeID
 * @param int $number
 * @param string $instruction
 * @throws Exception
 * @return int|null
 */
function addStepToRecipe($recipeID, $number, $instruction)
{
    // check content
    $number = filter_var($number, FILTER_VALIDATE_INT);
    if ($number === false) throw new Exception("step number is not an int");
    $instruction = filter_var($instruction, FILTER_SANITIZE_STRING);
    if (empty($instruction)) throw new Exception("empty instruction");

    // Store step
    require_once("model/steps.php");
    return addStep($number, $instruction, $recipeID);
}

/**
 * stores steps in the database and assign them to a recipe if successful
 * @param int $recipeID id of the recipe
 * @param array $steps steps
 */
function addStepsToRecipe($recipeID, $steps)
{
    require_once("model/steps.php");
    foreach ($steps as $step) {
        try {
            addStepToRecipe($recipeID, $step["number"], $step["instruction"]);
        } catch (Exception $e) {
            continue;
        }
    }
}

// ANCHOR update

function recipeUpdateIngredient($recipeID, $request)
{
    require_once("controller/permissions.php");
    if (canEdit()) {
        try {
            // Recipe ID
            $recipeID = filter_var($recipeID, FILTER_VALIDATE_INT);
            if ($recipeID === false) throw new Exception("recipe id is not an int");
            // Ingredient ID
            $ingredientID = filter_var($request["ingredientID"], FILTER_VALIDATE_INT);
            if ($ingredientID === false) throw new Exception("step id is not an int");

            $amount = filter_var($request["amount"], FILTER_VALIDATE_FLOAT);
            if ($amount === false) throw new Exception("amount must be a float");

            $name = filter_var($request["name"], FILTER_SANITIZE_STRING);
            if (empty($name)) throw new Exception("name cannot be empty");

            require_once("model/recipes_require_ingredients.php");
            $dbEntry = getRecipeIngredient($recipeID, $ingredientID);

            if (empty($dbEntry)) throw new Exception("no entry for this association");

            // only amount changed
            if ($dbEntry["amount"] != $amount && $dbEntry["name"] == $name) {
                updateAmount($recipeID, $ingredientID, $amount);
            } elseif ($dbEntry["name"] != $name) {
                // remove old association
                dissociateRecipeIngredient($recipeID, $ingredientID);
                // check if ingredient exist
                require_once("model/ingredients.php");
                $ingredient = getIngredientByName($name);

                if (empty($ingredient)) {
                    // create ingredient
                    $ingredientID = addIngredient($name);
                }

                // new association
                associateRecipeIngredient($recipeID, $ingredientID, $amount);
            }

            if ($request["handler"] == "ajax") {
                echo json_encode(["success" => true]);
            } else {
                header("Location: " . $request["redirection"] ?? "/");
            }
        } catch (Exception $e) {
            if (@$request["handler"] == "ajax") {
                echo json_encode(["success" => false, "message" => $e->getMessage()]);
            } else {
                echo $e->getMessage();
            }
        }
    } else {
        header("Location: /forbidden");
    }
}

function recipeUpdateStep($recipeID, $request)
{
    require_once("controller/permissions.php");
    if (canEdit()) {
        try {
            // Recipe ID
            $recipeID = filter_var($recipeID, FILTER_VALIDATE_INT);
            if ($recipeID === false) throw new Exception("recipe id is not an int");
            // Step ID
            $stepID = filter_var($request["stepID"], FILTER_VALIDATE_INT);
            if ($stepID === false) throw new Exception("step id is not an int");
            // get step
            require_once("model/steps.php");
            $step = getStep($stepID);
            if (empty($step)) throw new Exception("no such step in database");

            // verify number and instruction
            $number = filter_var($request["number"], FILTER_VALIDATE_INT);
            if ($number === false) throw new Exception("number expects an int");

            $instruction = filter_var($request["instruction"], FILTER_SANITIZE_STRING);
            if (empty($instruction)) throw new Exception("instruction cannot be empty");

            // update entry
            if ($step["number"] != $number || $step["instruction"] != $instruction) {
                setStep($stepID, $number, $instruction);
            }

            if ($request["handler"] == "ajax") {
                echo json_encode(["success" => true]);
            } else {
                header("Location: " . $request["redirection"] ?? "/");
            }
        } catch (Exception $e) {
            if (@$request["handler"] == "ajax") {
                echo json_encode(["success" => false, "message" => $e->getMessage()]);
            } else {
                echo $e->getMessage();
            }
        }
    } else {
        header("Location: /forbidden");
    }
}

// ANCHOR Delete

// ANCHOR Helpers

/**
 * transforms timestamp to readable time like 36h25m
 * @param int $time timestamp
 * @return string|null formatted time | null when timestamp is < 0
 */
function readableTime($time)
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
