<?php

/**
 * @brief table of recipes
 * @param array recipes
 * @return string recipes dashboard component
 */
function componentRecipes($recipes, $pagination, $paginationStatus = null)
{
    ob_start();
?>
    <div class="flex flex-col space-y-2">
        <?php
        if (!empty($recipes)) {

        ?>
            <div class="overflow-x-auto border border-gray-200 shadow-sm sm:rounded-lg">
                <table class="w-full table table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recipes as $recipe) { ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $recipe["id"] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $recipe["name"] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $recipe["description"] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
        <div class="flex flex-row justify-between px-2">
            <?= $paginationStatus ?? "" ?>
            <?= $pagination ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
