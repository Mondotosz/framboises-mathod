<?php

/**
 * administration dashboard view with nav
 * @param string $component html component
 * @param string $nav current nav for highlight
 * @return void
 */
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
    <div class="container grid grid-cols-12 gap-4 p-5 mx-auto border border-gray-200 shadow sm:rounded-md">
        <div class="flex-col hidden p-2 space-y-2 border border-gray-200 rounded-md shadow-sm dashboard-nav lg:col-span-2 lg:flex">
            <a data-dashboard-nav="overview" href="/administration/dashboard" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Vue d'ensemble</a>
            <a data-dashboard-nav="users" href="/administration/dashboard/users" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Utilisateurs</a>
            <a data-dashboard-nav="roles" href="/administration/dashboard/roles" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Roles</a>
            <a data-dashboard-nav="openings" href="/administration/dashboard/openings" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Ouverture</a>
            <a data-dashboard-nav="images" href="/administration/dashboard/images" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Images</a>
            <a data-dashboard-nav="recipes" href="/administration/dashboard/recipes" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Recettes</a>
        </div>
        <div class="flex flex-col col-span-12 p-2 space-y-2 border border-gray-200 rounded-md shadow-sm dashboard-nav-mobile lg:hidden">
            <a data-dashboard-nav="overview" href="/administration/dashboard" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Vue d'ensemble</a>
            <a data-dashboard-nav="users" href="/administration/dashboard/users" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Utilisateurs</a>
            <a data-dashboard-nav="roles" href="/administration/dashboard/roles" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Roles</a>
            <a data-dashboard-nav="openings" href="/administration/dashboard/openings" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Ouverture</a>
            <a data-dashboard-nav="images" href="/administration/dashboard/images" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Images</a>
            <a data-dashboard-nav="recipes" href="/administration/dashboard/recipes" class="px-2 py-1 rounded-md hover:bg-pink-400 hover:text-gray-900">Recettes</a>
        </div>
        <div class="h-auto col-span-12 dashboard-content lg:col-span-10">
            <?php if (!empty($component)) { ?>
                <?= $component ?>
            <?php } else { ?>
                <div class="grid h-full col-span-12 border border-gray-200 rounded-md shadow-sm place-items-center">Empty</div>
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
