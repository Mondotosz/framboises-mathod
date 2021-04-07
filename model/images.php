<?php

/**
 * @brief gets every image from the database
 * @warning limits and anf offset must be >= 0
 * @param int $limit maximum amount of entries returned
 * @param int $offset entries to be skipped
 * @return array|null array of images | null on query fail
 */
function getImages($limit = null, $offset = null)
{
    require_once("model/dbConnector.php");
    $bindValue = [];
    if (isset($limit) && isset($offset)) {
        $query = "SELECT * FROM images LIMIT :offset, :limit";
        $bindValue = createBinds([[":offset", $offset, PDO::PARAM_INT], [":limit", $limit, PDO::PARAM_INT]]);
    } else if (isset($limit)) {
        $query = "SELECT * FROM images LIMIT :limit";
        $bindValue = createBinds([[":limit", $limit, PDO::PARAM_INT]]);
    } else {
        $query = "SELECT * FROM images";
    }

    $res = executeQuerySelect($query, $bindValue);
    return $res;
}

/**
 * @brief gets image with a given id
 * @param int image id
 * @return array|null array of image (empty if no matches) | null on query fail
 */
function getImage($id)
{
    require_once("model/dbConnector.php");
    $query = "SELECT * FROM images WHERE id = :id";

    $res = executeQuerySelect($query, createBinds([[":id", $id, PDO::PARAM_INT]]));
    return $res;
}

/**
 * @brief adds an image to the database
 * @return int|null
 */
function addImage($fileName, $tempName)
{
    // Check file extension validity
    if (!preg_match("/.*(\.(?:jpeg)|(?:jpg)|(?:png)|(?:gif)|(?:svg))$/", $fileName, $extension)) {
        throw new Exception("Invalid filename filename => $fileName");
    }

    // Generate an unique filename
    do {
        $uniqueId = uniqId();
    } while (file_exists($_SERVER["DOCUMENT_ROOT"] . "/public/upload/img/$uniqueId" . $extension[1]));

    // Move image in upload
    move_uploaded_file($tempName, $_SERVER["DOCUMENT_ROOT"] . "/public/upload/img/$uniqueId" . $extension[1]);

    // Add entry to the database
    require_once("model/dbConnector.php");
    $query = "INSERT INTO images (path) VALUES (:path)";

    $res = executeQueryInsert($query, createBinds([[":path", $_SERVER["DOCUMENT_ROOT"] . "/public/upload/img/$uniqueId" . $extension[1]]]));
    return $res;
}
