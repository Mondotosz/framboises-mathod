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
    if (isset($limit) && isset($offset)) {
        $query = "SELECT * FROM recipes LIMIT $offset, $limit";
    } else if (isset($limit)) {
        $query = "SELECT * FROM recipes LIMIT $limit";
    } else {
        $query = "SELECT * FROM recipes";
    }

    $res = executeQuerySelect($query);
    return $res;
}

/**
 * @brief gets recipe with a given name
 * @return array|null array of recipe | null on query fail/no match
 */
function getRecipesByName($name)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM recipes WHERE name like '$name'";
    $res = executeQuerySelect($query);
    // only return the first match
    if (empty($res[0])) {
        $res = null;
    } else {
        $res = $res[0];
    }
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
 * @brief adds a recipe to the database
 * @return bool|null success | null on query failure
 */
function addRecipe($name, $description, $portions, $preparation, $cooking, $rest)
{
    // TODO transform time to string with format hhh:mm:ss
    require_once("model/dbConnector.php");
    $query =
        "INSERT INTO recipes (name, description, portions, preparation, cooking, rest) 
        VALUES ('$name', '$description', $portions, '$preparation', '$cooking', '$rest')";

    $res = executeQueryIUD($query);
    return $res;
}
