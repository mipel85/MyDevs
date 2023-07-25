<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */

// Titles
$lang['review.module.title'] = 'Revue de fichiers';

$lang['review.run.scan']     = 'Lancer une analyse';
$lang['review.restart.scan'] = 'Relancer une analyse';
$lang['review.folders.configured.for.scanning'] = 'Voir les dossiers configurés pour l\'analyse';
$lang['review.first.scan']   = '
    <div class="message-helper bgc warning">
        Aucune analyse n\'a encore été effectuée.<br />
        Cliquer sur le bouton ci-dessus.
    </div>
';
$lang['review.no.scan.available']   = '
        Aucune analyse ne peut être effectuée.<br />
        Ajouter des dossier à scanner dans la <a href="' . ReviewUrlBuilder::configuration()->rel() . '">configuration du module</a>
';

// Configuration
$lang['review.set.folders.list']      = 'Liste des dossiers à scanner';
$lang['review.set.folders.list.clue'] = '
    Les fichiers cible sont des fichiers dont l\'extension est autorisée dans la <a href="' . AdminFilesUrlBuilder::configuration()->rel() . '">configuration des fichiers</a>. <br />
    Les dossiers apparaissent automatiquement dès lors qu\'ils contiennent des fichiers cible. <br />
    Certains dossiers ont été désactivés : install | kernel | update.
';

// Upload Counters
$lang['review.files.status']               = 'Situation des fichiers';
$lang['review.upload.folder.files']        = 'Fichiers présents dans le dossier /upload';
$lang['review.upload.table.files']         = 'Fichiers présents dans la table upload';
$lang['review.content.files']              = 'Fichiers présents dans un contenu (sans doublons)';
$lang['review.anomalies.lists']            = 'Listes des anomalies';
$lang['review.missing.used.files']         = 'Fichiers utilisés mais absents du dossier /upload (404)';
$lang['review.upload.folder.unsued.files'] = 'Fichiers non utilisés mais présents dans le dossier /upload';
$lang['review.upload.table.unsued.files']  = 'Fichiers non utilisés mais présents dans table upload';
$lang['review.orphans.files']              = 'Fichiers non utilisés et absent de la table upload (orphelins)';
$lang['review.total.anomalies']            = 'Total de toutes les anomalies';

// Gallery counters
$lang['review.files.status.gallery']             = 'Situation des fichiers - module Galerie';
$lang['review.files.in.gallery.folder']          = 'Fichiers présents dans le dossier /gallery/pics';
$lang['review.files.in.gallery.table']           = 'Fichiers présents dans la table gallery';
$lang['review.anomalies.lists.gallery']          = 'Listes des anomalies du module Galerie';
$lang['review.counters.files.no.gallery.folder'] = 'Fichiers utilisés mais absents du dossier /gallery/pics';
$lang['review.counters.files.no.gallery.table']  = 'Fichiers absents de la table gallery mais présents dans le dossier /gallery/pics';
$lang['review.no.gallery']                       = 'Le module Galerie est présent mais n\'est pas installé ou activé';

// lists 
$lang['review.preview']                = 'Prévisualisation';
$lang['review.file.path']              = 'Nom du fichier';
$lang['review.file.module.source']     = 'Module source';
$lang['review.file.upload.by']         = 'uploadé par';
$lang['review.file.timestamp']         = 'Uploadé le';
$lang['review.file.size']              = 'Poids';
$lang['review.file.item.link']         = 'Lien vers le document';
$lang['review.file.undetermined.link'] = 'Lien indéterminé';

// Pages titles
$lang['review.home']                    = '';
$lang['review.admin']                   = '';
$lang['review.inuploadfolder']          = 'Fichiers dans le dossier upload ';
$lang['review.ingalleryfolder']         = 'Fichiers dans le dossier Galerie ';
$lang['review.ingallerytable']          = 'Fichiers dans la table Galerie ';
$lang['review.galleryusedbutmissing']   = 'Fichiers dans la table mais absent du dossier Galerie ';
$lang['review.galleryunusedbutintable'] = 'Fichiers dans le dossier mais absent de la table Galerie ';
$lang['review.inuploadtable']           = 'Fichiers dans la table upload ';
$lang['review.incontenttable']          = 'Fichiers dans les contenus ';
$lang['review.allunused']               = 'Fichiers non utilisés ';
$lang['review.usedbutmissing']          = 'Fichiers utilisés mais absent du dossier upload ';
$lang['review.unusedbutintable']        = 'Fichiers non utilisés mais présents dans la table upload ';
$lang['review.orphans']                 = 'Fichiers orphelins ';

// helpers
$lang['review.help.all.unused.files'] = 'Tous les fichiers non utilisés dans l\'ensemble des documents du site, avec ou sans liens dans la table upload.';

$lang['review.help.unique.used.files'] = '
    Nombre de fichiers uniques utilisés dans l\'ensemble des documents du site.
    <br />Un même fichier utilisé dans différents documents n\'est compté qu\'une fois.
';
?>

