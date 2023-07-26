<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2023 06 20
 * @since       PHPBoost 6.0 - 2022 01 10
 */
// Titles
$lang['review.module.title'] = 'Files review';

$lang['review.run.scan']       = 'Run scan';
$lang['review.restart.scan']   = 'Restart scan';
$lang['review.folders.configured.for.scanning'] = 'View folders configured for scanning';
$lang['review.first.scan'] = '
    <div class="message-helper bgc warning">
        No analysis has been performed yet.<br />
        Click on the button above.
    </div>
';
$lang['review.no.scan.available']   = '
        Files analysis is not available.<br />
        Add folders to scan in the <a href="' . ReviewUrlBuilder::configuration()->rel() . '">module configuration</a>
';

// Configuration
$lang['review.set.folders.list'] = 'Liste des dossiers à scanner';
$lang['review.set.folders.list.clue'] = '
    Target files are files whose extension is allowed in the <a href="' . AdminFilesUrlBuilder::configuration()->rel() . '">file setup</a>. <br />
    Folders appear automatically when they contain target files. <br />
    Some folders have been disabled : install | kernel | update.
';

// Upload counters
$lang['review.files.status']                 = 'file status';
$lang['review.files.status.upload']          = 'Files status - upload folder';
$lang['review.upload.folder.files']          = 'Files present in /upload folder';
$lang['review.upload.table.files']           = 'Files present in the upload table';
$lang['review.content.files']                = 'Files present in a content (without duplicates)';
$lang['review.anomalies.lists']              = 'Anomalies lists';
$lang['review.anomalies.lists.upload']       = 'Upload folder anomalies lists';
$lang['review.missing.used.files']           = 'Files used but missing from the server (404 error)';
$lang['review.upload.folder.unsued.files']   = 'All unused files';
$lang['review.upload.table.unsued.files']    = 'Unused files (present in upload table)';
$lang['review.orphans.files']                = 'Orphan files (unused and without bdd link)';
$lang['review.total.anomalies']              = 'Total of all anomalies';

// Gallery counters
$lang['review.files.status.gallery']               = 'file status - Gallery module';
$lang['review.files.in.gallery.folder']            = 'Files present in /gallery/pics folder';
$lang['review.files.in.gallery.table']             = 'Files present in the gallery table';
$lang['review.anomalies.lists.gallery']            = 'Gallery Module Anomalies Lists';
$lang['review.counters.files.no.gallery.folder']   = 'Files used in the Gallery but missing from the server (folder /gallery/pics)';
$lang['review.counters.files.no.gallery.table']    = 'Files missing from the gallery table but present on the server (folder /gallery/pics)';
$lang['review.no.gallery']                         = 'The Gallery module is present but not installed or activated';

// lists 
$lang['review.preview']                  = 'Preview';
$lang['review.file.path']                = 'File name';
$lang['review.file.module.source']       = 'source module';
$lang['review.file.upload.by']           = 'uploaded by';
$lang['review.file.timestamp']           = 'Date uploaded';
$lang['review.file.size']                = 'weight';
$lang['review.file.item.link']           = 'Link to document';
$lang['review.file.undetermined.link']   = 'undetermined link';
$lang['review.scanned.folders.list']     = 'Folders configured for scanning';

// Pages
$lang['review.home']                    = '';
$lang['review.inuploadfolder']          = 'Files in the upload folder';
$lang['review.ingalleryfolder']         = 'Files in the Gallery folder';
$lang['review.ingallerytable']          = 'Files in the Gallery table';
$lang['review.galleryusedbutmissing']   = 'Files in the Gallery table but missing from Gallery folder';
$lang['review.galleryunusedbutintable'] = 'Files in the Gallery folder but missing from Gallery table';
$lang['review.inuploadtable']           = 'Files in the upload table';
$lang['review.incontenttable']          = 'Files in content';
$lang['review.allunused']               = 'Not used files';
$lang['review.usedbutmissing']          = 'Used files but missing from server';
$lang['review.unusedbutintable']        = 'Not files used but setted in upload table';
$lang['review.orphans']                 = 'Orphans files';

// helpers
$lang['review.help.all.unused.files'] = 'All unused files in all site documents, with or without links in the upload table.';

$lang['review.help.unique.used.files'] = '
    Number of unique files used in all site documents
    <br />The same file used in different documents is counted only once.
';
?>