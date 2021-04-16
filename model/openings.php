<?php

// ANCHOR SELECT

/**
 * select every opening
 * @return array|null
 */
function selectOpeningsAll()
{
    require_once("model/dbConnector.php");
    $query = 'SELECT * FROM openings ORDER BY start DESC;';
    return executeQuerySelect($query);
}

/**
 * select upcoming openings
 * @param int $timestamp unix timestamp representing the current timestamp
 * @return array|null
 */
function selectOpeningsUpcoming($timestamp = null)
{
    require_once("model/dbConnector.php");
    $timestamp = $timestamp ?? time();
    $query = 'SELECT * FROM openings WHERE end >= :timestamp ORDER BY start ASC;';
    return executeQuerySelect($query, createBinds([[":timestamp", $timestamp, PDO::PARAM_INT]]));
}

/**
 * select openings in range
 * @param int $start
 * @param int $end
 * @return array|null
 */
function selectOpeningsInRange($start, $end)
{
    require_once("model/dbConnector.php");
    $start = date("Y-m-d H:i:s", $start);
    $end = date("Y-m-d H:i:s", $end);
    $query = 'SELECT * FROM openings WHERE end > :start OR start < :end';
    return executeQuerySelect($query, createBinds([[":start", $start], [":end", $end]]));
}

// ANCHOR INSERT

/**
 * add an opening
 * @param int $start
 * @param int $end
 * @param string $description
 * @param int $places
 * @return int|null insert id|null on query failure
 */
function insertOpening($start, $end, $description = null, $places = null)
{
    require_once("model/dbConnector.php");
    $start = date("Y-m-d H:i:s", $start);
    $end = date("Y-m-d H:i:s", $end);
    $query = 'INSERT INTO openings (start, end, description, places) VALUES (:start, :end, :description, :places);';
    return executeQueryInsert($query, createBinds([[":start", $start], [":end", $end], [":description", $description], [":places", $places, PDO::PARAM_INT]]));
}
