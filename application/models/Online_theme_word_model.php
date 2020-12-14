<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class online_theme_word_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'online_themes_words';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['word' => ['primary_key' => 'fk_word',
										'model' => 'online_word_model'],
							 'theme' => ['primary_key' => 'fk_theme',
										 'model' => 'online_theme_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
}