<?php
/**
 * @copyright   &copy; 2005-2020 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 5.3 - last update: 2019 11 03
 * @since       PHPBoost 4.1 - 2015 04 13
 * @contributor mipel <mipel@phpboost.com>
 * @contributor Sebastien LARTIGUE <babsolune@phpboost.com>
*/

#####################################################
#                       French                      #
#####################################################

$lang['root_category_description'] = '
	Bienvenue dans le module Articles du site.
	<br /><br />
	Une catégorie et un article ont été créés pour vous montrer comment fonctionne ce module. Voici quelques conseils pour bien débuter sur ce module.
	<br /><br />
	<ul class="formatter-ul">
		<li class="formatter-li"> Pour configurer ou personnaliser l\'accueil de votre module, rendez-vous dans l\'<a href="' . ArticlesUrlBuilder::configuration()->relative() . '">administration du module</a></li>
		<li class="formatter-li"> Pour créer des catégories, <a href="' . CategoriesUrlBuilder::add_category(Category::ROOT_CATEGORY, 'articles')->relative() . '">cliquez ici</a> </li>
		<li class="formatter-li"> Pour ajouter des articles, <a href="' . ArticlesUrlBuilder::add_article()->relative() . '">cliquez ici</a></li>
	</ul>
	<br />Pour en savoir plus, n\'hésitez pas à consulter la documentation du module sur le site de <a href="https://www.phpboost.com">PHPBoost</a>.
';
?>
