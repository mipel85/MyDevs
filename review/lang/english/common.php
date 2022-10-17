<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
// Titles
$lang['review.module.title']                            = 'Files review';
$lang['review.counters.files.status']                   = 'file status';
$lang['review.counters.files.status.gallery']           = 'file status - Gallery module';
$lang['review.description']                             = 'This module makes it possible to identify the files in deviations between the server and the database.';
$lang['review.counters.title.files.on.server']          = 'Files present on the server (folder /upload)';
$lang['review.counters.title.files.in.gallery.folder']  = 'Files present on the server (folder /gallery/pics)';
$lang['review.counters.title.files.on.gallery']         = 'Files present in the Gallery (folder /gallery/pics)';
$lang['review.counters.title.files.in.upload']          = 'Files present in the upload table';
$lang['review.counters.title.files.in.gallery.table']   = 'Files present in the gallery table';
$lang['review.counters.title.files.in.content']         = 'Files present in a content (without duplicates)';
$lang['review.counters.title.all.unused.files']         = 'All unused files';
$lang['review.counters.title.all.errors.lists']         = 'Anomaly lists';
$lang['review.counters.title.all.errors.lists.gallery'] = 'Gallery Module Anomaly Lists';
$lang['review.counters.used.files.no.server']           = 'Files used but missing from the server (404 error)';
$lang['review.counters.files.no.gallery.folder']        = 'Files used in the Gallery but missing from the server (folder /gallery/pics)';
$lang['review.counters.files.no.gallery.table']         = 'Files missing from the gallery table but present on the server (folder /gallery/pics)';
$lang['review.counters.unused.files.users']             = 'Unused files (present in upload table)';
$lang['review.counters.orphan.files']                   = 'Orphan files (unused and without bdd link)';
$lang['review.counters.all.errors']                     = 'Total of all anomalies';

// lists 
$lang['review.file.path']              = 'File name';
$lang['review.file.module.source']     = 'source module';
$lang['review.file.upload.by']         = 'uploaded by';
$lang['review.file.timestamp']         = 'Date uploaded';
$lang['review.file.size']              = 'weight';
$lang['review.file.item.link']         = 'Link to document';
$lang['review.file.undetermined.link'] = 'undetermined link';

// Pages
$lang['review.onserver']        = ' on server';
$lang['review.ingalleryfolder'] = ' in the Gallery folder';
$lang['review.ingallerytable']  = ' in the Gallery table';
$lang['review.inupload']        = ' in the upload folder';
$lang['review.incontent']       = ' in content';
$lang['review.allunused']       = ' not used';
$lang['review.usednoserver']    = ' used but missing from server';
$lang['review.unuseduser']      = ' not used but setted in upload table';
$lang['review.orphan']          = ' orphans';

// helpers
$lang['review.help.all.unused.files'] = 'All unused files in all site documents, with or without links in the upload table.';

$lang['review.help.unique.used.files'] = 'Number of unique files used in all site documents.'
    . ' The same file used in different documents is counted only once.';
?>