<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 02 27
 * @since       PHPBoost 6.0 - 2024 02 25
*/

####################################################
#                    French                        #
####################################################

$lang['planning.module.title'] = 'Planning';

$lang['planning.no.category'] = 'Sans catégorie';

// TreeLinks
$lang['item']  = 'événement';
$lang['items'] = 'événements';

// Titles
$lang['planning.item.add']         = 'Ajouter un événement';
$lang['planning.item.edit']        = 'Modifier un événement';
$lang['planning.item.delete']      = 'Supprimer l\'événement';
$lang['planning.my.items']         = 'Les événements de mon club';
$lang['planning.member.items']     = 'Événements crées par';
$lang['planning.pending.items']    = 'Événements en attente';
$lang['planning.filter.items']     = 'Filtrer les événements';
$lang['planning.items.management'] = 'Gestion des événements';

// Labels
$lang['planning.location']             = 'Adresse de l\'événement';
$lang['planning.cancelled.item']       = 'Cet événement a été annulé';
$lang['planning.start.date']           = 'Date de l\'événement';
$lang['planning.end.date.enabled']     = 'Événement sur plusieurs jours';
$lang['planning.end.date']             = 'Date de fin';
$lang['planning.club.department']      = 'Département';
$lang['planning.club.name']            = 'Nom du Club';
$lang['planning.organized.by']         = 'Organisé par';
$lang['planning.status.published']     = 'Approuvé';
$lang['planning.status.draft']         = 'En attente';
$lang['planning.contact']              = 'Contacter le club';
$lang['planning.contact.phone']        = 'Par téléphone';
$lang['planning.contact.email.form']   = 'Par email';

$lang['planning.contact.author']          = 'Contacter le club';
$lang['planning.item.interest']           = 'À propos de l\'activité : ';
$lang['planning.sender.name']             = 'Mon nom';
$lang['planning.sender.email']            = 'Mon adresse email';
$lang['planning.sender.message']          = 'Mon message';
$lang['planning.message.success.email']   = 'L\'email a bien été envoyé';
$lang['planning.message.error.email']     = 'Une erreur est survenue lors de l\'envoi';

// Form
$lang['planning.activity']            = 'Activité';
$lang['planning.activities']          = 'Activités';
$lang['planning.activity.clue']       = 'Si votre activité n\'est pas répertoriée, laissez sur "Autres activités" et remplissez le champ suivant.';
$lang['planning.activity.other']      = 'Autre activité';
$lang['planning.form.more.infos']     = 'Informations complémentaires <span class="description small text-italic">Optionnel</span>';
$lang['planning.form.phone']          = 'N° de téléphone de contact';
$lang['planning.form.phone.clue']     = '10 chiffres sans espace';
$lang['planning.form.thumbnail']      = 'Affiche / Flyer';
$lang['planning.form.thumbnail.clue'] = 'Fichier image ou pdf';
$lang['planning.form.content']        = 'Descriptif de l\'événement';
$lang['planning.form.cancel']         = 'Annuler l\'événement';
$lang['planning.form.display.map']    = 'Afficher l\'adresse sur une carte';
$lang['planning.club.infos']          = 'Club';
$lang['planning.contact.email']       = 'Email de contact du club';
$lang['planning.contact.email.clue']  = 'N\'est pas affiché directement sur le site';
// Config
$lang['planning.items.per.page.clue'] = 'Pour les pages "Mes événements" et "Événements en attente"';

// SEO
$lang['planning.seo.description.root']        = 'Tous les événements du site :site.';
$lang['planning.seo.description.pending']     = 'Tous les événements en attente.';
$lang['planning.seo.description.member']      = 'Tous les événements de :author.';
$lang['planning.seo.description.events.list'] = 'Liste des événements du site :site.';

// Feed name
$lang['planning.feed.name'] = 'Événement';

// Messages helper
$lang['planning.message.success.add']    = 'L\'événement <b>:title</b> a été ajouté';
$lang['planning.message.success.edit']   = 'L\'événement <b>:title</b> a été modifié';
$lang['planning.message.success.delete'] = 'L\'événement <b>:title</b> a été supprimé';

// Errors
$lang['planning.warnings']             = 'Attention !!';
$lang['planning.warnings.lamclubs']          = 'Le module Lamclubs est manquant, le module planning ne pourra pas fonctionner correctement.';
$lang['planning.warnings.categories']        = 'Il n\'y a aucune catégorie (activité) déclarée, le module planning ne pourra pas fonctionner correctement.';
$lang['planning.error.invalid.date']             = 'La date entrée est invalide';
$lang['planning.error.user.born.field.disabled'] = 'Le champ <b>Date de naissance</b> n\'est pas affiché dans le profil des membres. Veuillez activer l\'affichage du champ dans la <a class="offload" href="' . AdminExtendedFieldsUrlBuilder::fields_list()->rel() . '">Gestion des champs du profil</a> pour permettre aux membres de renseigner leur date de naissance et afficher leur date d\'anniversaire dans le calendrier.';
?>
