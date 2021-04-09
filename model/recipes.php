<?php

/**
 * @brief gets every recipe from the database
 * @warning limits and anf offset must be >= 0
 * @param int $limit maximum amount of entries returned
 * @param int $offset entries to be skipped
 * @return array|null array of recipes | null on query fail
 */
function getRecipes($limit = null, $offset = null)
{
    require_once("model/dbConnector.php");
    $bindValue = [];
    if (isset($limit) && isset($offset)) {
        $query = "SELECT * FROM recipes LIMIT :offset , :limit";
        $bindValue = createBinds([[":offset", $offset, PDO::PARAM_INT], [":limit", $limit, PDO::PARAM_INT]]);
    } else if (isset($limit)) {
        $query = "SELECT * FROM recipes LIMIT :limit";
        $bindValue = createBinds([[":limit", $limit, PDO::PARAM_INT]]);
    } else {
        $query = "SELECT * FROM recipes";
    }

    $res = executeQuerySelect($query, $bindValue);
    return $res;
}

/**
 * @brief gets recipe with a given name
 * @param string $name recipe name
 * @return array|null array of recipe | null on query fail/no match
 */
function getRecipeByName($name)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM recipes WHERE name like :name";
    $res = executeQuerySelect($query, createBinds([[":name", $name]]));
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
    return $res;
}

/**
 * @brief get a list of recipes with a nested array of time containing timestamp
 * @param int $limit max amount of returned results
 * @param int $offset number of results to skip
 * @return array|null
 */
function getRecipeList($limit = null, $offset = null)
{
    require_once("model/dbConnector.php");
    $bindValue = [];
    $limitString = "";
    if (isset($limit) && isset($offset)) {
        $limitString = "LIMIT :offset , :limit";
        $bindValue = createBinds([[":offset", $offset, PDO::PARAM_INT], [":limit", $limit, PDO::PARAM_INT]]);
    } else if (isset($limit)) {
        $limitString = "LIMIT :limit";
        $bindValue = createBinds([[":limit", $limit, PDO::PARAM_INT]]);
    }

    // Fetch the recipes
    $query = "SELECT id, name, description, portions, preparation AS 'preparation', cooking AS 'cooking', rest AS 'rest' FROM recipes ORDER BY id ASC $limitString";

    $recipes = executeQuerySelect($query, $bindValue);

    if (!empty($recipes)) {
        foreach ($recipes as $key => $recipe) {
            // Translate sql time string to timestamp
            $recipes[$key]["time"] = [
                "preparation" => strtotime($recipe["preparation"], 0),
                "cooking" => strtotime($recipe["cooking"], 0),
                "rest" => strtotime($recipe["rest"], 0)
            ];
            // Calculate total time
            $recipes[$key]["time"]["total"] = $recipes[$key]["time"]["preparation"] + $recipes[$key]["time"]["cooking"] + $recipes[$key]["time"]["rest"];
            // Fetch the first image
            $imageQuery = "SELECT path FROM images WHERE recipes_id = :recipeID LIMIT 1";
            $tmp = executeQuerySelect($imageQuery, createBinds([[":recipeID", $recipes[$key]["id"], PDO::PARAM_INT]]));
            if (isset($tmp[0])) {
                $recipes[$key]["image"] = $tmp[0]["path"];
            }
        }
    }

    return $recipes;
}

/**
 * @brief get a recipe with a given id
 * @param int $id of the recipe
 * @return array|null recipe array|null on query failure
 */
function getRecipe($id)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM recipes WHERE id = :id";
    $res = executeQuerySelect($query, createBinds([[":id", $id, PDO::PARAM_INT]]));
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
        // format time
        $res["time"]["total"] = 0;
        foreach (["preparation", "cooking", "rest"] as $time) {
            $res["time"][$time] = strtotime($res[$time], 0);
            $res["time"]["total"] += $res["time"][$time];
        }
    }
    return $res;
}

/**
 * @brief get recipe associated images
 * @param int $id of the recipe
 * @return array|null image array|null on query failure
 */
function getRecipeImages($id)
{
    require_once("model/dbConnector.php");
    $query = "SELECT id, path FROM images WHERE recipes_id = :id";
    $res = executeQuerySelect($query, createBinds([[":id", $id, PDO::PARAM_INT]]));
    return $res;
}

/**
 * @brief get recipe associated steps
 * @param int $id of the recipe
 * @return array|null steps array|null on query failure
 */
function getRecipeSteps($id)
{
    require_once("model/dbConnector.php");
    $query = "SELECT id, number, instruction FROM steps WHERE recipes_id = :id ORDER BY number ASC";
    $res = executeQuerySelect($query, createBinds([[":id", $id, PDO::PARAM_INT]]));
    return $res;
}

/**
 * @brief count recipes in database
 * @return int number of entries
 */
function countRecipes()
{
    require_once("model/dbConnector.php");
    return countEntries('recipes');
}

/**
 * @brief links an image to a recipe
 * @param int $recipeID id of the recipe
 * @param int $imageID id of the image
 * @return bool|null success | null on query failure
 */
function addRecipeImage($recipeID, $imageID)
{
    require_once("model/dbConnector.php");
    $query = "UPDATE images SET recipes_id = :recipeID WHERE id = :imageID";

    $res = executeQueryIUD($query, createBinds([[":recipeID", $recipeID, PDO::PARAM_INT], [":imageID", $imageID, PDO::PARAM_INT]]));
    return $res;
}


/**
 * @brief adds a recipe to the database
 * @param string $name recipe name
 * @param string $description recipe description
 * @param float $portions portions
 * @param string $preparation preparation date("h:m:s",$time)
 * @param string $cooking cooking date("h:m:s",$time)
 * @param string $rest rest date("h:m:s",$time)
 * @return int|null inserted id | null on query failure
 */
function addRecipe($name, $description, $portions, $preparation, $cooking, $rest)
{
    // TODO transform time to string with format hhh:mm:ss
    require_once("model/dbConnector.php");
    $query =
        "INSERT INTO recipes (name, description, portions, preparation, cooking, rest) 
        VALUES (:name, :description, :portions, :preparation, :cooking, :rest)";

    $res = executeQueryInsert($query, createBinds([[":name", $name], [":description", $description], [":portions", $portions], [":preparation", $preparation], [":cooking", $cooking], [":rest", $rest]]));
    return $res;
}
