<?php

/**
 * variety creation
 * @return void
 */
function viewVarietyCreate()
{
    $title = "Nouvelle variété";

    ob_start();
?>
    <div class="p-3 my-2 space-y-2 border shadow-sm bg-pink-50 sm:rounded-md">
        <form action="/varieties/new" method="post" enctype='multipart/form-data' class="flex flex-col space-y-2">
            <div class="flex flex-col">
                <label class="px-2 font-bold" for="name">Nom</label>
                <input class="flex-grow border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="text" placeholder="name" id="name" name="name" required>
            </div>
            <div class="flex flex-col space-y-3 md:space-y-0 md:space-x-3 md:flex-row">
                <div class="flex-grow">
                    <label class="px-2 font-bold" for="description">Description</label>
                    <textarea class="w-full border-gray-300 rounded-md shadow-sm h-max focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" placeholder="description" id="description" name="description" required></textarea>
                </div>

                <table class="table">
                    <tbody class="space-y-3">
                        <tr>
                            <th>
                                <label class="px-2 font-bold" for="price">prix</label>
                            </th>
                            <td>
                                <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="number" min="0" max="999" step="any" id="price" name="price" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="px-2 font-bold" for="unit">unité</label>
                            </th>
                            <td>
                                <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="text" id="unit" name="unit" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            <button class="px-3 py-2 font-medium text-white bg-red-500 rounded-md hover:bg-red-600" type="submit">Créer</button>
        </form>
    </div>
    <?php
    $content = ob_get_clean();

    ob_start();
    ?>
<?php
    $foot = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content, null, $foot);
}
