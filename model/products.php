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
 * Select a product by its name
 * @param string $name
 * @return array|null
 */
function selectProductName($name)
{
    require_once("model/dbConnector.php");
    $query = 'SELECT * FROM products WHERE name LIKE :name LIMIT 1';
    return executeQuerySelect($query, createBinds([[":name", $name]]))[0] ?? null;
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

/**
 * Insert a product in the database
 * @param string $name
 * @param string $description
 * @param float $price
 * @param string $unit
 * @return int|null
 */
function insertProduct($name, $description, $price, $unit)
{
    require_once("model/dbConnector.php");
    $query = 'INSERT INTO products (name, description, price, unit) VALUES (:name, :description, :price, :unit);';
    return executeQueryInsert($query, createBinds([[":name", $name], [":description", $description], [":price", $price], [":unit", $unit]]));
}

/**
 * links a an image to a product
 * @param int $productID
 * @param int $imageID
 * @return int|null
 */
function linkProductImage($productID, $imageID)
{
    require_once("model/dbConnector.php");
    $query = "UPDATE images SET products_id = :productID WHERE id = :imageID";
    return executeQueryInsert($query, createBinds([[":productID", $productID, PDO::PARAM_INT], [":imageID", $imageID, PDO::PARAM_INT]]));
}

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
