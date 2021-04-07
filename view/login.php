<?php

/**
 * @brief login view
 * @return void
 */
function viewLogin()
{
    $title = "login";

    ob_start();
?>
    <div class="container p-5 mx-auto border border-gray-200 rounded-md shadow">
        <form class="grid grid-cols-1 gap-4" action="/authentication/login" method="post">
            <label for="iptUsername">Nom d'utilisateur</label>
            <input type="text" name="username" id="iptUsername" placeholder="Username" required>
            <label for="iptPassword">Mot de passe</label>
            <input type="password" name="password" id="iptPassword" required>
            <button class="px-2 py-3 mx-auto bg-pink-300 rounded-md" type="submit">Connexion</button>
        </form>
    </div>
<?php
    $content = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content);
}
