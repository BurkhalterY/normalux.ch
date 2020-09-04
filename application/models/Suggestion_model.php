<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class suggestion_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'suggestions';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['user' => ['primary_key' => 'fk_user',
										'model' => 'user_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

}