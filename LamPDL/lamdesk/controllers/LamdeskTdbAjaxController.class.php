<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      mipel <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 22
 * @since       PHPBoost 6.0 - 2024 12 22
 */
class LamdeskTdbAjaxController extends AbstractController
{
    public function execute(HTTPRequestCustom $request)
    {
        $param = $request->get_value('param');
        $dept = substr($param, -2);

        if (str_contains($param, 'ffam'))
        {
            $liste_ffam = LamdeskService::get_clubs_by_dept($dept);
            return new JSONResponse(array('liste_ffam' => $liste_ffam));
        } else
        {
            $liste_site = LamdeskService::get_registred_clubs_by_dept($dept);
            return new JSONResponse(array('liste_site' => $liste_site));
        }
    }
}
?>
