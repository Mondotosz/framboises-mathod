<?php

function viewRegister()
{
    $title = "register";

    ob_start();
?>
    <div class="container mx-auto p-5 border border-gray-200 shadow rounded-md">
        <form class="grid grid-cols-1 gap-4" action="/authentication/register" method="post">
            <label for="iptUsername">Nom d'utilisateur</label>
            <input type="text" name="username" id="iptUsername" placeholder="Username" required>
            <label for="iptEmail">Email</label>
            <input type="email" name="email" id="iptEmail" placeholder="exemple@email.com" required>
            <label for="iptPassword">Mot de passe</label>
            <input type="password" name="password" id="iptPassword" required>
            <label for="iptPasswordCheck">Confirmation du mot de passe</label>
            <input type="password" name="passwordCheck" id="iptPasswordCheck" required>
            <button class="mx-auto py-3 px-2 rounded-md bg-pink-300" type="submit">Inscription</button>
        </form>
    </div>
<?php
    $content = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content);
}
