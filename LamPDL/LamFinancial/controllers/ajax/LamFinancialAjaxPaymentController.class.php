<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class LamFinancialAjaxPaymentController extends DefaultModuleController
{

    public function execute(HTTPRequestCustom $request)
    {
        $id = $request->get_int('id', 0);
        $amount_paid = $request->get_int('amount_paid', 0);
        LamFinancialService::payment_validation($id, $amount_paid);
        return new JSONResponse(array('msg' => $this->lang['lamfinancial.payment.validation.message']));
    }

}
?>