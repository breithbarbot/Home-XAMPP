<!DOCTYPE html>
<!-- ========================================================================================
 *
 * ______          _ _   _     _                _           _
 * | ___ \        (_) | | |   | |              | |         | |
 * | |_/ /_ __ ___ _| |_| |__ | |__   __ _ _ __| |__   ___ | |_   _ __   __ _ _ __ ___   ___
 * | ___ \ '__/ _ \ | __| '_ \| '_ \ / _` | '__| '_ \ / _ \| __| | '_ \ / _` | '_ ` _ \ / _ \
 * | |_/ / | |  __/ | |_| | | | |_) | (_| | |  | |_) | (_) | |_ _| | | | (_| | | | | | |  __/
 * \____/|_|  \___|_|\__|_| |_|_.__/ \__,_|_|  |_.__/ \___/ \__(_)_| |_|\__,_|_| |_| |_|\___|
 *
 *
 * /!\  Breithbarbot.name  /!\   |   Created by Breith Barbot   |   Tous droits réservés.
 *
 * ====================================================================================== -->
<?php
//affichage du phpinfo
if (isset($_GET['phpinfo'])) {
    phpinfo();
    exit();
}

// Variables globales
$name_main_folder = "./www/";
$files_exclude = array(
    ".",
    "..",
    "index.php"
);

$html = "";
if ($dossier = opendir($name_main_folder)) {
    $i = 0;
    while (false !== ($fichier = readdir($dossier))) {
        if (!in_array($fichier, $files_exclude) && is_dir($name_main_folder . $fichier)) {
            $html .= (!($i % 3)) ? '<div class="row">' . PHP_EOL : '';

            $picture = (is_file($name_main_folder . $fichier . "/.sources/picture.png")) ? $name_main_folder . $fichier . "/.sources/picture.png" : "assets/img/creation.png";

            if (is_file($name_main_folder . $fichier . "/.sources/config.ini")) {
                $ini_array = parse_ini_file($name_main_folder . $fichier . "/.sources/config.ini", true);
                $title = $ini_array['infos_base']['title'];
                $url = (!empty($ini_array['infos_base']['URL'])) ? $ini_array['infos_base']['URL'] : $name_main_folder . $fichier;
                $additional_URL = $ini_array['infos_base']['additional_URL'];
            } else {
                $url = $name_main_folder . $fichier;
                $title = $fichier;
                $additional_URL = "";
            }

            $html .= '<div class="col-sm-4"><a href="' . $url . $additional_URL . '" class="box"> <img src="' . $picture . '" alt="' . $fichier . '"> <h3>' . $title . '</h3> </a></div>' . PHP_EOL;

            $html .= (!(($i + 1) % 3)) ? '</div>' . PHP_EOL : '';

            $i++;
        }
    }
    closedir($dossier);
} else {
    $html .= '<h3 class="text-center">Le dossier principale n\'a pas pu être ouvert</h3>';
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Breith Barbot - Accueil des projets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <link rel="icon" type="image/png" href="favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" rel="stylesheet" type="text/css">
    <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="col-sm-12">
        <header class="text-center">
            <h1>
                <span class="highlight">Page</span> d'accueil des projets
                <small>(Breith Barbot)</small>
            </h1>
        </header>
        <div class="text-center">
            <hr/>
            <p><a target="_blank" href="?phpinfo=1">phpinfo()</a></p>
            <p>La version actuelle de <a title="Documentation PHP" target="_blank" href="https://php.net/manual/fr/">PHP</a> : <strong><?php echo phpversion(); ?></strong></p>
            <p>La version actuelle d'apache : <strong><?php echo apache_get_version(); ?></strong></p>
            <hr/>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3"><a href="phpmyadmin/" class="box"> <img src="assets/img/phpmyadmin.png" alt="phpmyadmin"><h3>phpMyAdmin</h3></a></div>
                <!--<div class="col-sm-6"><a href="http://breithbarbot.name" target="_blank" class="box"><img src="/www/breithbarbot.name/.sources/picture.png" alt="breithbarbot.name"><h3>Breith Barbot</h3></a></div>-->
            </div>
            <hr/>
            <p>Il y a <strong><?php echo number_format($i); ?></strong> projet<?php echo ($i > 1) ? 's' : ''; ?></p>
            <br/>
            <?php echo $html; ?>
        </div>
        <br/>
    </div>
</div>
<script src="assets/js/jquery-2.1.1.min.js"></script>
<script src="assets/js/smooth-scroll.js"></script>
</body>
</html>
