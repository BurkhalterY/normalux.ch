<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Modo extends MY_Controller {

	//protected $access_level = ACCESS_LVL_MODO;
	private $positions = [];

	public function __construct() {
		parent::__construct();
		$this->load->model(array('drawing_model', 'comment_model'));
	}

	public function drawing($id) {
		$this->drawing_model->delete($id);
		redirect('gallery');
	}

	public function comment($id) {
		$this->comment_model->delete($id);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function run()
	{
		// Load package path
		$this->load->add_package_path(FCPATH.'vendor/romainrg/ratchet_client');
		$this->load->library('ratchet_client');
		$this->load->remove_package_path(FCPATH.'vendor/romainrg/ratchet_client');

		// Run server
		$this->ratchet_client->set_callback('event', array($this, '_event'));
		$this->ratchet_client->run();
	}

	public function _event($datas = null)
	{
		// Here you can do everyting you want, each time message is received
		switch ($datas->type) {
			case 'position':
				$this->positions[] = $datas->position;
				break;
			case 'sync':
				//
				break;
		}
	}
}
