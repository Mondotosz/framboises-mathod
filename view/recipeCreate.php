<?php

/**
 * recipe creation
 * @return void
 */
function viewRecipeCreate()
{
    $title = "new recipe";

    ob_start();
?>
    <div class="p-3 my-2 space-y-2 border shadow-sm bg-pink-50 sm:rounded-md">
        <form action="/recipes/new" method="post" enctype='multipart/form-data' class="flex flex-col space-y-2">
            <div class="flex flex-col">
                <label class="px-2 font-bold" for="name">Nom</label>
                <input class="flex-grow border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="text" placeholder="name" id="name" name="name" required>
            </div>
            <div class="flex flex-col space-x-2 md:flex-row">
                <div class="flex-grow">
                    <label class="px-2 font-bold" for="description">Description</label>
                    <textarea class="w-full border-gray-300 rounded-md shadow-sm h-max focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" placeholder="description" id="description" name="description"></textarea>
                </div>
                <div class="flex flex-col">
                    <table class="table w-full text-left md:w-max">
                        <tbody>
                            <tr>
                                <th class="px-2"><label for="portions">Portions</label></th>
                                <td>
                                    <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="number" min="0" max="999" step="any" id="portions" name="portions" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="preparation">Preparation</label></th>
                                <td>
                                    <input class="w-full border-gray-300 rounded-md shadow-sm  focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" value="00:00" id="preparation" name="time[preparation]" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="cooking">Cuisson</label></th>
                                <td>
                                    <input class="w-full border-gray-300 rounded-md shadow-sm  focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" value="00:00" id="cooking" name="time[cooking]" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="rest">Repos</label></th>
                                <td>
                                    <input class="w-full border-gray-300 rounded-md shadow-sm  focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" value="00:00" id="rest" name="time[rest]" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="relative">
                <input class="absolute inset-y-0 top-0 w-full h-full opacity-0 cursor-pointer" type="file" accept=".jpg, .jpeg, .png, .gif, .svg" multiple name="images[]">
                <div class="flex justify-center w-full px-3 py-2 space-x-2 bg-pink-200 rounded-md pointer-events-auto hover:bg-pink-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <div class="font-medium">Ajouter des images</div>
                </div>
            </div>
            <div class="flex flex-col overflow-hidden rounded-md">
                <div data-collapse-control="ingredients" class="relative w-full px-3 py-2 font-medium text-center bg-pink-200 cursor-pointer">
                    <div class="">Ingredients</div>
                    <svg data-collapse-indicator="on" class="absolute inset-y-0 right-0 h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg data-collapse-indicator="off" class="absolute inset-y-0 right-0 hidden h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </div>
                <div data-collapse="ingredients" class="hidden p-2 space-y-2 bg-pink-100">
                    <div class="flex flex-col">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th class="w-1/4 font-medium">Quantité</th>
                                    <th class="w-3/4 font-medium">Nom</th>
                                    <th class="font-medium">Effacer</th>
                                </tr>
                            </thead>
                            <tbody data-recipe-create="ingredients" data-current-increment="1">
                                <tr>
                                    <td>
                                        <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="number" placeholder="0" min="0" max="9999" step="any" name="ingredients[0][amount]">
                                    </td>
                                    <td>
                                        <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="text" placeholder="..." name="ingredients[0][name]">
                                    </td>
                                    <td>
                                        <button data-recipe-delete="row" type="button" class="w-full h-full p-1">
                                            <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="btnIngredientsAdd" class="w-full px-3 py-2 bg-pink-200 rounded-md hover:bg-pink-300">
                        <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex flex-col overflow-hidden rounded-md">
                <div data-collapse-control="steps" class="relative w-full px-3 py-2 font-medium text-center bg-pink-200 cursor-pointer">
                    <div class="">Étapes</div>
                    <svg data-collapse-indicator="on" class="absolute inset-y-0 right-0 h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg data-collapse-indicator="off" class="absolute inset-y-0 right-0 hidden h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </div>
                <div data-collapse="steps" class="hidden p-2 space-y-2 bg-pink-100">
                    <div class="flex flex-col">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th class="w-1/4 font-medium">Numéro</th>
                                    <th class="w-3/4 font-medium">Instruction</th>
                                    <th class="w-3/4 font-medium">Effacer</th>
                                </tr>
                            </thead>
                            <tbody data-recipe-create="steps" data-current-increment="1">
                                <tr>
                                    <td>
                                        <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="number" placeholder="0" min="0" max="9999" name="steps[0][number]" value="1">
                                    </td>
                                    <td>
                                        <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="text" placeholder="..." name="steps[0][instruction]">
                                    </td>
                                    <td>
                                        <button data-recipe-delete="row" type="button" class="w-full h-full p-1">
                                            <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="btnStepsAdd" class="w-full px-3 py-2 bg-pink-200 rounded-md hover:bg-pink-300">
                        <svg class="h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>
            </div>
            <button class="px-3 py-2 font-medium text-white bg-red-500 rounded-md hover:bg-red-600" type="submit">Créer</button>
        </form>
    </div>
    <?php
    $content = ob_get_clean();

    ob_start();
    ?>
    <script type="module" src="/view/js/collapse.js"></script>
    <script type="module" src="/view/js/recipeCreate.js"></script>
<?php
    $foot = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content, null, $foot);
}
