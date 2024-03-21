<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class vote_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'votes';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['drawing' => ['primary_key' => 'fk_drawing',
										   'model' => 'drawing_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

}