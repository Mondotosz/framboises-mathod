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
    <div class="flex-grow flex flex-col justify-between py-2">
        <div class="recipes flex flex-col divide-y divide-red-300">
            <?php foreach ($recipes as $recipe) { ?>
                <div class="recipe flex flex-col p-3">
                    <div class="flex flex-row justify-between">
                        <div class="flex flex-col flex-grow">
                            <a href="/recipes/<?= $recipe["id"] ?>" class="title text-xl sm:text-2xl font-medium"><?= $recipe["name"] ?? "{no title}" ?></a>
                            <div class="description"><?= $recipe["description"] ?></div>
                        </div>
                        <?php if (!empty($recipe["images"][0])) { ?>
                            <img class="object-scale-down w-1/3 md:w-1/2 rounded-md shadow" src="<?= $recipe["images"][0] ?>" alt="image de <?= $recipe["name"] ?>">
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="flex flex-col sm:flex-row justify-center px-2 items-center">
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
