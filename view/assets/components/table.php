<?php

/**
 * @brief table of recipes
 * @return string recipes dashboard component
 */
function componentTable($headers, $rows, $pagination = null, $paginationStatus = null)
{
    file_put_contents("log.log",print_r($headers,true),FILE_APPEND);
    ob_start();
?>
    <div class="flex flex-col space-y-2">
        <div class="overflow-x-auto border border-gray-200 shadow-sm sm:rounded-lg">
            <table class="w-full table table-auto divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <?php foreach ($headers as $header) { ?>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?= $header ?></th>
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
        <div class="flex flex-col sm:flex-row justify-between px-2 items-center">
            <?= $paginationStatus ?? "" ?>
            <?= $pagination ?? "" ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
