<?php

function viewTemplate($title, $content, $head = null, $foot = null)
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?? "no title" ?></title>
        <?= $head ?? "" ?>
    </head>

    <body>
        <header>

        </header>
        <div class="main">
            <?= $content ?? "no content" ?>
        </div>
        <footer>

        </footer>
        <?= $foot ?? "" ?>
    </body>

    </html>
<?php
}
