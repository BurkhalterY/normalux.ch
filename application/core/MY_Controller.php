<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	/**
	 * '*' for all users
	 * '@' for logged in users
	 * '0, 1, 2, 4, 8, ...' for access level (power of 2)
	 */
	protected $access_level = "*";

	public function __construct()
	{
		parent::__construct();

		$this->lang->load('MY_application', $this->session->lang ?? 'english');

		/* Check permission on construct */
		if (!$this->check_permission()) {
			show_error($this->lang->line('msg_err_access_denied'));
		}
	}

	/**
	* Check if user access level matches the required access level.
	* Required level can be the controller's default level or a custom
	* specified level.
	*
	* @param  $required_level : minimum level required to get permission
	* @return bool : true if user level is equal or higher than required level,
	*                false else
	*/
	protected function check_permission($required_level = NULL)
	{
		if (is_null($required_level)) {
			$required_level = $this->access_level;
		}

		if ($required_level == "*") {
			// page is accessible for all users
			return true;
		}
		else {
			// check if user is logged in
			// if not, redirect to login page
			if (!isset($_SESSION['logged_in'])) {
				redirect("user/login");
			}
			// check if page is accessible for all logged in users
			elseif ($required_level == "@") {
				return true;
			}
			// check access level
			elseif ($required_level <= $_SESSION['user_access']) {
				return true;
			}
			// no permission
			else {
				return false;
			}
		}
	}


	/**
	* Display the view, adding header, footer and any other common view part
	*
	* @param  $view_parts : single view or array of view parts to display
	*         $data : data array to send to the view
	*/
	public function display_view($view_parts, $data = NULL, $show_menu = true)
	{
		// If not defined in $data, set page title to empty string
		if (!isset($data['title'])) {
			$data['title'] = '';
		}

		// Display common headers
		$this->load->view('common/header', $data);
		if($show_menu)
			$this->load->view('common/menu');

		if (is_array($view_parts)) {
			// Display multiple view parts defined in $data
			foreach ($view_parts as $view_part) {
				$this->load->view($view_part, $data);
			}
		}
		elseif (is_string($view_parts)) {
			// Display unique view part defined in $data
			$this->load->view($view_parts, $data);
		}

		// Display common footer
		$this->load->view('common/footer');
	}
}
