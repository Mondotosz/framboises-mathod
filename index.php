<?php

// create/resume sessions
session_start();

// Global dependencies
require_once("lib/utils.php");

// Controllers
require_once("controller/static.php");
require_once("controller/authentication.php");
require_once("controller/administration.php");
require_once("controller/recipes.php");

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
    case '/recipes':
        recipeList($_GET);
        break;
    case preg_match("/^\/recipes\/(\d+)\/?$/", $uri, $res) ? $uri : null:
        recipe($res[1]);
        break;
    case '/recipes/new':
        recipeAdd($_POST, $_FILES);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)$/", $uri, $res) ? $uri : null:
        recipeEdit($res[1],$_POST);
        break;
    case '/recipes/delete':
        recipeDelete($_POST);
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
        dashboard('users', $_GET);
        break;
    case '/administration/dashboard/roles':
        dashboard('roles', $_GET);
        break;
    case '/administration/dashboard/openings':
        dashboard('openings');
        break;
    case '/administration/dashboard/images':
        dashboard('images');
        break;
    case '/administration/dashboard/recipes':
        dashboard('recipes', $_GET);
        break;
    case '/forbidden':
        forbidden();
        break;
    default:
        lost();
}
