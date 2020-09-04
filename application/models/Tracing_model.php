<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tracing_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'tracings';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['word' => ['primary_key' => 'fk_word',
										'model' => 'word_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
}