<?php

/**
 * @brief displays the requested administration dashboard view
 * @param string dashboard panel name
 * @return void
 */
function dashboard($panel = null, $request = null)
{
    // Verify authorizations
    if (isAdmin()) {
        require_once("view/assets/components/pagination.php");

        // Dashboard routing, loads panel components and forward the to the view
        switch ($panel) {
            case 'overview':
                require_once("view/assets/components/administration/dashboard/overview.php");
                require_once("model/users.php");
                require_once("model/roles.php");
                $stats = ["users" => countUsers(), "roles" => countRoles()];
                $component = componentOverview($stats);
                break;
            case 'users':
            case 'roles':
            case 'recipes':
                $component = table($panel, @$request["page"], @$request["amount"]);
                break;
            default:
                $component = null;
        }

        // Render view
        require_once("view/administrationDashboard.php");
        viewAdministrationDashboard($component, $panel);
    } else {
        header("Location: /forbidden");
    }
}

/**
 * @brief checks if the user is an administrator in the database
 * @return bool
 */
function isAdmin()
{
    require_once("model/users_possesses_roles.php");
    return hasRole($_SESSION["username"], "administrator");
}

function table($table, $page, $amount)
{
    require_once("view/assets/components/table.php");

    // Filters/default page
    $page = filter_var($page, FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
    // Filters/default amount of roles per page
    $amount = filter_var($amount, FILTER_VALIDATE_INT, ["options" => ["default" => 10, "min_range" => 1]]);

    $unknown = false;
    switch ($table) {
        case "users":
            require_once("model/users.php");
            // Get users with limits
            $rows = getUsers($amount, $page * $amount);
            $rowCount = countUsers();
            $header = ["id" => "ID", "username" => "Nom d'utilisateur", "email" => "Email", "creation_date" => "Date de création"];
            break;
        case "roles":
            require_once("model/roles.php");
            // Get roles with limits
            $rows = getRoles($amount, $page * $amount);
            $rowCount = countRoles();
            $header = ["id" => "ID", "name" => "Nom"];
            break;
        case "recipes":
            require_once("model/recipes.php");
            // Get recipes with limits
            $rows = getRecipes($amount, $page * $amount);
            $rowCount = countRecipes();
            $header = ["id" => "ID", "name" => "Nom", "description" => "Déscription"];
            break;
        default:
            $unknown = true;
    }

    if ($unknown) {
        $component = $null;
    } else {
        // Generate pagination
        $pagination = componentPagination(ceil($rowCount / $amount), $page + 1, $amount, "/administration/dashboard/$table");
        $paginationStatus = componentPaginationStatus($amount, $page * $amount, $rowCount);
        // Generate component
        $component = componentTable($header, $rows, $pagination, $paginationStatus);
    }

    return $component;
}
