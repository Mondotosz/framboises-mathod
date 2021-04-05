<?php

/**
 * @brief table of roles
 * @param array roles
 * @return string roles dashboard component
 */
function componentRoles($roles, $pagination,$paginationStatus = null)
{
    ob_start();
?>
    <div class="flex flex-col space-y-2">
        <?php if (!empty($roles)) { ?>
            <div class="overflow-x-auto border border-gray-200 shadow-sm sm:rounded-lg flex flex-col">
                <table class="w-full table table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($roles as $role) { ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $role["id"] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $role["name"] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        <?php } ?>
        <div class="flex flex-row justify-between px-2">
            <?= $paginationStatus ?? "" ?>
            <?= $pagination ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
