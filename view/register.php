<?php

/**
 * register view
 * @return void
 */
function viewRegister()
{
    $title = "register";

    ob_start();
?>
    <div class="container p-5 mx-auto border border-gray-200 rounded-md shadow">
        <form class="grid grid-cols-1 gap-4" action="/authentication/register" method="post">
            <label for="iptUsername">Nom d'utilisateur</label>
            <input type="text" name="username" id="iptUsername" placeholder="Username" required>
            <label for="iptEmail">Email</label>
            <input type="email" name="email" id="iptEmail" placeholder="exemple@email.com" required>
            <label for="iptPassword">Mot de passe</label>
            <input type="password" name="password" id="iptPassword" required>
            <label for="iptPasswordCheck">Confirmation du mot de passe</label>
            <input type="password" name="passwordCheck" id="iptPasswordCheck" required>
            <button class="px-2 py-3 mx-auto bg-pink-300 rounded-md" type="submit">Inscription</button>
        </form>
    </div>
<?php
    $content = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content);
}
