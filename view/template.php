<?php

/**
 * @brief template view with navbar and footer
 * @param string title of the page
 * @param string content placed in main
 * @param string head placed in header tag
 * @param string foot placed at the end of the body
 * @return void
 */
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
        <link rel="shortcut icon" href="/view/assets/svg/raspberries.svg" type="image/svg">
        <link rel="stylesheet" href="/view/css/style.css">
        <?= $head ?? "" ?>
    </head>

    <body class="min-h-screen flex flex-col justify-between bg-gray-50">
        <header class="bg-pink-300 p-4 text-lg text-gray-700">
            <div class="nav w-full lg:max-w-7xl mx-auto flex justify-between">
                <div class="nav-toggle flex lg:hidden items-center">
                    <button data-toggle="nav-collapse" class="items-center">
                        <svg class="h-8 stroke-current stroke-2" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <a href="/" class="nav-brand flex items-center">
                    <img class="h-6 mr-2" src="/view/assets/svg/raspberries.svg" alt="logo">
                    <h1 class="text-xl">Framboises Mathod</h1>
                </a>
                <div class="nav-desktop hidden lg:flex items-center">
                    <a data-nav="home" href="/home" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Accueil</a>
                    <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Variétés</a>
                    <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Recettes</a>
                    <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Nous trouver</a>
                    <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Ouverture</a>
                    <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400 hover:text-gray-900">Images</a>
                </div>
                <div class="nav-account relative">
                    <button data-dropdown="user-menu" class="button flex items-center">
                        <svg class="h-8 stroke-current stroke-2" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <div data-dropdown-target="user-menu" class="dropdown origin-top-right hidden absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                        <?php if (isset($_SESSION["username"])) { ?>
                            <?php if (@in_array_r("administrator", $_SESSION["roles"])) { ?>
                                <div class="py-2">
                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="/administration/dashboard">dashboard</a>
                                </div>
                            <?php } ?>
                            <div class="py-2">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="/authentication/logout">déconnexion</a>
                            </div>
                        <?php } else { ?>
                            <div class="py-2">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="/authentication/login">connexion</a>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="/authentication/register">inscription</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div data-nav-collapse class="nav-mobile hidden lg:hidden flex-col items-center mt-5">
                <a data-nav="home" href="/home" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400">Accueil</a>
                <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400">Variétés</a>
                <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400">Recettes</a>
                <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400">Nous trouver</a>
                <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400">Ouverture</a>
                <a href="#" class="mx-2 py-1 px-2 rounded-md hover:bg-pink-400">Images</a>
            </div>
        </header>
        <main class="justify-self-start w-full lg:max-w-7xl mx-auto">
            <?= $content ?? "no content" ?>
        </main>
        <footer class="flex justify-center bg-pink-300 p-2">
            <a href="https://www.facebook.com/La-Ferme-aux-Framboises-638949536204971/" class="flex items-center mx-2 p-2 text-red-900 hover:text-white">
                <svg class="h-4 w-auto fill-current mx-1" viewBox="0 0 1000 1000">
                    <path d="M182.594 0c-101.149 0 -182.594 81.445 -182.594 182.594l0 634.813c0 101.149 81.445 182.594 182.594 182.594l344.063 0l0 -390.938l-103.375 0l0 -140.75l103.375 0l0 -120.25c0 -94.475 61.079 -181.219 201.781 -181.219 56.968 0 99.094 5.469 99.094 5.469l-3.313 131.438s-42.963 -.406 -89.844 -.406c-50.739 0 -58.875 23.378 -58.875 62.188l0 102.781l152.75 0l-6.656 140.75l-146.094 0l0 390.938l141.906 0c101.149 0 182.594 -81.445 182.594 -182.594l0 -634.813c0 -101.149 -81.445 -182.594 -182.594 -182.594l-634.813 0z" />
                </svg>
                <span>Facebook</span>
            </a>
            <a href="https://www.instagram.com/la_ferme_aux_framboises/" class="flex items-center mx-2 p-2 text-red-900 hover:text-white">
                <svg class="h-4 w-auto fill-current mx-1" viewBox="0 0 24 24">
                    <path d="M17.3183118,0.0772036939 C18.5358869,0.132773211 19.3775594,0.311686093 20.156489,0.614412318 C20.9357539,0.917263935 21.5259307,1.30117806 22.1124276,1.88767349 C22.6988355,2.47414659 23.0827129,3.06422396 23.3856819,3.84361655 C23.688357,4.62263666 23.8672302,5.46418415 23.9227984,6.68172489 C23.9916356,8.19170553 24,8.72394829 24,11.9999742 C24,15.2760524 23.9916355,15.808302 23.9227954,17.3182896 C23.8672306,18.5358038 23.6883589,19.3773584 23.3855877,20.1566258 C23.0826716,20.9358162 22.6987642,21.5259396 22.1124276,22.1122749 C21.5259871,22.6987804 20.9357958,23.0827198 20.1563742,23.3856323 C19.3772192,23.6883583 18.5357324,23.8672318 17.3183209,23.9227442 C15.8086874,23.9916325 15.2765626,24 12,24 C8.72343739,24 8.19131258,23.9916325 6.68172382,23.9227463 C5.46426077,23.8672314 4.62270711,23.6883498 3.84342369,23.3855738 C3.0641689,23.0827004 2.47399369,22.6987612 1.88762592,22.1123283 C1.30117312,21.525877 0.91721975,20.9357071 0.614318116,20.1563835 C0.311643016,19.3773633 0.132769821,18.5358159 0.0772038909,17.3183251 C0.0083529426,15.8092887 0,15.2774634 0,11.9999742 C0,8.7225328 0.00835296697,8.19071076 0.0772047368,6.68165632 C0.132769821,5.46418415 0.311643016,4.62263666 0.614362729,3.84350174 C0.91719061,3.06430165 1.30113536,2.4741608 1.88757245,1.88772514 C2.47399369,1.30123879 3.0641689,0.917299613 3.84345255,0.614414972 C4.62236201,0.311696581 5.46409415,0.132773979 6.68163888,0.0772035898 C8.19074867,0.00835221992 8.72252573,0 12,0 C15.2774788,0 15.8092594,0.00835235053 17.3183118,0.0772036939 Z M12,2.66666667 C8.75959504,2.66666667 8.26400713,2.67445049 6.80319929,2.74109814 C5.87614637,2.78341009 5.31952221,2.90172878 4.80947575,3.09995521 C4.37397765,3.26922052 4.09725505,3.44924273 3.77324172,3.77329203 C3.44916209,4.09737087 3.26913181,4.37408574 3.09996253,4.80937168 C2.90169965,5.31965737 2.78340891,5.87618164 2.74109927,6.80321713 C2.67445122,8.26397158 2.66666667,8.75960374 2.66666667,11.9999742 C2.66666667,15.2403924 2.67445121,15.7360281 2.74109842,17.1967643 C2.78340891,18.1238184 2.90169965,18.6803426 3.09990404,19.1904778 C3.26914133,19.6259017 3.44919889,19.9026659 3.77329519,20.2267614 C4.09725505,20.5507573 4.37397765,20.7307795 4.80932525,20.8999863 C5.31971515,21.0982887 5.87621193,21.2165784 6.80323907,21.2588497 C8.26460439,21.3255353 8.76051223,21.3333333 12,21.3333333 C15.2394878,21.3333333 15.7353956,21.3255353 17.1968056,21.2588476 C18.123775,21.216579 18.6802056,21.0982995 19.1905083,20.9000309 C19.6260288,20.7307713 19.9027426,20.5507596 20.2267583,20.226708 C20.5507492,19.9027179 20.7308046,19.6259456 20.9000375,19.1906283 C21.0983009,18.6803412 21.2165908,18.1238118 21.2588986,17.196779 C21.3255376,15.7350718 21.3333333,15.2390126 21.3333333,11.9999742 C21.3333333,8.76098665 21.3255376,8.26493375 21.2589016,6.80323567 C21.2165911,5.87618164 21.0983004,5.31965737 20.9001178,4.80957831 C20.7308131,4.37403932 20.550774,4.09729207 20.2267583,3.77324038 C19.9027658,3.44924868 19.6260264,3.26922777 19.1905015,3.09996643 C18.6803988,2.90171817 18.1238378,2.78341062 17.1967608,2.74109868 C15.7359966,2.67445057 15.2404012,2.66666667 12,2.66666667 Z M12,18.2222222 C8.56356156,18.2222222 5.77777778,15.4364384 5.77777778,12 C5.77777778,8.56356156 8.56356156,5.77777778 12,5.77777778 C15.4364384,5.77777778 18.2222222,8.56356156 18.2222222,12 C18.2222222,15.4364384 15.4364384,18.2222222 12,18.2222222 Z M12,15.5555556 C13.9636791,15.5555556 15.5555556,13.9636791 15.5555556,12 C15.5555556,10.0363209 13.9636791,8.44444444 12,8.44444444 C10.0363209,8.44444444 8.44444444,10.0363209 8.44444444,12 C8.44444444,13.9636791 10.0363209,15.5555556 12,15.5555556 Z M18.2222222,7.11111111 C17.4858426,7.11111111 16.8888889,6.51415744 16.8888889,5.77777778 C16.8888889,5.04139811 17.4858426,4.44444444 18.2222222,4.44444444 C18.9586019,4.44444444 19.5555556,5.04139811 19.5555556,5.77777778 C19.5555556,6.51415744 18.9586019,7.11111111 18.2222222,7.11111111 Z" />
                </svg>
                <span>Instagram</span>
            </a>
            <a href="#" class="flex items-center mx-2 p-2 text-red-900 hover:text-white">
                <svg class="h-4 w-auto fill-current mx-1" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <span>076 467 45 41</span>
            </a>
        </footer>
        <?= $foot ?? "" ?>
        <script type="module" src="/view/js/nav.js"></script>
    </body>

    </html>
<?php
}
