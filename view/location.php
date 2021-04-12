<?php

/**
 * location view
 * @return void
 */
function viewLocation()
{
    $title = "Nous trouver";

    // Meta tag for nav
    ob_start();
?>
    <meta nav="location">
    <link rel="stylesheet" href="/node_modules/leaflet/dist/leaflet.css">
    <script src="/node_modules/leaflet/dist/leaflet.js"></script>
    <?php
    $head = ob_get_clean();

    // Content
    ob_start();
    ?>
    <div class="flex flex-col justify-center space-y-2">
        <ul class="sm:text-lg p-2 sm:rounded-md bg-pink-50 px-3 py-2 space-y-2 sm:space-y-1">
            <li>Vous pouvez nous contacter sur notre adresse e-mail : <a class="hover:text-red-500 text-red-800 font-medium" href="mailto:roger_anne@vonet.ch">roger_anne@vonet.ch</a></li>
            <li>ou vous abonner a notre page facebook: <a class="hover:text-red-500 text-red-800 font-medium" href="https://www.facebook.com/La-Ferme-aux-Framboises-638949536204971/">la ferme aux framboises</a></li>
            <li>ou nous suivre sur instagram: <a class="hover:text-red-500 text-red-800 font-medium" href="https://www.instagram.com/la_ferme_aux_framboises/">la_ferme_aux_framboises</a></li>
            <li>Un répondeur téléphonique vous tient au courant de nos heures d'ouverture: <a class="hover:text-red-500 text-red-800 font-medium" href="tel:+41764674541">+41 76 467 45 41</a></li>
        </ul>
        <ul class="sm:text-lg px-3 py-2 sm:rounded-md bg-pink-50 space-y-2 sm:space-y-1 flex flex-col justify-center">
            <li> Le champ de Framboises se situe sur la route de Rances, entre deux bâtiments agricoles, chemin en cailloux qui revient contre le village ( Ch Clos Fayoux).</li>
            <li> Derrière notre ferme qui a le panneau Framboises sur sa porte et qui se situe au carrefour "pavé".</li>
            <li> Place de parc à disposition à côté du champs, suivre les indications.</li>
        </ul>
        <div class="h-144 w-full sm:rounded-md" id="map"></div>
    </div>
    </div>
    <?php
    $content = ob_get_clean();

    ob_start();
    ?>

    <script>
        let map = L.map('map', {
            center: [46.76840, 6.56324],
            zoom: 15,
            scrollWheelZoom: true
        })

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            minZoom: 2,
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map)

        // show the scale bar on the lower left corner
        L.control.scale().addTo(map);

        // show a marker on the map
        L.marker({
            lon: 6.56324,
            lat: 46.76840
        }).bindPopup(`entree/parking`).addTo(map);
    </script>
<?php
    $script = ob_get_clean();

    require_once "view/template.php";
    viewTemplate($title, $content, $head, $script);
}
