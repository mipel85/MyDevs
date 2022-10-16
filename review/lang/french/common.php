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
$lang['review.counters.files.status']                   = 'Situation des fichiers';
$lang['review.counters.files.status.gallery']           = 'Situation des fichiers - module Galerie';
$lang['review.description']                             = 'Ce module permet d\'identifier les fichiers en écarts entre le serveur et la base de données.';
$lang['review.counters.title.files.on.server']          = 'Fichiers présents sur le serveur (dossier /upload)';
$lang['review.counters.title.files.in.gallery.folder']  = 'Fichiers présents sur le serveur (dossier /gallery/pics)';
$lang['review.counters.title.files.on.gallery']         = 'Fichiers présents dans la Galerie (dossier /gallery/pics)';
$lang['review.counters.title.files.in.upload']          = 'Fichiers présents dans la table upload';
$lang['review.counters.title.files.in.gallery.table']   = 'Fichiers présents dans la table gallery';
$lang['review.counters.title.files.in.content']         = 'Fichiers présents dans un contenu (sans doublons)';
$lang['review.counters.title.all.unused.files']         = 'Tous les fichiers non utilisés';
$lang['review.counters.title.all.errors.lists']         = 'Listes des anomalies';
$lang['review.counters.title.all.errors.lists.gallery'] = 'Listes des anomalies du module Galerie';
$lang['review.counters.used.files.no.server']           = 'Fichiers utilisés mais absents du serveur (erreur 404)';
$lang['review.counters.files.no.gallery.folder']        = 'Fichiers utilisés dans la Galerie mais absents du serveur (dossier /gallery/pics)';
$lang['review.counters.files.no.gallery.table']         = 'Fichiers absents de la table gallery mais présents sur le serveur (dossier /gallery/pics)';
$lang['review.counters.unused.files.users']             = 'Fichiers non utilisés (présents dans table upload)';
$lang['review.counters.orphan.files']                   = 'Fichiers orphelins (non utilisés et sans lien bdd)';
$lang['review.counters.all.errors']                     = 'Total de toutes les anomalies';

// lists 
$lang['review.file.path']              = 'Nom du fichier';
$lang['review.file.module.source']     = 'Module source';
$lang['review.file.upload.by']         = 'uploadé par';
$lang['review.file.timestamp']         = 'Uploadé le';
$lang['review.file.size']              = 'Poids';
$lang['review.file.item.link']         = 'Lien vers le document';
$lang['review.file.undetermined.link'] = 'Lien indéterminé';

// helpers
$lang['review.help.all.unused.files'] = 'Tous les fichiers non utilisés dans l\'ensemble des documents du site, avec ou sans liens dans la table upload.';

$lang['review.help.unique.used.files'] = 'Nombre de fichiers uniques utilisés dans l\'ensemble des documents du site.'
    . ' Un même fichier utilisé dans différents documents n\'est compté qu\'une fois.';
?>

