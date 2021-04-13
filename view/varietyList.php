<?php

/**
 * variety list view
 * @param array $varieties
 * @param string $pagination
 * @param bool $canManage
 * @return void
 */
function viewVarietyList($varieties, $pagination = null, $canManage = false)
{
    $title = "variétés";

    ob_start();
?>
    <div class="flex flex-col justify-between flex-grow py-2">
        <div class="flex flex-col divide-y divide-red-300">
            <?php if ($canManage) { ?>
                <div class="flex flex-row px-3 py-2 space-x-3">
                    <div class="flex flex-col justify-center">
                        <button type="button" class="h-full text-black focus:outline-none hover:text-red-700 focus:text-red-700" data-collapse-control="settings">
                            <svg class="h-8 transition-all duration-500 origin-center transform stroke-current hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    <div data-collapse="settings" class="hidden">
                        <div class="flex flex-col justify-center h-full">
                            <div class="flex flex-row flex-wrap children:mx-2">
                                <a href="/varieties/new" class="px-3 py-1 my-2 font-medium bg-pink-200 rounded-md hover:bg-pink-300 sm:my-0">Nouvelle variété</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php foreach ($varieties as $variety) { ?>
                <div class="flex flex-col py-2">
                    <a href="/varieties/<?= $variety["id"] ?>" class="flex flex-col space-y-3 md:space-y-0 md:flex-row justify-center md:space-x-16 p-3 sm:rounded-md hover:bg-pink-50 hover:shadow">
                        <div class="flex flex-col justify-center  space-y-2">
                            <div class="text-xl font-medium title sm:text-2xl"><?= $variety["name"] ?? "{no title}" ?></div>
                            <div class="whitespace-pre-line"><?= $variety["description" ?? ""] ?></div>
                        </div>
                        <?php if (!empty($variety["images"])) { ?>
                            <img class="object-cover rounded-md shadow max-h-64 " src="<?= $variety["images"][0]["path"] ?>" alt="image de <?= $variety["name"] ?>">
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="flex flex-col items-center justify-center px-2 sm:flex-row">
            <?= $pagination ?? "" ?>
        </div>

    </div>
<?php
    $content = ob_get_clean();

    // Meta tag for nav
    $head = '<meta nav="varieties">';

    // Management dependency
    $foot = $canManage ? '<script type="module" src="/view/js/collapse.js"></script>' : '';

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $foot);
}
