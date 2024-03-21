<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('user_model', 'drawing_model'));
	}

	public function login() {
		$output['title'] = $this->lang->line('title_login');

		if(isset($_POST['login'])){
			if(empty($_POST['pseudo']) || empty($_POST['password'])){
				$output['message'] = $this->lang->line('message__please_complete_all_fields');
			} else if(!$this->user_model->check_password($_POST['pseudo'], $_POST['password'])){
				$output['message'] = $this->lang->line('message__authentification_error');
			} else {
				$user = $this->user_model->with('user_type')->get_by('pseudo', $_POST['pseudo']);
				$_SESSION['user_id']	= $user->id;
				$_SESSION['username']	= $user->pseudo;
				$_SESSION['user_access']= $user->user_type->level;
				$_SESSION['logged_in']	= true;

				redirect();
			}
		}
		$this->display_view('user/login', $output);
	}

	public function register() {
		redirect('misc/error/403');
		/*
		$output['title'] = $this->lang->line('title_register');

		if(isset($_POST['register'])){
			if(empty($_POST['pseudo']) || empty($_POST['password']) || empty($_POST['passconf'])){
				$output['message'] = $this->lang->line('message__please_complete_all_fields');
			} else if(preg_match('/^[a-zA-Z0-9_-]+$/', $_POST['pseudo']) != 1){
				$output['message'] = $this->lang->line('message__unable_to_use_this_pseudo');
			} else if($this->user_model->count_by('pseudo="'.$_POST['pseudo'].'"') > 0){
				$output['message'] = $this->lang->line('message__pseudo_already_used');
			} else if($_POST['password'] != $_POST['passconf']){
				$output['message'] = $this->lang->line('message__passwords_do_not_match');
			} else {
				$req = array(
					'pseudo' => $_POST['pseudo'],
					'email' => $_POST['email'],
					'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
				);
				$id = $this->user_model->insert($req);

				$_SESSION['user_id']	= $id;
				$_SESSION['username']	= $_POST['pseudo'];
				$_SESSION['user_access']= 2;
				$_SESSION['logged_in']	= true;

				redirect();
			}
		}

		$this->display_view('user/register', $output);
		*/
	}

	public function logout() {
		session_destroy();
		redirect('user/login');
	}

	public function settings() {

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
			$output['title'] = $this->lang->line('title_settings');

			if(isset($_POST['submit'])){
				if(empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])){
					$output['message'] = $this->lang->line('message__please_complete_all_fields');
				} else if($_POST['new_password'] != $_POST['confirm_password']){
					$output['message'] = $this->lang->line('message__passwords_do_not_match');
				} else if(!$this->user_model->check_password($_SESSION['username'], $_POST['old_password'])){
					$output['message'] = $this->lang->line('message__authentification_error');
				} else {
					$output['success'] = true;
					$output['message'] = $this->lang->line('message__password_successfully_changed');
					$req = array('password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT));
					$this->user_model->update($_SESSION['user_id'], $req);
				}
			}

			$this->display_view('user/settings', $output);
		} else {
			redirect('user/login');
		}
	}

}
