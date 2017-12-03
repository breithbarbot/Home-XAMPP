# Homepage web projects
> Page d'accueil personnalisée listant tous vos projets web

<br>

![Homepage web projects](.sources/homepage-web-projects.png "Homepage web projects")

Ce projet utilise :
* [Bootstrap](http://getbootstrap.com)
* [Modernizr](https://modernizr.com)
* [jQuery](http://jquery.com)
* [Screen](https://github.com/microweber/screen)

<br>

## Usage Instructions

1. `composer install`

2. Placer toute la structure des fichiers/dossiers dans le répertoire `htdocs` (Remplacez-les si nécessaire).

3. Créer/Importer vos projets dans le dossier `/projects`.

4. Un fichier de configuration `/projects/YOUR_PROJECT/.sources/config.ini` peut être construit pour chaque projet (FACULTATIF).

```ini
;Project     :  The project name
;Created at  :  YYYY/MM/DD
;Author      :  Author name

[infos_base]
title = "The project name"

description = "Project description..."

URLDEV = "http://dev.website.com"

URLPROD = "http://website.com"

URLDB = "http://localhost/phpmyadmin/index.php?db=dbname"

thumbnail = "http://website.com/about"
```

5. Pour ajouter une image personnalisée à chaque projet, il faut créer une image (en 400px x 250px) et la placer dans le dossier `/projects/YOUR_PROJECT/.sources/` et la nommer `picture.jpg` au format **.jpg** (FACULTATIF).

<br>

## Version

Homepage web projects 2.1
- New design
- New features
- Mobile compatibility / responsive
- Thumbnail website

<br>
 
## License

[MIT License](LICENSE)
