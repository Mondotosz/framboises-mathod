<?php

function dashboard($panel = null)
{
    if (isAdmin()) {
        require_once("view/administrationDashboard.php");

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
                $users = getUsers();
                $component = componentUsers($users);
                break;
            case 'roles':
                require_once("model/roles.php");
                require_once("view/assets/components/administrationDashboard/roles.php");
                $roles = getRoles();
                $component = componentRoles($roles);
                break;
            default:
                $component = null;
        }

        viewAdministrationDashboard($component, $panel);
    } else {
        header("Location: /forbidden");
    }
}

function isAdmin()
{
    require_once("model/users_possesses_roles.php");
    return hasRole($_SESSION["username"], "administrator");
}
