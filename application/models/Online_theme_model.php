<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class online_theme_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'online_themes';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $has_many = ['online_words_themes' => ['primary_key' => 'fk_theme',
													 'model' => 'online_word_theme_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
}