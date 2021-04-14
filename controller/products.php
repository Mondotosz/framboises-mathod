<?php

/**
 * displays a list of varieties
 * @param array $request expects $_GET
 * @return void
 */
function varietyList($request)
{
    require_once("controller/permissions.php");
    require_once("model/products.php");
    require_once("view/assets/components/pagination.php");
    require_once("view/varietyList.php");

    // Filters/default page
    $page = filter_var($request["page"] ?? 0, FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
    // Filters/default amount of roles per page
    $amount = filter_var($request["amount"] ?? 0, FILTER_VALIDATE_INT, ["options" => ["default" => 5, "min_range" => 1]]);

    $rowCount = countProducts();

    // Generate pagination
    $pagination = componentPagination(ceil($rowCount / $amount), $page + 1, $amount, "/varieties");

    $products = getProductList($amount, $page * $amount);
    foreach ($products as $key => $product) {
        $products[$key]["images"] = getProductImages($product["id"]);
    }

    viewVarietyList($products, $pagination, canEdit());
}

/**
 * displays product
 * @param int $id
 * @return void
 */
function variety($id)
{
    require_once("view/variety.php");
    require_once("model/products.php");
    require_once("controller/permissions.php");

    // Fetch product
    $product = selectProduct($id);
    if (!empty($product)) {
        $product["images"] = getProductImages($id);
        viewProduct($product, canEdit());
    } else {
        header("Location: /lost");
    }
}

/**
 * add a variety
 * @param array $request expects $_POST
 * @param array $files expect $_FILES
 * @return void
 */
function varietyAdd($request, $files)
{
    require_once("controller/permissions.php");
    if (canEdit()) {
        if (empty($request)) {
            // show add variety view
            require_once("view/varietyCreate.php");
            viewVarietyCreate();
        } else {
            require_once("model/products.php");
            // process request
            // Sanitize/validate
            $name = filter_var($request["name"], FILTER_SANITIZE_STRING);
            if (empty($name)) throw new Exception("empty name given");

            $description = filter_var($request["description"], FILTER_SANITIZE_STRING);
            if (empty($description)) throw new Exception("empty description given");

            $price = filter_var($request["price"], FILTER_VALIDATE_FLOAT);
            if ($price === false) throw new Exception("price requires a float value");

            $unit = filter_var($request["unit"], FILTER_SANITIZE_STRING);
            if (empty($unit)) throw new Exception("empty unit given");

            // Check unique constraints
            if (!empty(selectProductName($name))) throw new Exception("a product with this name already exists");

            // Add product
            $productID = insertProduct($name, $description, $price, $unit);
            if ($productID === null) throw new Exception("unable to save product");

            // check for images
            if (!empty($files["images"])) {
                // save images
                require_once("lib/utils.php");
                addImageToProduct($productID, reformatFiles($files["images"]));
            }

            header("Location: /varieties/$productID");

            try {
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    } else {
        header("Location: /forbidden");
    }
}


function addImageToProduct($productID, $files)
{
    // save images
    require_once("model/images.php");
    require_once("model/products.php");
    $images = [];
    // store image in upload and database
    foreach ($files as $file) {
        if (!$file["error"]) {
            array_push($images, addImage($file["name"], $file["tmp_name"]));
        }
    }

    // Check for returned id
    foreach ($images as $imageID) {
        if (isset($imageID)) {
            // Link image to recipe
            linkProductImage($productID, $imageID);
        }
    }
}
