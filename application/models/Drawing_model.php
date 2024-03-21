<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class drawing_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'drawings';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['picture' => ['primary_key' => 'fk_picture',
										   'model' => 'picture_model']];
	protected $has_many = ['comments' => ['primary_key' => 'fk_drawing',
										  'model' => 'comment_model'],
						   'votes' => ['primary_key' => 'fk_drawing',
										  'model' => 'vote_model']];
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