<?php

function viewAdministrationDashboard($component = null, $nav = null)
{
    $title = "dashboard";

    ob_start();
?>
    <meta dashboard-nav="<?= $nav ?? "" ?>">
    <?php
    $head = ob_get_clean();

    ob_start();
    ?>
    <div class="container grid grid-cols-12 gap-4 mx-auto p-5 border border-gray-200 shadow sm:rounded-md">
        <div class="dashboard-nav col-span-2 hidden lg:flex flex-col space-y-2 border border-gray-200 rounded-md shadow-sm p-2">
            <a data-dashboard-nav="overview" href="/administration/dashboard" class="py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Vue d'ensemble</a>
            <a data-dashboard-nav="users" href="/administration/dashboard/users" class="py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Utilisateurs</a>
            <a data-dashboard-nav="roles" href="/administration/dashboard/roles" class="py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Roles</a>
            <a data-dashboard-nav="openings" href="/administration/dashboard/openings" class="py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Ouverture</a>
            <a data-dashboard-nav="images" href="/administration/dashboard/images" class="py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Images</a>
            <a data-dashboard-nav="recipes" href="/administration/dashboard/recipes" class="py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Recettes</a>
        </div>
        <div class="dashboard-content col-span-12 lg:col-span-10 h-auto">
            <?php if (!empty($component)) { ?>
                <?= $component ?>
            <?php } else { ?>
                <div class="col-span-12 grid place-items-center border border-gray-200 rounded-md shadow-sm h-full">Empty</div>
            <?php } ?>
        </div>
    </div>
    <?php
    $content = ob_get_clean();

    ob_start();
    ?>
    <script type="module" src="/view/js/dashboard.js"></script>
<?php
    $foot = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $foot);
}
