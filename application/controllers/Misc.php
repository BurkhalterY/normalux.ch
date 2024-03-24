<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Misc extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function contact() {
		$output['title'] = $this->lang->line('contact');
		$this->display_view('misc/contact', $output);
	}

	public function lang($code) {
		$languages = array('en' => 'english', 'fr' => 'french');
		if(array_key_exists($code, $languages))
			$this->session->set_userdata('lang', $languages[$code]);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function error($error = 404) {
		$output['title'] = $this->lang->line('error').' '.$error;
		$output['error'] = $error;
		$this->display_view('misc/error', $output);
	}

}
