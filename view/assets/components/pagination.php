<?php

function componentPagination($maxPage, $currentPage, $amount, $url)
{
    ob_start();
?>
    <div class="flex flex-row divide-x divide-gray-200 justify-center border border-gray-200 rounded-md">
        <a href="<?= (($currentPage - 1) < 1) ? "" : "$url?page=" . ($currentPage - 1) . "&amount=$amount" ?>" class="py-2 px-3 flex flex-col justify-center<?= (($currentPage - 1) < 1) ? " bg-gray-200" : "" ?>">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <?php if ($maxPage <= 7) {
            // all
            for ($i = 1; $i <= $maxPage; $i++) { ?>
                <a href="<?= $url ?>?page=<?= $i ?>&amount=<?= $amount ?>" class="py-2 px-3<?= ($currentPage == $i) ? " bg-pink-100" : "" ?>"><?= $i ?></a>
            <?php }
        } else if ($currentPage <= 4) {
            // early
            for ($i = 1; $i <= 5; $i++) { ?>
                <a href="<?= $url ?>?page=<?= $i ?>&amount=<?= $amount ?>" class="py-2 px-3<?= ($currentPage == $i) ? " bg-pink-100" : "" ?>"><?= $i ?></a>
            <?php } ?>
            <div class="py-2 px-3">...</div>
            <a href="<?= $url ?>?page=<?= $maxPage ?>&amount=<?= $amount ?>" class="py-2 px-3"><?= $maxPage ?></a>
        <?php
        } else if (($maxPage - $currentPage) <= 4) {
            // late
        ?>
            <a href="<?= $url ?>?page=1&amount=<?= $amount ?>" class="py-2 px-3">1</a>
            <div class="py-2 px-3">...</div>
            <?php for ($i = $maxPage - 4; $i <= $maxPage; $i++) { ?>
                <a href="<?= $url ?>?page=<?= $i ?>&amount=<?= $amount ?>" class="py-2 px-3<?= ($currentPage == $i) ? " bg-pink-100" : "" ?>"><?= $i ?></a>
            <?php }
        } else {
            // middle
            ?>
            <a href="<?= $url ?>?page=1&amount=<?= $amount ?>" class="py-2 px-3">1</a>
            <div class="py-2 px-3">...</div>
            <?php for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {  ?>
                <a href="<?= $url ?>?page=<?= $i ?>&amount=<?= $amount ?>" class="py-2 px-3<?= ($currentPage == $i) ? " bg-pink-100" : "" ?>"><?= $i ?></a>
            <?php } ?>
            <div class="py-2 px-3">...</div>
            <a href="<?= $url ?>?page=<?= $maxPage ?>&amount=<?= $amount ?>" class="py-2 px-3"><?= $maxPage ?></a>
        <?php } ?>
        <a href="<?= (($currentPage + 1) > $maxPage) ? "" : "$url?page=" . ($currentPage + 1) . "&amount=$amount" ?>" class="py-2 px-3 flex flex-col justify-center<?= (($currentPage + 1) > $maxPage) ? " bg-gray-200" : "" ?>">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
<?php

    return ob_get_clean();
}

function componentPaginationStatus($limit, $offset, $max)
{
    ob_start();
?>
    <div class="flex flex-col justify-center">
        <?php if($offset > $max){ ?>
            <div class="text-sm text-gray-700">Showing <span class="font-medium">0</span> of <span class="font-medium"><?= $max ?></span> results</div>
        <?php }else{ ?>
        <div class="text-sm text-gray-700">Showing <span class="font-medium"><?= $offset + 1 ?></span> to <span class="font-medium"><?= (($offset + $limit) < $max) ? $offset + $limit : $max ?></span> of <span class="font-medium"><?= $max ?></span> results</div>
        <?php } ?>
    </div>
<?php
    return ob_get_clean();
}
