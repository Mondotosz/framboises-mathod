<?php

function viewHome()
{
    $title = "home";

    ob_start();
?>
    home
<?php
    $content = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content);
}
