<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialBudgetItem
{
    private $id;
    private $budget_domain;
    private $budget_type;
    private $budget_description;
    private $fiscal_year;
    private $annual_amount;
    private $real_amount;
    private $temp_amount;
    private $unit_amount;
    private $max_amount;
    private $quantity;
    private $temp_quantity;
    private $real_quantity;
    private $use_dl;
    private $bill_needed;

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_budget_domain($budget_domain)
    {
        $this->budget_domain = $budget_domain;
    }

    public function get_budget_domain()
    {
        return $this->budget_domain;
    }

    public function set_budget_type($budget_type)
    {
        $this->budget_type = $budget_type;
    }

    public function get_budget_type()
    {
        return $this->budget_type;
    }

    public function get_budget_description()
    {
        return $this->budget_description;
    }

    public function set_budget_description($budget_description)
    {
        $this->budget_description = $budget_description;
    }

    public function get_fiscal_year()
    {
        return $this->fiscal_year;
    }

    public function set_fiscal_year($fiscal_year)
    {
        $this->fiscal_year = $fiscal_year;
    }

    public function get_annual_amount()
    {
        return $this->annual_amount;
    }

    public function set_annual_amount($annual_amount)
    {
        $this->annual_amount = $annual_amount;
    }

    public function get_real_amount()
    {
        return $this->real_amount;
    }

    public function set_real_amount($real_amount)
    {
        $this->real_amount = $real_amount;
    }

    public function get_temp_amount()
    {
        return $this->temp_amount;
    }

    public function set_temp_amount($temp_amount)
    {
        $this->temp_amount = $temp_amount;
    }

    public function get_unit_amount()
    {
        return $this->unit_amount;
    }

    public function set_unit_amount($unit_amount)
    {
        $this->unit_amount = $unit_amount;
    }

    public function get_max_amount()
    {
        return $this->max_amount;
    }

    public function set_max_amount($max_amount)
    {
        $this->max_amount = $max_amount;
    }

    public function set_quantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function get_quantity()
    {
        return $this->quantity;
    }

    public function set_temp_quantity($temp_quantity)
    {
        $this->temp_quantity = $temp_quantity;
    }

    public function get_temp_quantity()
    {
        return $this->temp_quantity;
    }

    public function set_real_quantity($real_quantity)
    {
        $this->real_quantity = $real_quantity;
    }

    public function get_real_quantity()
    {
        return $this->real_quantity;
    }

    public function set_use_dl($use_dl)
    {
        $this->use_dl = $use_dl;
    }

    public function get_use_dl()
    {
        return $this->use_dl;
    }

    public function set_bill_needed($bill_needed)
    {
        $this->bill_needed = $bill_needed;
    }

    public function get_bill_needed()
    {
        return $this->bill_needed;
    }

    public function is_authorized_to_add()
    {
        return FinancialAuthorizationsService::check_authorizations()->write();
    }

    public function is_authorized_to_edit()
    {
        return FinancialAuthorizationsService::check_authorizations()->moderation();
    }

    public function is_authorized_to_delete()
    {
        return FinancialAuthorizationsService::check_authorizations()->moderation();
    }

    public function get_budget_url()
    {
        return FinancialUrlBuilder::home()->rel();
    }

    public function get_properties()
    {
        return array(
            'id'                 => $this->get_id(),
            'budget_domain'      => $this->get_budget_domain(),
            'budget_type'        => $this->get_budget_type(),
            'budget_description' => $this->get_budget_description(),
            'fiscal_year'        => $this->get_fiscal_year(),
            'annual_amount'      => $this->get_annual_amount(),
            'real_amount'        => $this->get_real_amount(),
            'temp_amount'        => $this->get_temp_amount(),
            'unit_amount'        => $this->get_unit_amount(),
            'max_amount'         => $this->get_max_amount(),
            'quantity'           => $this->get_quantity(),
            'temp_quantity'      => $this->get_temp_quantity(),
            'real_quantity'      => $this->get_real_quantity(),
            'use_dl'             => $this->get_use_dl(),
            'bill_needed'        => $this->get_bill_needed()
        );
    }

    public function set_properties(array $properties)
    {
        $this->id = $properties['id'];
        $this->budget_domain = $properties['budget_domain'];
        $this->budget_type = $properties['budget_type'];
        $this->budget_description = $properties['budget_description'];
        $this->fiscal_year = $properties['fiscal_year'];
        $this->annual_amount = $properties['annual_amount'];
        $this->real_amount = $properties['real_amount'];
        $this->temp_amount = $properties['temp_amount'];
        $this->unit_amount = $properties['unit_amount'];
        $this->max_amount = $properties['max_amount'];
        $this->quantity = $properties['quantity'];
        $this->temp_quantity = $properties['temp_quantity'];
        $this->real_quantity = $properties['real_quantity'];
        $this->use_dl = $properties['use_dl'];
        $this->bill_needed = $properties['bill_needed'];
    }
}
?>
