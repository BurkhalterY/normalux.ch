<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Modo extends MY_Controller {

	protected $access_level = ACCESS_LVL_MODO;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('drawing_model', 'comment_model'));
	}

	public function drawing($id, $deleted=TRUE) {
		$req = array('deleted' => $deleted);
		$this->drawing_model->update($id, $req);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function comment($id, $deleted=TRUE) {
		$req = array('deleted' => $deleted);
		$this->comment_model->update($id, $req);
		redirect($_SERVER['HTTP_REFERER']);
	}

}
