<?php

/**
 * opening creation
 * @return void
 */
function viewOpeningCreate()
{
    $title = "Nouvelle ouverture";

    ob_start();
?>
    <div class="p-3 my-2 space-y-2 border shadow-sm bg-pink-50 sm:rounded-md">
        <form action="/openings/new" method="post" class="flex flex-col space-y-2">
            <div class="flex flex-col space-y-3 md:space-y-0 md:space-x-3 md:flex-row">
                <div class="flex-grow">
                    <label class="px-2 font-bold" for="description">Description</label>
                    <div class="w-full border-gray-300 rounded-md shadow-sm h-full">
                        <textarea class="w-full border-gray-300 rounded-md shadow-sm h-max focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" placeholder="description" id="description" name="description"></textarea>
                    </div>
                </div>

                <table class="table">
                    <tbody class="space-y-3">
                        <tr>
                            <th>
                                <label class="px-2 font-bold" for="start">Début</label>
                            </th>
                            <td>
                                <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="datetime-local" id="start" name="start" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="px-2 font-bold" for="end">Fin</label>
                            </th>
                            <td>
                                <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="datetime-local" id="end" name="end" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="px-2 font-bold" for="places">Places</label>
                            </th>
                            <td>
                                <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="number" max="255" min="0" step="1" id="places" name="places">
                            </td>
                        </tr>
                    </tbody>
                </table>
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
