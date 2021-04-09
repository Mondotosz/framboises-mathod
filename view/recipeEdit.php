<?php

/**
 * recipe edition
 * @param array $recipe
 * @return void
 */
function viewRecipeEdit($recipe)
{
    $title = $recipe["name"];

    ob_start();
?>
    <div class="p-3 my-2 border shadow-sm bg-pink-50 sm:rounded-md space-y-2">
        <form action="/recipes/edit/<?= $recipe["id"] ?>" method="post" enctype='multipart/form-data' class="flex flex-col space-y-2">
            <div class="flex flex-col">
                <label class="px-2 font-bold" for="name">Nom</label>
                <input class="rounded-md border-gray-300 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50 flex-grow" type="text" placeholder="name" id="name" name="name" value="<?= $recipe["name"] ?>" required>
            </div>
            <div class="flex flex-col md:flex-row space-x-2">
                <div class="flex-grow">
                    <label class="px-2 font-bold" for="description">Description</label>
                    <textarea class="rounded-md w-full h-max border-gray-300 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" placeholder="description" id="description" name="description"><?= $recipe["description"] ?></textarea>
                </div>
                <div class="flex flex-col">
                    <table class="table text-left w-full md:w-max">
                        <tbody>
                            <tr>
                                <th class="px-2"><label for="portions">Portions</label></th>
                                <td>
                                    <input class="rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50 w-full" type="number" min="0" max="999" step="any" id="portions" name="portions" value="<?= $recipe["portions"] ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="preparation">Preparation</label></th>
                                <td>
                                    <input class=" w-full rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" id="preparation" name="time[preparation]" value="<?= $recipe["preparation"] ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="cooking">Cuisson</label></th>
                                <td>
                                    <input class=" w-full rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" id="cooking" name="time[cooking]" value="<?= $recipe["cooking"] ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="rest">Repos</label></th>
                                <td>
                                    <input class=" w-full rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" id="rest" name="time[rest]" value="<?= $recipe["rest"] ?>" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex flex-col rounded-md overflow-hidden">
                <a href="/recipes/edit/<?= $recipe["id"] ?>/ingredients" data-collapse-control="ingredients" class="py-2 px-3 relative w-full text-center font-medium bg-pink-200 cursor-pointer">
                    <div class="">Ingredients</div>
                    <svg data-collapse-indicator="on" class="absolute inset-y-0 right-0 h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg data-collapse-indicator="off" class="absolute inset-y-0 right-0 h-full hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </a>
                <div data-collapse="ingredients" class="hidden bg-pink-100 p-2 space-y-2">
                    <div class="flex flex-col">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th class="font-medium w-1/4">Quantité</th>
                                    <th class="font-medium w-3/4">Nom</th>
                                    <th class="font-medium">Modifier</th>
                                    <th class="font-medium">Effacer</th>
                                </tr>
                            </thead>
                            <tbody data-recipe-create="ingredients" data-current-increment="1">
                                <?php foreach ($recipe["ingredients"] as $ingredient) { ?>
                                    <tr>
                                        <td>
                                            <div class="bg-white rounded-l-md px-3 py-2 w-full"><?= $ingredient["amount"] ?></div>
                                        </td>
                                        <td>
                                            <div class="bg-white rounded-r-md px-3 py-2 w-full"><?= $ingredient["name"] ?></div>
                                        </td>
                                        <td>
                                            <button type="button" class="h-full w-full p-1">
                                                <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                        <td>
                                            <button data-recipe-delete="row" type="button" class="h-full w-full p-1">
                                                <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="btnIngredientsAdd" class="w-full py-2 px-3 bg-pink-200 hover:bg-pink-300 rounded-md">
                        <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex flex-col rounded-md overflow-hidden">
                <a href="/recipes/edit/<?= $recipe["id"] ?>/steps" data-collapse-control="steps" class="py-2 px-3 relative w-full text-center font-medium bg-pink-200 cursor-pointer">
                    <div class="">Étapes</div>
                    <svg data-collapse-indicator="on" class="absolute inset-y-0 right-0 h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg data-collapse-indicator="off" class="absolute inset-y-0 right-0 h-full hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </a>
                <div data-collapse="steps" class="hidden bg-pink-100 p-2 space-y-2">
                    <div class="flex flex-col">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th class="font-medium w-1/4">Numéro</th>
                                    <th class="font-medium w-3/4">Instruction</th>
                                    <th class="font-medium">Modifier</th>
                                    <th class="font-medium">Effacer</th>
                                </tr>
                            </thead>
                            <tbody data-recipe-create="steps" data-current-increment="<?=count($recipe["steps"])?>">
                                <?php foreach ($recipe["steps"] as $step) { ?>
                                    <tr>
                                        <td>
                                            <div class="bg-white rounded-l-md px-3 py-2 w-full"><?= $step["number"] ?></div>
                                        </td>
                                        <td>
                                            <div class="bg-white rounded-r-md px-3 py-2 w-full"><?= $step["instruction"] ?></div>
                                        </td>
                                        <td>
                                            <button type="button" class="h-full w-full p-1">
                                                <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                        <td>
                                            <button data-recipe-delete="row" type="button" class="h-full w-full p-1">
                                                <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="btnStepsAdd" class="w-full py-2 px-3 bg-pink-200 hover:bg-pink-300 rounded-md">
                        <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>
            </div>
            <button class="rounded-md bg-red-500 text-white font-medium hover:bg-red-600 px-3 py-2" type="submit">Appliquer</button>
        </form>
    </div>
    <?php
    $content = ob_get_clean();

    ob_start();
    ?>
    <script type="module" src="/view/js/collapse.js"></script>
    <script type="module" src="/view/js/recipeEdit.js"></script>
<?php
    $foot = ob_get_clean();

    $head = '<meta recipe-id="'.$recipe["id"].'">';

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $foot);
}
