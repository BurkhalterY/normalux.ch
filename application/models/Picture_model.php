<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class picture_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'pictures';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $has_many = ['drawings' => ['primary_key' => 'fk_picture',
										  'model' => 'drawing_model']];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function get_dropdown(){
		//$this->db->order_by('category');
		$this->db->order_by('title');
		$pictures = $this->get_all();
		$dropdown = array();
		$previous_category = "";
		foreach ($pictures as $picture) {
			if($previous_category != $picture->category){
				$previous_category = $picture->category;
			}
			$dropdown[$picture->id] = $picture->title;
		}
		return $dropdown;
	}

}