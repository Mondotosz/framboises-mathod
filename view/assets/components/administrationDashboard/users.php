<?php

/**
 * @brief table of users
 * @param array users
 * @return string users dashboard component
 */
function componentUsers($users, $pagination, $paginationStatus = null)
{
    ob_start();
?>
    <div class="flex flex-col space-y-2">
        <?php
        if (!empty($users)) {

        ?>
            <div class="overflow-x-auto border border-gray-200 shadow-sm sm:rounded-lg">
                <table class="w-full table table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom d'utilisateur</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $user["id"] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $user["username"] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $user["email"] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $user["creation_date"] ?></td>
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
