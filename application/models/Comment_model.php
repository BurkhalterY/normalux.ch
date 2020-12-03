<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class comment_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'comments';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['user' => ['primary_key' => 'fk_user',
										'model' => 'user_model'],
							 'drawing' => ['primary_key' => 'fk_drawing',
										   'model' => 'drawing_model']];
	protected $soft_delete = TRUE;
	protected $soft_delete_key = 'deleted';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

}