<?php

function componentRoles($roles)
{
    ob_start();
    if (!empty($roles)) {
?>
        <div class="col-span-12 overflow-x-auto border border-gray-200 shadow-sm sm:rounded-lg flex flex-col">
            <table class="w-full table-auto divide-y divide-gray-200 border-b border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modifier</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supprimer</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($roles as $role) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $role["id"] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $role["name"] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"></td>
                            <td class="px-6 py-4 whitespace-nowrap"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

<?php
    }
    return ob_get_clean();
}
