<?php

/**
 * @brief table of recipes
 * @param array $headers table headers
 * @param array $rows table rows
 * @param string $pagination pagination component
 * @param string $paginationStatus pagination status component
 * @return string recipes dashboard component
 */
function componentTable($headers, $rows, $pagination = null, $paginationStatus = null)
{
    ob_start();
?>
    <div class="flex flex-col space-y-2">
        <div class="overflow-x-auto border border-gray-200 shadow-sm sm:rounded-lg">
            <table class="table w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <?php foreach ($headers as $header) { ?>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"><?= $header ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($rows as $row) { ?>
                        <tr>
                            <?php foreach (array_keys($headers) as $key) { ?>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row[$key] ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="flex flex-col items-center justify-between px-2 sm:flex-row">
            <?= $paginationStatus ?? "" ?>
            <?= $pagination ?? "" ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
