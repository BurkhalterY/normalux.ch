<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_type_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'users_types';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $has_many = ['users' => ['primary_key' => 'fk_user_type',
									   'model' => 'user_type']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

}