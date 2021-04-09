<?php

/**
 * recipe view
 * @param array $recipe
 * @param bool $canManage
 * @return void
 */
function viewRecipe($recipe, $canManage)
{
    $title = $recipe["name"];

    ob_start();
?>
    <?php if ($canManage) { ?>
        <div class="flex flex-col md:flex-row space-x-3 py-2 px-3">
            <div class="flex-row md:flex-col flex justify-center">
                <button type="button" class="h-full text-black focus:outline-none hover:text-red-700 focus:text-red-700" data-collapse-control="settings">
                    <svg class="h-8 stroke-current transition-all transform duration-500 origin-center hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <div data-collapse="settings" class="hidden flex-grow">
                <div class="flex flex-col justify-center h-full">
                    <div class="flex flex-col md:flex-row flex-wrap md:children:mx-2 space-y-2 md:space-y-0 text-center">
                        <a href="/recipes/new" class="bg-pink-200 rounded-md px-3 py-1 hover:bg-pink-300 font-medium sm:my-0">Nouvelle recette</a>
                        <a href="/recipes/edit/<?= $recipe["id"] ?>" class="bg-pink-200 rounded-md px-3 py-1 hover:bg-pink-300 font-medium sm:my-0">Modifier cette recette</a>
                        <form method="POST" action="/recipes/delete">
                            <button class="bg-pink-200 rounded-md px-3 py-1 w-full hover:bg-pink-300 font-medium sm:my-0">Effacer cette recette</button>
                            <input type="hidden" name="id" value="<?= $recipe["id"] ?>">
                            <input type="hidden" name="confirmation" value="true">
                            <input type="hidden" name="redirection" value="/recipes">
                            <input type="hidden" name="origin" value="/recipes/<?= $recipe["id"] ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="p-3 my-2 space-y-2 border shadow-sm bg-pink-50 sm:rounded-md">
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
                    <svg class="inline w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div data-carousel class="flex flex-row justify-center h-64 carousel sm:h-96 lg:h-144">
                <div class="relative">
                    <button data-carousel-previous class="absolute inset-y-0 left-0 w-16 rounded-l-md focus:outline-none hover:bg-white hover:bg-opacity-10 focus:bg-white focus:bg-opacity-10">
                        <svg class="w-10 h-10 mx-auto text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
                <?php foreach ($recipe["images"] as $key => $image) { ?>
                    <div data-carousel-item class=" w-full flex justify-center bg-blend-luminosity bg-black rounded-md <?= (array_key_first($recipe["images"]) == $key) ? "" : " hidden" ?>">
                        <img class="object-contain h-full rounded-md" src="<?= $image["path"] ?>" alt="image <?= $key ?>">
                    </div>
                <?php } ?>
                <div class="relative">
                    <button data-carousel-next class="absolute inset-y-0 right-0 w-16 rounded-r-md focus:outline-none hover:bg-white hover:bg-opacity-10 focus:bg-white focus:bg-opacity-10">
                        <svg class="w-10 h-10 mx-auto text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

    ob_start();
    ?>
    <script type="module" src="/view/js/carousel.js"></script>
    <?php if ($canManage) { ?>
        <script type="module" src="/view/js/collapse.js"></script>
    <?php } ?>
<?php

    $foot = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $foot);
}
