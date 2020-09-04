<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class word_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'words';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['unit' => ['primary_key' => 'fk_unit',
										'model' => 'unit_model']];
	protected $has_many = ['tracings' => ['primary_key' => 'fk_word',
										  'model' => 'tracing_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
}