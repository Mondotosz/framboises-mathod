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
                $component = usersPanel(@$request["page"], @$request["amount"]);
                break;
            case 'roles':
                $component = rolesPanel(@$request["page"], @$request["amount"]);
                break;
            case 'recipes':
                require_once("model/recipes.php");
                require_once("view/assets/components/administration/dashboard/recipes.php");
                // Filters/default page
                $page = filter_var(@$request["page"], FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
                // Filters/default amount of users per page
                $amount = filter_var(@$request["amount"], FILTER_VALIDATE_INT, ["options" => ["default" => 10, "min_range" => 1]]);
                // Get recipes with limits
                $recipes = getRecipes($amount, $page * $amount);
                $recipeCount = countRecipes();
                // Generate pagination
                $pagination = componentPagination(ceil($recipeCount / $amount), $page + 1, $amount, "/administration/dashboard/roles");
                $paginationStatus = componentPaginationStatus($amount, $page * $amount, $recipeCount);
                // Generate component
                $component = componentRecipes($recipes, $pagination, $paginationStatus);
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

function usersPanel($page, $amount)
{
    require_once("model/users.php");
    require_once("view/assets/components/administration/dashboard/users.php");
    // Filters/default page
    $page = filter_var($page, FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
    // Filters/default amount of users per page
    $amount = filter_var($amount, FILTER_VALIDATE_INT, ["options" => ["default" => 10, "min_range" => 1]]);
    // Get users with limits
    $users = getUsers($amount, $page * $amount);
    $userCount = countUsers();
    // Generate pagination
    $pagination = componentPagination(ceil($userCount / $amount), $page + 1, $amount, "/administration/dashboard/users");
    $paginationStatus = componentPaginationStatus($amount, $page * $amount, $userCount);
    // Generate component
    return componentUsers($users, $pagination, $paginationStatus);
}
function rolesPanel($page, $amount)
{
    require_once("model/roles.php");
    require_once("view/assets/components/administration/dashboard/roles.php");
    // Filters/default page
    $page = filter_var($page, FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) - 1;
    // Filters/default amount of roles per page
    $amount = filter_var($amount, FILTER_VALIDATE_INT, ["options" => ["default" => 10, "min_range" => 1]]);
    // Get roles with limits
    $roles = getRoles($amount, $page * $amount);
    $roleCount = countRoles();
    // Generate pagination
    $pagination = componentPagination(ceil($roleCount / $amount), $page + 1, $amount, "/administration/dashboard/roles");
    $paginationStatus = componentPaginationStatus($amount, $page * $amount, $roleCount);
    // Generate component
    return componentRoles($roles, $pagination, $paginationStatus);
}
