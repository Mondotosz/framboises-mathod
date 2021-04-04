<?php

// create/resume sessions
session_start();

// Global dependencies
require_once("lib/utils.php");

// Controllers
require_once("controller/static.php");
require_once("controller/authentication.php");
require_once("controller/administration.php");

// Router
// Remove get parameters
$uri = strtok($_SERVER["REQUEST_URI"], '?');
// Remove ending /
$uri = (strlen($uri) > 1) ? preg_replace("/\/$/", '', $uri) : $uri;

switch ($uri) {
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
    case '/administration/dashboard':
    case '/administration/dashboard/overview':
        dashboard('overview');
        break;
    case '/administration/dashboard/users':
        dashboard('users');
        break;
    case '/administration/dashboard/roles':
        dashboard('roles');
        break;
    case '/administration/dashboard/openings':
        dashboard('openings');
        break;
    case '/administration/dashboard/images':
        dashboard('images');
        break;
    case '/administration/dashboard/recipes':
        dashboard('recipes');
        break;
    case '/forbidden':
        forbidden();
        break;
    default:
        lost();
}
