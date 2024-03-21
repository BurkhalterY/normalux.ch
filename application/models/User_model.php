<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends MY_Model
{
	/* SET MY_Model VARIABLES */
	protected $_table = 'users';
	protected $primary_key = 'id';
	protected $protected_attributes = ['id'];
	protected $belongs_to = ['profile_picture' => ['primary_key' => 'fk_profile_picture',
												   'model' => 'drawing_model'],
							 'user_type' => ['primary_key' => 'fk_user_type',
											 'model' => 'user_type_model']];
	protected $has_many = ['drawings' => ['primary_key' => 'fk_user',
										  'model' => 'drawing_model'],
						   'comments' => ['primary_key' => 'fk_user',
										  'model' => 'comment_model'],
						   'units' => ['primary_key' => 'fk_user',
									   'model' => 'unit_model']];
	protected $soft_delete = TRUE;
	protected $soft_delete_key = 'inactive';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Check pseudo and password for login
	 *
	 * @access public
	 * @param $pseudo
	 * @param $password
	 * @return bool true on success, false on failure
	 */
	public function check_password($pseudo, $password)
	{
		$user = $this->get_by('pseudo', $pseudo);
		if (!is_null($user) && password_verify($password, $user->password)) {
			return true;
		}else{
			return false;
		}
	}

}