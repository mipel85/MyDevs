<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2021 12 11
 * @since       PHPBoost 4.1 - 2014 08 21
 * @contributor Sebastien LARTIGUE <babsolune@phpboost.com>
 */

class LamclubsVisitItemController extends AbstractController
{
    private $item;

    public function execute(HTTPRequestCustom $request)
    {
        $id = $request->get_getint('id', 0);

        if (!empty($id))
        {
            try
            {
                $this->item = LamclubsService::get_item($id);
            }catch (RowNotFoundException $e)
            {
                $error_controller = PHPBoostErrors::unexisting_page();
                DispatchManager::redirect($error_controller);
            }
        }

        if ($this->item !== null && !LamclubsAuthorizationsService::check_authorizations()->read())
        {
            $error_controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($error_controller);
        }else if ($this->item !== null)
        {
            AppContext::get_response()->redirect($this->item->get_website_url()->absolute());
        }else
        {
            $error_controller = PHPBoostErrors::unexisting_page();
            DispatchManager::redirect($error_controller);
        }
    }
}
?>
