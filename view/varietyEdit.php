<?php

/**
 * variety edition
 * @param array $variety
 * @return void
 */
function viewVarietyEdit($variety)
{
    $title = $variety["name"] ?? null;

    ob_start();
?>
    <div class="p-3 my-2 space-y-2 border shadow-sm bg-pink-50 sm:rounded-md">
        <form action="/varieties/edit/<?= $variety["id"] ?>" method="post" enctype='multipart/form-data' class="flex flex-col space-y-2">
            <div class="flex flex-col">
                <label class="px-2 font-bold" for="name">Nom</label>
                <input class="flex-grow border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="text" placeholder="name" id="name" name="name" value="<?= $variety["name"] ?? "" ?>" required>
            </div>
            <div class="flex flex-col space-y-3 md:space-y-0 md:space-x-3 md:flex-row">
                <div class="flex-grow">
                    <label class="px-2 font-bold" for="description">Description</label>
                    <textarea class="w-full border-gray-300 rounded-md shadow-sm h-max focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" placeholder="description" id="description" name="description" required><?= $variety["description"] ?? "" ?></textarea>
                </div>

                <table class="table">
                    <tbody class="space-y-3">
                        <tr>
                            <th>
                                <label class="px-2 font-bold" for="price">prix</label>
                            </th>
                            <td>
                                <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="number" min="0" max="999" step="any" id="price" name="price" value="<?= $variety["price"] ?? "" ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="px-2 font-bold" for="unit">unité</label>
                            </th>
                            <td>
                                <input class="w-full border-gray-300 rounded-md shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-300 focus:ring-opacity-50" type="text" id="unit" name="unit" value="<?= $variety["unit"] ?? "" ?>" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="px-3 py-2 font-medium text-white bg-red-500 rounded-md hover:bg-red-600" type="submit">Appliquer</button>
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
