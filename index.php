<?php

// create/resume sessions
session_start();

// Requires
require_once "controller/static.php";

// Router
switch (strtok($_SERVER["REQUEST_URI"], '?')) {
    case '/':
    case '/home':
        home();
        break;
    default:
        lost();
}
