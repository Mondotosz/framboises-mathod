<?php

function viewForbidden()
{
    $title = "lost";

    ob_start();
?>
    forbidden
<?php
    $content = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content);
}
