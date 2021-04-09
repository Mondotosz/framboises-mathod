<?php

/**
 * @brief recipe list view
 * @param array $recipes
 * @param string $pagination
 * @param bool $canManage
 * @return void
 */
function viewRecipeList($recipes, $pagination = null, $canManage)
{
    $title = "recettes";

    ob_start();
?>
    <div class="flex flex-col justify-between flex-grow py-2">
        <div class="flex flex-col divide-y divide-red-300">
            <?php if ($canManage) { ?>
                <div class="flex flex-row space-x-3 py-2 px-3">
                    <div class="flex-col flex justify-center">
                        <button type="button" class="h-full text-black focus:outline-none hover:text-red-700 focus:text-red-700" data-collapse-control="settings">
                            <svg class="h-8 stroke-current transition-all transform duration-500 origin-center hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    <div data-collapse="settings" class="hidden">
                        <div class="flex flex-col justify-center h-full">
                            <div class="flex flex-row flex-wrap children:mx-2">
                                <a href="/recipes/new" class="bg-pink-200 rounded-md px-3 py-1 my-2 hover:bg-pink-300 font-medium sm:my-0">Nouvelle recette</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php foreach ($recipes as $recipe) { ?>
                <div class="flex flex-col py-2">
                    <a href="/recipes/<?= $recipe["id"] ?>" class="flex flex-row justify-between p-3 sm:rounded-md hover:bg-pink-50 hover:shadow">
                        <div class="flex flex-col flex-grow space-y-2">
                            <div class="text-xl font-medium title sm:text-2xl"><?= $recipe["name"] ?? "{no title}" ?></div>
                            <div class="whitespace-pre-line"><?= $recipe["description" ?? ""] ?></div>
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
                        <?php if (!empty($recipe["image"])) { ?>
                            <img class="object-cover w-1/3 max-h-128 rounded-md shadow md:w-1/2" src="<?= $recipe["image"] ?>" alt="image de <?= $recipe["name"] ?>">
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

    // Meta tag for nav
    $head = '<meta nav="recipes">';

    // Management dependency
    $foot = $canManage ? '<script type="module" src="/view/js/collapse.js"></script>' : '';

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $foot);
}
