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
    foreach($products as $key=> $product){
        $products[$key]["images"] = getProductImages($product["id"]);
    }

    viewVarietyList($products, $pagination, canEdit());
}
