<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Modo extends MY_Controller {

	protected $access_level = ACCESS_LVL_MODO;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('drawing_model', 'comment_model', 'online_theme_word_model'));
	}

	public function drawing($id) {
		$this->drawing_model->delete($id);
		redirect('gallery');
	}

	public function comment($id) {
		$this->comment_model->delete($id);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function validate() {
		if(isset($_POST['validate'])){
			foreach ($_POST['validate'] as $id => $ma_bite) {
				$this->online_theme_word_model->update($id, ['in_validation' => 0]);
			}
		}
		$output['entries'] = $this->online_theme_word_model->with('word')->with('theme')->get_many_by('in_validation', 1);
		$this->display_view('multi/propose/validate', $output);
	}
}
