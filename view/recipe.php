<?php

/**
 * @brief recipe view
 * @return void
 */
function viewRecipe($recipe)
{
    $title = $recipe["name"];

    ob_start();
?>
    <div class="p-3 my-2 border shadow-sm bg-pink-50 sm:rounded-md space-y-2">
        <div class="text-3xl font-medium"><?= $recipe["name"] ?? "{ no name }" ?></div>
        <div class="flex flex-row justify-between">
            <?php if (!empty($recipe["description"])) { ?>
                <div class="text-xl whitespace-pre-line"><?= $recipe["description"] ?></div>
            <?php } ?>
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
        <ul class="">
            <?php foreach ($recipe["ingredients"] as $ingredient) { ?>
                <li>
                    <svg class="h-4 w-4 text-pink-500 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 6a1 1 0 011.707-.707l6 6a1 1 0 010 1.414l-6 6A1 1 0 018 18V6z" fill="currentColor" />
                    </svg>
                    <span class="font-medium"><?= $ingredient["amount"] ?></span> <?= $ingredient["name"] ?>
                </li>
            <?php } ?>
        </ul>
        <ol class="">
            <?php foreach ($recipe["steps"] as $step) { ?>
                <li><span class="font-medium"><?= $step["number"] ?>. </span><?= $step["instruction"] ?></li>
            <?php } ?>
        </ol>
        <?php if (!empty($recipe["images"])) { ?>
            <div data-carousel class="carousel flex flex-row justify-center h-64 sm:h-96 lg:h-144">
                <div class="relative">
                    <button data-carousel-previous class="absolute inset-y-0 left-0 w-16 rounded-l-md focus:outline-none hover:bg-white hover:bg-opacity-10 focus:bg-white focus:bg-opacity-10">
                        <svg class="h-10 w-10 mx-auto text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
                <?php foreach ($recipe["images"] as $key => $image) { ?>
                    <div data-carousel-item class=" w-full flex justify-center bg-blend-luminosity bg-black rounded-md <?= (array_key_first($recipe["images"]) == $key) ? "" : " hidden" ?>">
                        <img class="object-contain rounded-md h-full" src="<?= $image["path"] ?>" alt="image <?= $key ?>">
                    </div>
                <?php } ?>
                <div class="relative">
                    <button data-carousel-next class="absolute inset-y-0 right-0 w-16 rounded-r-md focus:outline-none hover:bg-white hover:bg-opacity-10 focus:bg-white focus:bg-opacity-10">
                        <svg class="h-10 w-10 mx-auto text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

            </div>
        <?php } ?>
    </div>
<?php
    $content = ob_get_clean();

    //Meta tag for nav
    $head = '<meta nav="recipes">';

    $foot = '<script type="module" src="/view/js/carousel.js"></script>';

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $foot);
}
