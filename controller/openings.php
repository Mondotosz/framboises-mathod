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
