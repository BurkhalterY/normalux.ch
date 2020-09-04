<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class unit_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'units';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['users' => ['primary_key' => 'fk_user',
										'model' => 'user_model']];
	protected $has_many = ['words' => ['primary_key' => 'fk_unit',
									   'model' => 'word_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function get_dropdown($arr) {
		$this->order_by('no');
		$units = $this->get_many_by($arr);
		foreach ($units as $unit) {
			$dropdown[$unit->id] = $unit->unit;
		}
		return $dropdown;
	}
}