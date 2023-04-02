<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamAjaxPaymentController extends AbstractController
{

    public function execute(HTTPRequestCustom $request)
    {
        $id = $request->get_int('id', 0);
        $amount_paid = $request->get_int('amount_paid', 0);
        LamService::payment_validation($id, $amount_paid);
        return new JSONResponse(array('msg' => 'Demande archivée !'));
    }

}
?>