<?php

// create/resume sessions
session_start();

// Global dependencies
require_once("lib/utils.php");
setlocale(LC_ALL, 'fr-CH');
date_default_timezone_set("Europe/Zurich");

// Controllers
require_once("controller/static.php");
require_once("controller/authentication.php");
require_once("controller/administration.php");
require_once("controller/recipes.php");
require_once("controller/products.php");
require_once("controller/permissions.php");
require_once("controller/openings.php");

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
    case '/location':
        location();
        break;
    case '/openings':
        openingsCalendar();
        break;
    case '/varieties':
        varietyList($_GET);
        break;
    case '/recipes':
        recipeList($_GET);
        break;
    case '/varieties/new':
        varietyAdd($_POST, $_FILES);
        break;
    case '/recipes/new':
        recipeAdd($_POST, $_FILES);
        break;
    case preg_match("/^\/recipes\/(\d+)\/?$/", $uri, $res) ? $uri : null:
        recipe($res[1]);
        break;
    case preg_match("/^\/varieties\/(\d+)\/?$/", $uri, $res) ? $uri : null:
        variety($res[1]);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)$/", $uri, $res) ? $uri : null:
        recipeEdit($res[1], $_POST);
        break;
    case preg_match("/^\/varieties\/edit\/(\d+)$/", $uri, $res) ? $uri : null:
        varietyEdit($res[1], $_POST);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)\/add\/ingredient$/", $uri, $res) ? $uri : null:
        recipeAddIngredient($res[1], $_POST);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)\/add\/step$/", $uri, $res) ? $uri : null:
        recipeAddStep($res[1], $_POST);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)\/update\/ingredient$/", $uri, $res) ? $uri : null:
        recipeUpdateIngredient($res[1], $_POST);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)\/update\/step$/", $uri, $res) ? $uri : null:
        recipeUpdateStep($res[1], $_POST);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)\/delete\/ingredient$/", $uri, $res) ? $uri : null:
        removeIngredientFromRecipe($res[1], $_POST);
        break;
    case preg_match("/^\/recipes\/edit\/(\d+)\/delete\/step$/", $uri, $res) ? $uri : null:
        removeStepFromRecipe($res[1], $_POST);
        break;
    case '/recipes/delete':
        recipeDelete($_POST);
        break;
    case '/varieties/delete':
        productDelete($_POST);
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
