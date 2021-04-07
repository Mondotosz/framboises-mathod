<?php

/**
 * @brief recipe list view
 * @return void
 */
function viewRecipeList($recipes, $pagination = null)
{
    $title = "recettes";

    ob_start();
?>
    <div class="flex flex-col justify-between flex-grow py-2">
        <div class="flex flex-col divide-y divide-red-300">
            <?php foreach ($recipes as $recipe) { ?>
                <div class="flex flex-col py-2">
                    <a href="/recipes/<?= $recipe["id"] ?>" class="flex flex-row justify-between p-3 sm:rounded-md hover:bg-pink-50 hover:shadow">
                        <div class="flex flex-col flex-grow space-y-2">
                            <div class="text-xl font-medium title sm:text-2xl"><?= $recipe["name"] ?? "{no title}" ?></div>
                            <div class="description"><?= $recipe["description" ?? ""] ?></div>
                            <div class="border border-pink-200 rounded-md w-min">
                                <table class="table text-left w-min">
                                    <tbody class="divide-y divide-pink-200">
                                        <tr class="divide-x divide-pink-200">
                                            <th class="px-3 py-1 bg-hero-diagonal-lines-pink-10" scope="row">préparation</th>
                                            <td class="px-3 py-1"><?= $recipe["time"]["preparation"] ?></td>
                                        </tr>
                                        <tr class="divide-x divide-pink-200">
                                            <th class="px-3 py-1 bg-hero-diagonal-lines-pink-10" scope="row">cuisson</th>
                                            <td class="px-3 py-1"><?= $recipe["time"]["cooking"] ?></td>
                                        </tr>
                                        <tr class="divide-x divide-pink-200">
                                            <th class="px-3 py-1 bg-hero-diagonal-lines-pink-10" scope="row">repos</th>
                                            <td class="px-3 py-1"><?= $recipe["time"]["rest"] ?></td>
                                        </tr>
                                        <tr class="divide-x divide-pink-200">
                                            <th class="px-3 py-1 bg-hero-diagonal-lines-pink-10" scope="row">total</th>
                                            <td class="px-3 py-1"><?= $recipe["time"]["total"] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if (!empty($recipe["images"][0])) { ?>
                            <img class="object-cover w-1/3 rounded-md shadow md:w-1/2" src="<?= $recipe["images"][0] ?>" alt="image de <?= $recipe["name"] ?>">
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="flex flex-col items-center justify-center px-2 sm:flex-row">
            <?= $pagination ?? "" ?>
        </div>

    </div>
<?php
    $content = ob_get_clean();

    //Meta tag for nav
    $head = '<meta nav="recipes">';

    require_once "view/template.php";
    viewTemplate($title, $content, $head);
}
