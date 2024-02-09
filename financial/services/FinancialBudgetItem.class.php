<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialBudgetItem
{
	private $id;
	private $domain;
	private $name;
	private $description;
	private $fiscal_year;
	private $annual_amount;
	private $max_amount;
	private $amount;
	private $quantity;
	private $temp_quantity;
	private $real_quantity;
	private $use_dl;

	public function set_id($id)
	{
		$this->id = $id;
	}

	public function get_id()
	{
		return $this->id;
	}

	public function set_domain($domain)
	{
		$this->domain = $domain;
	}

	public function get_domain()
	{
		return $this->domain;
	}

	public function set_name($name)
	{
		$this->name = $name;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_description()
	{
		return $this->description;
	}

	public function set_description($description)
	{
		$this->description = $description;
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

	public function get_amount()
	{
		return $this->amount;
	}

	public function set_amount($amount)
	{
		$this->amount = $amount;
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
			'id'            => $this->get_id(),
			'domain'        => $this->get_domain(),
			'name'          => $this->get_name(),
			'description'   => $this->get_description(),
			'fiscal_year'   => $this->get_fiscal_year(),
			'annual_amount' => $this->get_annual_amount(),
			'max_amount'    => $this->get_max_amount(),
			'amount'        => $this->get_amount(),
			'quantity'      => $this->get_quantity(),
			'temp_quantity' => $this->get_temp_quantity(),
			'real_quantity' => $this->get_real_quantity(),
			'use_dl'        => $this->get_use_dl()
		);
	}

	public function set_properties(array $properties)
	{
		$this->id            = $properties['id'];
		$this->domain        = $properties['domain'];
		$this->name          = $properties['name'];
		$this->description   = $properties['description'];
		$this->fiscal_year   = $properties['fiscal_year'];
		$this->annual_amount = $properties['annual_amount'];
		$this->max_amount    = $properties['max_amount'];
		$this->amount        = $properties['amount'];
		$this->quantity      = $properties['quantity'];
		$this->temp_quantity = $properties['temp_quantity'];
		$this->real_quantity = $properties['real_quantity'];
		$this->use_dl        = $properties['use_dl'];
	}
}
?>
