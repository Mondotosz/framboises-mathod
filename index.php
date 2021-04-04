<?php

// create/resume sessions
session_start();

// Global dependencies
require_once("lib/utils.php");

// Controllers
require_once("controller/static.php");
require_once("controller/authentication.php");

// Router
switch (strtok($_SERVER["REQUEST_URI"], '?')) {
    case '/':
    case '/home':
        home();
        break;
    case '/authentication/login':
        login($_POST);
        break;
    case '/authentication/register':
        register($_POST);
        break;
    case '/authentication/logout':
        logout();
        break;
    default:
        lost();
}
