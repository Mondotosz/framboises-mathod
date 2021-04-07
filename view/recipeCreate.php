<?php

/**
 * @brief recipe creation
 * @return void
 */
function viewRecipeCreate()
{
    $title = "new recipe";

    ob_start();
?>
    <div class="p-3 my-2 border shadow-sm bg-pink-50 sm:rounded-md space-y-2">
        <form action="/recipes/new" method="post" enctype='multipart/form-data' class="flex flex-col space-y-2">
            <div class="flex flex-col">
                <label class="px-2 font-bold" for="name">Nom</label>
                <input class="rounded-md border-gray-300 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50 flex-grow" type="text" placeholder="name" id="name" name="name" required>
            </div>
            <div class="flex flex-col md:flex-row space-x-2">
                <div class="flex-grow">
                    <label class="px-2 font-bold" for="description">Description</label>
                    <textarea class="rounded-md w-full h-max border-gray-300 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" placeholder="description" id="description" name="description"></textarea>
                </div>
                <div class="flex flex-col">
                    <table class="table text-left w-full md:w-max">
                        <tbody>
                            <tr>
                                <th class="px-2"><label for="portions">Portions</label></th>
                                <td>
                                    <input class="rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50 w-full" type="number" min="0" step="any" id="portions" name="portions" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="preparation">Preparation</label></th>
                                <td>
                                    <input class=" w-full rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" value="00:00" id="preparation" name="time[preparation]" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="cooking">Cuisson</label></th>
                                <td>
                                    <input class=" w-full rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" value="00:00" id="cooking" name="time[cooking]" required>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-2"><label for="rest">Repos</label></th>
                                <td>
                                    <input class=" w-full rounded-md border-gray-300 focus:border-pink-300 shadow-sm focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="time" value="00:00" id="rest" name="time[rest]" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="relative">
                <div class="w-full px-3 py-2 rounded-md bg-pink-200 hover:bg-pink-300 flex justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    upload image
                </div>
                <input class="absolute inset-y-0 top-0 opacity-0 w-full h-full cursor-pointer" type="file" multiple name="images[]">
            </div>
            <button class="rounded-md bg-pink-300 hover:bg-pink-400 px-3 py-2" type="submit">+</button>
        </form>
    </div>
<?php
    $content = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content);
}
