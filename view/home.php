<?php

/**
 * @brief homepage view
 * @return void
 */
function viewHome()
{
    $title = "home";

    ob_start();
?>
    home
<?php
    $content = ob_get_clean();

    //Meta tag for nav
    $head = '<meta nav="home">';

    require_once "view/template.php";
    viewTemplate($title, $content, $head);
}
