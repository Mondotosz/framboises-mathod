<?php

/**
 * calendar view
 * @param array $openings
 * @param bool $canManage
 * @return void
 */
function viewOpeningsCalendar($calendar, $canManage = false)
{
    $title = "ouvertures";
    $timeHeight = [
        0 => "h-1/24",
        1 => "h-1/24",
        2 => "h-2/24",
        3 => "h-3/24",
        4 => "h-4/24",
        5 => "h-5/24",
        6 => "h-6/24",
        7 => "h-7/24",
        8 => "h-8/24",
        9 => "h-9/24",
        10 => "h-10/24",
        11 => "h-11/24",
        12 => "h-12/24",
        13 => "h-13/24",
        14 => "h-14/24",
        15 => "h-15/24",
        16 => "h-16/24",
        17 => "h-17/24",
        18 => "h-18/24",
        19 => "h-19/24",
        20 => "h-20/24",
        21 => "h-21/24",
        22 => "h-22/24"
    ];

    $timeTop = [
        0 => "top-0",
        1 => "top-1/24",
        2 => "top-2/24",
        3 => "top-3/24",
        4 => "top-4/24",
        5 => "top-5/24",
        6 => "top-6/24",
        7 => "top-7/24",
        8 => "top-8/24",
        9 => "top-9/24",
        10 => "top-10/24",
        11 => "top-11/24",
        12 => "top-12/24",
        13 => "top-13/24",
        14 => "top-14/24",
        15 => "top-15/24",
        16 => "top-16/24",
        17 => "top-17/24",
        18 => "top-18/24",
        19 => "top-19/24",
        20 => "top-20/24",
        21 => "top-21/24",
        22 => "top-22/24"
    ];

    ob_start();
?>
    <?php if ($canManage) { ?>
        <div class="flex flex-col px-3 py-2 md:flex-row md:space-x-3">
            <div class="flex flex-row justify-center md:flex-col">
                <button type="button" class="h-full text-black focus:outline-none hover:text-red-700 focus:text-red-700" data-collapse-control="settings">
                    <svg class="h-8 transition-all duration-500 origin-center transform stroke-current hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <div data-collapse="settings" class="flex-grow hidden">
                <div class="flex flex-col justify-center h-full">
                    <div class="flex flex-col flex-wrap space-y-2 text-center md:flex-row md:children:mx-2 md:space-y-0">
                        <a href="/openings/new" class="px-3 py-1 font-medium bg-pink-200 rounded-md hover:bg-pink-300 sm:my-0">Nouvelle ouverture</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="flex flex-col md:p-3 my-2 space-y-2 border shadow-sm bg-pink-50 sm:rounded-md">
        <div class="mx-auto text-xl font-medium"><?= strftime("%B %Y", $calendar["now"]) ?></div>
        <?php /* Desktop view */ ?>
        <div class="flex-row hidden w-full divide-x-2 divide-red-300 md:flex justify-evenly border-2 border-red-300 rounded-md">
            <?php for ($i = date("j", $calendar["start"]); $i <= date("j", $calendar["end"]); $i++) { ?>
                <div class="flex flex-col w-full divide-y-2 divide-red-300">
                    <div class="mx-auto font-medium"><?= strftime("%A %d", strtotime("+".$i- date("j", $calendar["start"]) ." days", $calendar["start"])) ?></div>
                    <div class="relative h-144">
                        <?php if (date("Y-m-d", time()) == date("Y-m-d", strtotime("+" . $i - 1 . " days", strtotime(date("Y-m", $calendar["start"]))))) { ?>
                            <div class="w-full absolute ring-2 ring-red-500 <?= $timeTop[date("G")] ?>"></div>
                        <?php } ?>
                        <?php foreach ($calendar["openings"] as $opening) { ?>
                            <?php /* same day start/end */ ?>
                            <?php if (date("j", strtotime($opening["start"])) == $i && date("j", strtotime($opening["end"])) == $i) { ?>
                                <div calendar-item data-opening-start="<?= date("H:i", strtotime($opening["start"])) ?>" data-opening-end="<?= date("H:i", strtotime($opening["end"])) ?>" data-opening-description="<?= $opening["description"] ?>" data-opening-places="<?= $opening["places"] ?>" class=" opacity-80 hover:opacity-100 w-full overflow-hidden bg-red-300 rounded-md absolute border-l-2 border-r-2 border-transparent bg-clip-padding <?= $timeHeight[date("G", strtotime($opening["end"])) - date("G", strtotime($opening["start"]))] ?> <?= $timeTop[date("G", strtotime($opening["start"]))] ?>">
                                    <div class="px-3 py-2 font-medium"><?= date("G:i", strtotime($opening["start"])) ?> - <?= date("G:i", strtotime($opening["end"])) ?></div>
                                </div>

                            <?php } else if (date("j", strtotime($opening["start"])) == $i && date("j", strtotime($opening["end"])) > $i) { ?>
                                <div calendar-item data-opening-start="<?= date("H:i", strtotime($opening["start"])) ?>" data-opening-end="<?= date("H:i", strtotime($opening["end"])) ?>" data-opening-description="<?= $opening["description"] ?>" data-opening-places="<?= $opening["places"] ?>" class=" opacity-80 hover:opacity-100 w-full overflow-hidden bg-red-300 rounded-md absolute border-l-2 border-r-2 border-transparent bg-clip-padding <?= $timeHeight[24 - date("G", strtotime($opening["start"]))] ?> <?= $timeTop[date("G", strtotime($opening["start"]))] ?>">
                                    <div class="px-3 py-2 font-medium"><?= date("G:i", strtotime($opening["start"])) ?> - <?= date("G:i", strtotime($opening["end"])) ?></div>
                                </div>

                            <?php } else if (date("j", strtotime($opening["start"])) < $i && date("j", strtotime($opening["end"])) == $i && date("G", strtotime($opening["end"])) != 0) { ?>
                                <div calendar-item data-opening-start="<?= date("H:i", strtotime($opening["start"])) ?>" data-opening-end="<?= date("H:i", strtotime($opening["end"])) ?>" data-opening-description="<?= $opening["description"] ?>" data-opening-places="<?= $opening["places"] ?>" class=" opacity-80 hover:opacity-100 w-full overflow-hidden bg-red-300 rounded-md absolute border-l-2 border-r-2 border-transparent bg-clip-padding <?= $timeHeight[date("G", strtotime($opening["end"]))] ?>">
                                    <div class="px-3 py-2 font-medium"><?= date("G:i", strtotime($opening["start"])) ?> - <?= date("G:i", strtotime($opening["end"])) ?></div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php /* Mobile view */ ?>
        <div class="flex flex-col w-full divide-y-2 divide-red-300 md:hidden">
            <?php for ($i = date("j", $calendar["start"]) + 2; $i <= date("j", $calendar["end"]) - 1; $i++) { ?>
                <div class="flex flex-col w-full">
                    <div class="mx-auto font-medium"><?= strftime("%A %d", strtotime("+" . $i - date("j", $calendar["start"]) . " days", $calendar["start"])) ?></div>
                    <div class="relative h-128">
                        <?php if (date("Y-m-d", time()) == date("Y-m-d", strtotime("+" . $i - 1 . " days", strtotime(date("Y-m", $calendar["start"]))))) { ?>
                            <div class="w-full absolute ring-2 ring-red-500 <?= $timeTop[date("G")] ?>"></div>
                        <?php } ?>
                        <?php foreach ($calendar["openings"] as $opening) { ?>
                            <?php /* same day start/end */ ?>
                            <?php if (date("j", strtotime($opening["start"])) == $i && date("j", strtotime($opening["end"])) == $i) { ?>
                                <div calendar-item data-opening-start="<?= date("H:i", strtotime($opening["start"])) ?>" data-opening-end="<?= date("H:i", strtotime($opening["end"])) ?>" data-opening-description="<?= $opening["description"] ?>" data-opening-places="<?= $opening["places"] ?>" class=" opacity-80 hover:opacity-100 w-full overflow-hidden bg-red-300 rounded-md absolute border-l-2 border-r-2 border-transparent bg-clip-padding <?= $timeHeight[date("G", strtotime($opening["end"])) - date("G", strtotime($opening["start"]))] ?> <?= $timeTop[date("G", strtotime($opening["start"]))] ?>">
                                    <div class="px-3 py-2 font-medium"><?= date("G:i", strtotime($opening["start"])) ?> - <?= date("G:i", strtotime($opening["end"])) ?></div>
                                </div>

                            <?php } else if (date("j", strtotime($opening["start"])) == $i && date("j", strtotime($opening["end"])) > $i) { ?>
                                <div calendar-item data-opening-start="<?= date("H:i", strtotime($opening["start"])) ?>" data-opening-end="<?= date("H:i", strtotime($opening["end"])) ?>" data-opening-description="<?= $opening["description"] ?>" data-opening-places="<?= $opening["places"] ?>" class=" opacity-80 hover:opacity-100 w-full overflow-hidden bg-red-300 rounded-md absolute border-l-2 border-r-2 border-transparent bg-clip-padding <?= $timeHeight[24 - date("G", strtotime($opening["start"]))] ?> <?= $timeTop[date("G", strtotime($opening["start"]))] ?>">
                                    <div class="px-3 py-2 font-medium"><?= date("G:i", strtotime($opening["start"])) ?> - <?= date("G:i", strtotime($opening["end"])) ?></div>
                                </div>

                            <?php } else if (date("j", strtotime($opening["start"])) < $i && date("j", strtotime($opening["end"])) == $i && date("G", strtotime($opening["end"])) != 0) { ?>
                                <div calendar-item data-opening-start="<?= date("H:i", strtotime($opening["start"])) ?>" data-opening-end="<?= date("H:i", strtotime($opening["end"])) ?>" data-opening-description="<?= $opening["description"] ?>" data-opening-places="<?= $opening["places"] ?>" class=" opacity-80 hover:opacity-100 w-full overflow-hidden bg-red-300 rounded-md absolute border-l-2 border-r-2 border-transparent bg-clip-padding <?= $timeHeight[date("G", strtotime($opening["end"]))] ?>">
                                    <div class="px-3 py-2 font-medium"><?= date("G:i", strtotime($opening["start"])) ?> - <?= date("G:i", strtotime($opening["end"])) ?></div>
                                </div>

                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
    <?php
    $content = ob_get_clean();

    //Meta tag for nav
    $head = '<meta nav="openings">';

    ob_start();
    ?>
    <?php if ($canManage) { ?>
        <script type="module" src="/view/js/collapse.js"></script>
    <?php } ?>
    <script type="module" src="/view/js/openingCalendar.js"></script>
<?php

    $foot = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $foot);
}
