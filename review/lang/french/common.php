<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */

// Titles
$lang['review.module.title']                            = 'Revue de fichiers';
$lang['review.first.analyse']                           = '<div class="message-helper bgc warning"><ul><li>Aucun fichier n\'a été trouvé dans un contenu du site</li><li>Le module vient d\'être installé.</li></ul>Une analyse doit être effectuée en cliquant sur le bouton ci-dessus.</div>';
$lang['review.cache']                                   = 'Lancer une analyse';
$lang['review.refresh']                                 = 'Relancer une analyse';
$lang['review.new.files']                               = 'Des nouveaux fichiers sont présents.';
$lang['review.no.files.added']                          = 'Aucun nouveau fichier.';
$lang['review.counters.files.status']                   = 'Situation des fichiers';
$lang['review.counters.files.status.gallery']           = 'Situation des fichiers - module Galerie';
$lang['review.description']                             = 'Ce module permet d\'identifier les fichiers en écarts entre le serveur et la base de données.';
$lang['review.counters.title.files.on.server']          = 'Fichiers présents dans le dossier /upload';
$lang['review.counters.title.files.in.upload']          = 'Fichiers présents dans la table upload';
$lang['review.counters.title.files.in.gallery.folder']  = 'Fichiers présents dans le dossier /gallery/pics';
$lang['review.counters.title.files.in.gallery.table']   = 'Fichiers présents dans la table gallery';
$lang['review.counters.title.files.in.content']         = 'Fichiers présents dans un contenu (sans doublons)';
$lang['review.counters.title.all.unused.files']         = 'Tous les fichiers non utilisés';
$lang['review.counters.title.all.errors.lists']         = 'Listes des anomalies';
$lang['review.counters.title.all.errors.lists.gallery'] = 'Listes des anomalies du module Galerie';
$lang['review.counters.used.files.no.server']           = 'Fichiers utilisés mais absents du dossier /upload';
$lang['review.counters.files.no.gallery.folder']        = 'Fichiers utilisés mais absents du dossier /gallery/pics';
$lang['review.counters.files.no.gallery.table']         = 'Fichiers absents de la table gallery mais présents dans le dossier /gallery/pics';
$lang['review.counters.unused.files.users']             = 'Fichiers non utilisés mais présents dans table upload';
$lang['review.counters.orphans.files']                  = 'Fichiers non utilisés et sans lien bdd';
$lang['review.counters.all.errors']                     = 'Total de toutes les anomalies';
$lang['review.no.gallery']                              = 'Le module Galerie est présent mais n\'est pas installé ou activé';
$lang['review.missing']                                 = 'Absent';

// lists 
$lang['review.preview']                = 'Prévisualisation';
$lang['review.file.path']              = 'Nom du fichier';
$lang['review.file.module.source']     = 'Module source';
$lang['review.file.upload.by']         = 'uploadé par';
$lang['review.file.timestamp']         = 'Uploadé le';
$lang['review.file.size']              = 'Poids';
$lang['review.file.item.link']         = 'Lien vers le document';
$lang['review.file.undetermined.link'] = 'Lien indéterminé';

// Pages
$lang['review.home']                    = ' - Accueil';
$lang['review.inuploadfolder']          = ' sur le serveur';
$lang['review.ingalleryfolder']         = ' dans le dossier Galerie';
$lang['review.ingallerytable']          = ' dans la table Galerie';
$lang['review.galleryusedbutmissing']   = ' dans la table mais absent du dossier Galerie';
$lang['review.galleryunusedbutintable'] = ' dans le dossier mais absent de la table Galerie';
$lang['review.inuploadtable']           = ' dans le dossier upload';
$lang['review.incontenttable']          = ' dans les contenus';
$lang['review.allunused']               = ' non utilisés';
$lang['review.usedbutmissing']          = ' utilisés mais absent du serveur';
$lang['review.unusedbutintable']        = ' non utilisés mais présents dans la table upload';
$lang['review.orphans']                 = ' orphelins';

// helpers
$lang['review.help.all.unused.files'] = 'Tous les fichiers non utilisés dans l\'ensemble des documents du site, avec ou sans liens dans la table upload.';

$lang['review.help.unique.used.files'] = 'Nombre de fichiers uniques utilisés dans l\'ensemble des documents du site.'
    . ' Un même fichier utilisé dans différents documents n\'est compté qu\'une fois.';
?>

