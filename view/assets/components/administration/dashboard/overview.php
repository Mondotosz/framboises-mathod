<?php

/**
 * @brief overview dashboard component
 * @TODO create micro components to insert
 * @param array
 * @return string overview dashboard component
 */
function componentOverview($stats = null)
{
    ob_start();
?>
    <div class="flex flex-wrap space-x-4 space-y-4 transform -translate-x-4">
        <?php if (!empty($stats)) { ?>
            <div class="flex flex-col flex-auto ml-4 rounded-md shadow">
                <div class="py-2 text-center border-b border-gray-200">
                    <div class="text-lg">Stats</div>
                </div>
                <table class="table table-auto">
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($stats as $key => $stat) { ?>
                            <tr class="divide-x divide-gray-200">
                                <th scope="row" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50"><?= $key ?></th>
                                <td class="px-6 py-3 bg-white whitespace-nowrap"><?= $stat ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>

<?php
    return ob_get_clean();
}
