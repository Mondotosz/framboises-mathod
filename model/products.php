<?php

// ANCHOR SELECT

/**
 * get a list of products with a nested array of time containing timestamp
 * @param int $limit max amount of returned results
 * @param int $offset number of results to skip
 * @return array|null
 */
function getProductList($limit = null, $offset = null)
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

    // Fetch the products
    $query = "SELECT id, name, price, unit, description FROM products ORDER BY id ASC $limitString";

    $products = executeQuerySelect($query, $bindValue);

    return $products;
}

/**
 * get recipe associated images
 * @param int $id of the recipe
 * @return array|null image array|null on query failure
 */
function getProductImages($id)
{
    require_once("model/dbConnector.php");
    $query = "SELECT id, path FROM images WHERE products_id = :id";
    return executeQuerySelect($query, createBinds([[":id", $id, PDO::PARAM_INT]]));
}

// ANCHOR INSERT

// ANCHOR UPDATE

// ANCHOR DELETE

// ANCHOR HELPERS

/**
 * count products in database
 * @return int number of entries
 */
function countProducts()
{
    require_once("model/dbConnector.php");
    return countEntries('products');
}
