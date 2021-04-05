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
                require_once("view/assets/components/administrationDashboard/overview.php");
                require_once("model/users.php");
                require_once("model/roles.php");
                $stats = ["users" => countUsers(), "roles" => countRoles()];
                $component = componentOverview($stats);
                break;
            case 'users':
                require_once("model/users.php");
                require_once("view/assets/components/administrationDashboard/users.php");
                // Filters/default page
                $page = filter_var(@$request["page"], FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
                // Filters/default amount of users per page
                $amount = filter_var(@$request["amount"], FILTER_VALIDATE_INT, ["options" => ["default" => 20, "min_range" => 1]]);
                // Get users with limits
                $users = getUsers($amount, $page * $amount);
                // Generate pagination
                $pagination = componentPagination(ceil(countUsers() / $amount), $page + 1, $amount, "/administration/dashboard/users");
                // Generate component
                $component = componentUsers($users, $pagination);
                break;
            case 'roles':
                require_once("model/roles.php");
                require_once("view/assets/components/administrationDashboard/roles.php");
                // Filters/default page
                $page = filter_var(@$request["page"], FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
                // Filters/default amount of users per page
                $amount = filter_var(@$request["amount"], FILTER_VALIDATE_INT, ["options" => ["default" => 20, "min_range" => 1]]);
                // Get roles with limits
                $roles = getRoles($amount, $page * $amount);
                // Generate component
                $component = componentRoles($roles);
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
