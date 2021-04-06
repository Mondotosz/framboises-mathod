<?php

/**
 * @brief recipe view
 * @return void
 */
function viewRecipe($recipe)
{
    $title = $recipe["name"];

    ob_start();
?>
    <?= preg_replace("/\n/","<br>", print_r($recipe,true)) ?>
<?php
    $content = ob_get_clean();

    //Meta tag for nav
    $head = '<meta nav="recipes">';

    require_once "view/template.php";
    viewTemplate($title, $content, $head);
}
