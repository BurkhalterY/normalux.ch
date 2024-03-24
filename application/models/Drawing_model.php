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

	public function get_mode_name($mode, $short=FALSE)
	{
		if($short) $short = '_short';
		switch ($mode) {
			case NORMAL_MODE:
				return $this->lang->line('normal_mode'.$short);
			case CHAIN_MODE:
				return $this->lang->line('chain_mode'.$short);
			case ROTATION_MODE:
				return $this->lang->line('rotation_mode'.$short);
			case PIXEL_ART_MODE:
				return $this->lang->line('pixel_art_mode'.$short);
			case BLINDED_MODE:
				return $this->lang->line('blind_mode'.$short);
			case INFINITY_MODE:
				return $this->lang->line('unlimited_mode'.$short);
			default:
				return $this->lang->line('unknown_mode'.$short); // Should never happen
		}
	}
}