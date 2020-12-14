<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Modo extends MY_Controller {

	protected $access_level = ACCESS_LVL_MODO;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('drawing_model', 'comment_model', 'online_word_model', 'online_theme_model', 'online_theme_word_model'));
	}

	public function drawing($id) {
		$this->drawing_model->delete($id);
		redirect('gallery');
	}

	public function comment($id) {
		$this->comment_model->delete($id);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function validate_word() {
		//TODO
	}
}
