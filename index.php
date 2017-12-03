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
 * /!\  Breithbarbot.name  /!\   |   Created by Breith Barbot   |   All rights reserved.
 *
 * ====================================================================================== -->
<?php
// Include composer
require_once 'vendor/autoload.php';

// Show phpinfo()
if (isset($_GET['phpinfo'])) {
    phpinfo();
    exit();
}

function generateThumbail($url, $fileLocation)
{
    $screenCapture = new \Screen\Capture($url);

    $screenCapture->setWidth(1920);
    $screenCapture->setHeight(1200);
    $screenCapture->setClipWidth(1920);
    $screenCapture->setClipHeight(1200);
    $screenCapture->save($fileLocation);

    return $screenCapture->getImageLocation();
}

// Globales variables
$name_main_folder = './projects/';
$files_exclude = ['.', '..', 'index.php'];
$link_phpMyAdmin = 'phpmyadmin/';
$locale = 'fr';

$html = '';
$i = 0;

// Listing of files
if ($dossier = opendir($name_main_folder)) {
    $html .= '<div class="row">';
    while (false !== ($fichier = readdir($dossier))) {
        if (!in_array($fichier, $files_exclude, true) && is_dir($name_main_folder.$fichier)) {

//            $html .= (!($i % 4)) ? '<div class="row">' : '';

            $picture = is_file($name_main_folder.$fichier.'/.sources/picture.jpg') ? $name_main_folder.$fichier.'/.sources/picture.jpg' : 'assets/img/default.jpg';
            $urldev = $urlprod = $description = $urldb = '';

            if (is_file($name_main_folder.$fichier.'/.sources/config.ini')) {
                $ini_array = parse_ini_file($name_main_folder.$fichier.'/.sources/config.ini', true);
                $title = (!empty($ini_array['infos_base']['title'])) ? $ini_array['infos_base']['title'] : $fichier;
                $urldev = (!empty($ini_array['infos_base']['URLDEV'])) ? $ini_array['infos_base']['URLDEV'] : $name_main_folder.$fichier;
                $urlprod = (!empty($ini_array['infos_base']['URLPROD'])) ? $ini_array['infos_base']['URLPROD'] : '';
                $urldb = (!empty($ini_array['infos_base']['URLDB'])) ? $ini_array['infos_base']['URLDB'] : '';
                $description = (!empty($ini_array['infos_base']['description'])) ? $ini_array['infos_base']['description'] : '';
                // Thumbnail
                if (isset($ini_array['infos_base']['thumbnail']) && !is_file($name_main_folder.$fichier.'/.sources/picture.jpg')) {
                    if (!empty($ini_array['infos_base']['thumbnail']) && @get_headers($ini_array['infos_base']['thumbnail'], 1)) {
                        $picture = generateThumbail($ini_array['infos_base']['thumbnail'], $name_main_folder.$fichier.'/.sources/picture.jpg');
                    } else {
                        $picture = generateThumbail((!empty($urlprod) ? $urlprod : $urldev), $name_main_folder.$fichier.'/.sources/picture.jpg');
                    }
                }
            } else {
                $urldev = $name_main_folder.$fichier;
                $title = $fichier;
            }

            $html .= '<div class="col-sm-3">';
            $html .= '<div class="bb-project-manager" data-title="'.mb_strtolower($title, 'UTF-8').'">';
            $html .= '<div class="bb-project-manager-content">';
            $html .= '<div class="bb-project-manager-content-img">';
            $html .= '<a href="'.$urldev.'" data-href="'.$urldev.'"><img src="'.$picture.'" alt="Thumbnail" class="img-responsive"></a>';
            $html .= '</div>';
            $html .= '<div class="bb-project-manager-content-btn">';
            $html .= '<div class="bb-project-manager-content-alignCenter">';
            $html .= '<div class="bb-project-manager-content-body">';
            $html .= '<a href="'.$urldev.'" class="btn btn-sm btn-primary" rel="nofollow" title="Developement"><span class="glyphicon glyphicon-wrench text-danger" aria-hidden="true"></span> Dev</a>';
            if (!empty($urlprod)) {
                $html .= '<a href="'.$urlprod.'" class="btn btn-sm btn-success" rel="nofollow" title="Production"><span class="glyphicon glyphicon-globe text-success" aria-hidden="true"></span> Prod</a>';
            }
            if (!empty($urldb)) {
                $html .= '<a href="'.$urldb.'" class="btn btn-sm btn-default" rel="nofollow" target="_blank" title="Database"><span class="glyphicon glyphicon-record" aria-hidden="true"></span> DB</a>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="bb-project-manager-info">';
            $html .= '<div class="bb-project-manager-info-title">'.$title.'</div>';
            if (!empty($description)) {
                $points = (strlen(trim($description)) > 39) ? '...' : '';
                $html .= '<div class="bb-project-manager-info-desc" title="'.$description.'">'.trim(mb_substr($description, 0, 39, 'UTF-8')).$points.'</div>';
            } else {
                $html .= '<div class="bb-project-manager-info-desc" title="">&nbsp;</div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

//            $html .= (!(($i + 1) % 4)) ? '</div>' : '';

            $i++;
        }
    }
    $html .= '</div>';
    closedir($dossier);
} else {
    $html .= '<h3 class="text-center">The main folder could not be opened</h3>';
}
?>
<html lang="<?php echo $locale; ?>">
    <head>
        <meta charset="UTF-8">
        <title>Breith Barbot - Home projects</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow">

        <link rel="icon" type="image/png" href="favicon.ico"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" rel="stylesheet" type="text/css">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/main.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="col-sm-12">
                <header class="text-center">
                    <h1>
                        <span class="highlight">Page</span> d'accueil des projets
                    </h1>
                </header>
                <div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4">
                            <ul>
                                <li><img src="assets/img/favicon_php.ico" alt="phpinfo()" width="16" height="16"> <a target="_blank" href="?phpinfo">phpinfo()</a></li>
                                <li><img src="assets/img/favicon_php.ico" alt="PHP" width="16" height="16"> <a title="PHP documentation" target="_blank" href="https://php.net/manual/<?php echo $locale; ?>/">PHP</a> : <strong><?php echo PHP_VERSION; ?></strong></li>
                                <li><img src="assets/img/favicon_mysql.ico" alt="MySQL" width="16" height="16"> <a title="MySQL documentation" target="_blank" href="https://dev.mysql.com/doc/<?php echo $locale; ?>/">MySQL</a> : <strong><?php echo exec('mysql -V'); ?></strong></li>

                                <?php
                                // NGINX
                                if (strpos($_SERVER['SERVER_SOFTWARE'], 'nginx/') !== false) {
                                    echo '<li><img src="assets/img/favicon_nginx.ico" alt="Nginx" width="16" height="16"> <a title="NGINX Wiki’s documentation" target="_blank" href="https://www.nginx.com/resources/wiki/">Nginx</a> : <strong>'.$_SERVER['SERVER_SOFTWARE'].'</strong></li>';
                                }

                                // APACHE
                                if (strpos($_SERVER['SERVER_SOFTWARE'], 'Apache/') !== false) {
                                    echo '<li><img src="assets/img/favicon_apache.ico" alt="Apache" width="16" height="16"> <a title="Apache documentation" target="_blank" href="http://httpd.apache.org/docs/2.4/">Apache</a> : <strong>'.$_SERVER['SERVER_SOFTWARE'].'</strong></li>';
                                }
                                ?>

                                <li><img src="assets/img/favicon_phpmyadmin.ico" alt="phpMyAdmin" width="16" height="16"> <a target="_blank" href="<?php echo $link_phpMyAdmin; ?>">phpMyAdmin</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-9">
                            <input title="Rechercher un projet par son titre" class="form-control" placeholder="Rechercher un projet..." id="search" type="search" autocomplete="off" autofocus>
                        </div>
                    </div>
                    <p class="text-center" id="nbProjet">Il y a <strong><?php echo number_format($i); ?></strong> projet<?php echo ($i > 1) ? 's' : ''; ?></p>
                    <br/>
                    <?php echo $html; ?>
                </div>
            </div>
        </div>
        <script src="assets/js/jquery-3.1.1.slim.min.js"></script>
        <script src="assets/js/smooth-scroll.js"></script>
        <script src="assets/js/modernizr-custom.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>