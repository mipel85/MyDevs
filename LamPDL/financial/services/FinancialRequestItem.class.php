<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialRequestItem
{
	private $id;
	private $budget_id;
//	private $domain;
	private $title;
	private $rewrited_title;
	private $author_user;
	private $sender_name;
	private $sender_email;
	private $lamclubs_id;
	private $event_date;
	private $creation_date;
	private $estimate_url;
	private $invoice_url;
	private $amount_paid;
	private $agreement;
	private $agreement_date;

	const PENDING   = 1;
	const ONGOING   = 2;
	const REJECTED  = 3;
	const ACCEPTED  = 4;

	public function set_id($id)
	{
		$this->id = $id;
	}

	public function get_id()
	{
		return $this->id;
	}

	public function set_budget_id($budget_id)
	{
		$this->budget_id = $budget_id;
	}

	public function get_budget_id()
	{
		return $this->budget_id;
	}
    
//	public function set_domain($domain)
//	{
//		$this->domain = $domain;
//	}
//
//	public function get_domain()
//	{
//		return $this->domain;
//	}

	public function set_title($title)
	{
		$this->title = $title;
	}

	public function get_title()
	{
		return $this->title;
	}

	public function set_rewrited_title($rewrited_title)
	{
		$this->rewrited_title = $rewrited_title;
	}

	public function get_rewrited_title()
	{
		return $this->rewrited_title;
	}

	public function set_author_user(User $author)
	{
		$this->author_user = $author;
	}

	public function get_author_user()
	{
		return $this->author_user;
	}

	public function set_sender_name($sender_name)
	{
		$this->sender_name = $sender_name;
	}

	public function get_sender_name()
	{
		return $this->sender_name;
	}

	public function set_sender_email($sender_email)
	{
		$this->sender_email = $sender_email;
	}

	public function get_sender_email()
	{
		return $this->sender_email;
	}

	public function set_lamclubs_id($lamclubs_id)
	{
		$this->lamclubs_id = $lamclubs_id;
	}

	public function get_lamclubs_id()
	{
		return $this->lamclubs_id;
	}

	public function get_estimate_url()
	{
		if (!$this->estimate_url instanceof Url)
			return new Url('');

		return $this->estimate_url;
	}

	public function set_estimate_url(Url $estimate_url)
	{
		$this->estimate_url = $estimate_url;
	}

	public function get_invoice_url()
	{
		if (!$this->invoice_url instanceof Url)
			return new Url('');

		return $this->invoice_url;
	}

	public function set_invoice_url(Url $invoice_url)
	{
		$this->invoice_url = $invoice_url;
	}

	public function set_event_date(Date $event_date)
	{
		$this->event_date = $event_date;
	}

	public function get_event_date()
	{
		return $this->event_date;
	}

	public function set_creation_date(Date $creation_date)
	{
		$this->creation_date = $creation_date;
	}

	public function get_creation_date()
	{
		return $this->creation_date;
	}

	public function set_amount_paid($amount_paid)
	{
		$this->amount_paid = $amount_paid;
	}

	public function get_amount_paid()
	{
		return $this->amount_paid;
	}

	public function set_agreement_state($agreement)
	{
		$this->agreement = $agreement;
	}

	public function get_agreement_state()
	{
		return $this->agreement;
	}

	public function set_agreement_date(Date $agreement_date)
	{
		$this->agreement_date = $agreement_date;
	}

	public function get_agreement_date()
	{
		return $this->agreement_date;
	}

	public function has_agreement_date()
	{
		return $this->agreement_date !== null && $this->agreement_date > $this->creation_date;
	}

	public function get_status()
	{
		switch ($this->agreement) {
			case self::PENDING:
				return LangLoader::get_message('financial.status.pending', 'common', 'financial');
			break;
			case self::ONGOING:
				return LangLoader::get_message('financial.status.ongoing', 'common', 'financial');
			break;
			case self::REJECTED:
				return LangLoader::get_message('financial.status.rejected', 'common', 'financial');
			break;
			case self::ACCEPTED:
				return LangLoader::get_message('financial.status.accepted', 'common', 'financial');
			break;
		}
	}

	public function is_authorized_to_add()
	{
		return FinancialAuthorizationsService::check_authorizations()->write() || FinancialAuthorizationsService::check_authorizations()->contribution();
	}

	public function is_authorized_to_edit()
	{
		return FinancialAuthorizationsService::check_authorizations()->moderation() || ((FinancialAuthorizationsService::check_authorizations()->write() || (FinancialAuthorizationsService::check_authorizations()->contribution())) && $this->get_author_user()->get_id() == AppContext::get_current_user()->get_id() && AppContext::get_current_user()->check_level(User::MEMBER_LEVEL));
	}

	public function is_authorized_to_delete()
	{
		return FinancialAuthorizationsService::check_authorizations()->moderation() || ((FinancialAuthorizationsService::check_authorizations()->write() || (FinancialAuthorizationsService::check_authorizations()->contribution())) && $this->get_author_user()->get_id() == AppContext::get_current_user()->get_id() && AppContext::get_current_user()->check_level(User::MEMBER_LEVEL));
	}

	public function get_properties()
	{
		return array(
			'id'             => $this->get_id(),
			'budget_id'      => $this->get_budget_id(),
			'title'          => $this->get_title(),
			'rewrited_title' => $this->get_rewrited_title(),
			'author_user_id' => $this->get_author_user()->get_id(),
			'sender_name'    => $this->get_sender_name(),
			'sender_email'   => $this->get_sender_email(),
			'lamclubs_id'    => $this->get_lamclubs_id(),
            'event_date'     => $this->get_event_date()->get_timestamp(),
			'creation_date'  => $this->get_creation_date()->get_timestamp(),
			'estimate_url'   => $this->get_estimate_url()->relative(),
			'invoice_url'    => $this->get_invoice_url()->relative(),
			'amount_paid'    => $this->get_amount_paid(),
			'agreement'      => $this->get_agreement_state(),
			'agreement_date' => $this->get_agreement_date() !== null ? $this->get_agreement_date()->get_timestamp() : 0
		);
	}

	public function set_properties(array $properties)
	{
		$this->id               = $properties['id'];
		$this->budget_id        = $properties['budget_id'];
		$this->title            = $properties['title'];
		$this->rewrited_title   = $properties['rewrited_title'];
		$this->sender_email     = $properties['sender_email'];
		$this->sender_name      = $properties['sender_name'];
		$this->lamclubs_id      = $properties['lamclubs_id'];
        $this->event_date       = new Date($properties['event_date'], Timezone::SERVER_TIMEZONE);
		$this->creation_date    = new Date($properties['creation_date'], Timezone::SERVER_TIMEZONE);
		$this->estimate_url     = new Url($properties['estimate_url']);
		$this->invoice_url      = new Url($properties['invoice_url']);
		$this->amount_paid      = $properties['amount_paid'];
		$this->agreement        = $properties['agreement'];
		$this->agreement_date   = new Date($properties['agreement_date'], Timezone::SERVER_TIMEZONE);

		$user = new User();
		if (!empty($properties['user_id']))
			$user->set_properties($properties);
		else
			$user->init_visitor_user();

		$this->set_author_user($user);
	}

	public function init_default_properties()
	{
        $user = AppContext::get_current_user();
        $this->lamclubs_id = $this->is_authorized_to_add() ? LamclubsService::get_user_club(AppContext::get_current_user()->get_id()) : '';
        $this->author_user = $user;
        $this->sender_name = $user->get_display_name();
		$this->sender_email = $user->get_email();
		$this->event_date = new Date();
		$this->creation_date = new Date();
	}

	public function get_item_url()
	{
		return FinancialUrlBuilder::display_pending_items()->rel();
	}
}
?>
