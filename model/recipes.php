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
 * @return array|null array of recipe | null on query fail/no match
 */
function getRecipesByName($name)
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

    $query =
        "SELECT recipes.id, recipes.name, recipes.portions, recipes.preparation, recipes.cooking, recipes.rest, recipes.description, images.path AS 'image' FROM recipes
	    LEFT JOIN images ON images.recipes_id = recipes.id
        ORDER BY recipes.id, images.id ASC $limitString;";

    $res = executeQuerySelect($query, $bindValue);

    // merge images
    $list = [];
    foreach ($res as $entry) {
        if (empty($list[$entry["id"]])) {
            $list[$entry["id"]] = [
                "id" => $entry["id"],
                "name" => $entry["name"],
                "description" => $entry["description"],
                "portions" => $entry["portions"],
                "time" => [
                    "preparation" => strtotime($entry["preparation"],0),
                    "cooking" => strtotime($entry["cooking"],0),
                    "rest" => strtotime($entry["rest"],0),
                ],
                "images" => empty($entry["image"]) ? [] : [$entry["image"]]
            ];
            $list[$entry["id"]]["time"]["total"] = $list[$entry["id"]]["time"]["preparation"] + $list[$entry["id"]]["time"]["cooking"] + $list[$entry["id"]]["time"]["rest"];
        } else {
            if (!empty($entry["image"])) {
                array_push($list[$entry["id"]]["images"], $entry["image"]);
            }
        }
    }

    return $list;
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
 * @brief adds a recipe to the database
 * @return bool|null success | null on query failure
 */
function addRecipe($name, $description, $portions, $preparation, $cooking, $rest)
{
    // TODO transform time to string with format hhh:mm:ss
    require_once("model/dbConnector.php");
    $query =
        "INSERT INTO recipes (name, description, portions, preparation, cooking, rest) 
        VALUES (:name, :description, :portions, :preparation, :cooking, :rest)";

    $res = executeQueryIUD($query, createBinds([[":name", $name], [":description", $description], [":portions", $portions, PDO::PARAM_INT], [":preparation", $preparation], [":cooking", $cooking], [":rest", $rest]]));
    return $res;
}
