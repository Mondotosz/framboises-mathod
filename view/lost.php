<?php

function viewLost()
{
    $title = "lost";

    ob_start();
?>
    lost
<?php
    $content = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content);
}
