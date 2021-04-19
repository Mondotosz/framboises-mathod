<?php

function openingsCalendar()
{
    require_once("view/openingsCalendar.php");
    require_once("controller/permissions.php");
    require_once("model/openings.php");
    $calendar["now"] = time();
    $calendar["start"] = strtotime("-3days", $calendar["now"]);
    $calendar["end"] = strtotime("+3days", $calendar["now"]);
    $calendar["length"] = 7;
    $calendar["openings"] = selectOpeningsInRange($calendar["start"], $calendar["end"]);
    viewOpeningsCalendar($calendar, canEdit());
}

/**
 * Create a new opening
 * @param array $request expects $_POST
 * @return void
 */
function openingNew($request)
{
    require_once("controller/permissions.php");
    if (canEdit()) {
        if (empty($request)) {
            require_once("view/openingCreate.php");
            viewOpeningCreate();
        } else {
            try {
                // Check required input
                if (empty($request["start"])) throw new Exception("No start datetime given");
                if (empty($request["end"])) throw new Exception("No end datetime given");

                // Translate to timestamp
                $start = strtotime($request["start"]);
                $end = strtotime($request["end"]);

                // Validate timestamps
                if (filter_var($start, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false) throw new Exception("Invalid timestamp for start");
                if (filter_var($end, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false) throw new Exception("Invalide timestamp for end");

                // Check if the end is after the start
                if ($end <= $start) throw new Exception("End time cannot be lower than start time");

                $description = filter_var($request["description"], FILTER_SANITIZE_STRING);
                if (empty($description)) {
                    $description = null;
                }

                // Validate places
                $places = filter_var($request["places"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 255]]);
                if ($places === false) {
                    $places = null;
                }

                // Store entry
                require_once("model/openings.php");
                $row = insertOpening($start, $end, $description, $places);

                if (isset($row)) {
                    header("Location: /openings");
                } else {
                    header("Location: /openings/new");
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    } else {
        header("Location: /forbidden");
    }
}
