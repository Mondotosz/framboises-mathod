<?php

/**
 * homepage view
 * @return void
 */
function viewHome()
{
    $title = "home";

    ob_start();
?>
    <div class="flex flex-row justify-center">
        <div class="flex flex-col space-y-2">
            <div class="text-lg md:text-4xl font-medium text-red-700">En construction!</div>
            <svg class="animate-spin mx-auto h-6 md:h-16 w-6 md:w-16 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
    </div>
    <?php
    $content = ob_get_clean();

    //Meta tag for nav
    ob_start();
    ?>
    <!-- html -->
    <meta nav="home">
    <meta name="keywords" content="framboise mathod accueil petits fruits">
    <meta name="description" content="auto-cueillette de framboise et de petits fruits en juin et juillet">
    <!-- OpenGraph -->
    <meta property="og:description" content="auto-cueillette de framboise et de petits fruits en juin et juillet">
    <meta property="og:title" content="Framboises Mathod - accueil">
    <meta property="og:url" content="http://<?= $_SERVER['HTTP_HOST'] ?>/home">
    <meta property="og:image" itemprop="image" content="http://<?= $_SERVER['HTTP_HOST'] ?>/view/assets/img/framboises.jpg">
    <meta property="og:type" content="website">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="<?= $_SERVER['HTTP_HOST'] ?>">
    <meta property="twitter:url" content="http://<?= $_SERVER['HTTP_HOST'] ?>/">
    <meta name="twitter:title" content="Framboises Mathod - accueil">
    <meta name="twitter:description" content="auto-cueillette de framboise et de petits fruits en juin et juillet">
    <meta name="twitter:image" content="http://<?= $_SERVER['HTTP_HOST'] ?>/view/assets/img/framboises.jpg">
<?php
    $head = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content, $head);
}
