<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Misc extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function contact() {
		$output['title'] = $this->lang->line('contact');
		$this->display_view('misc/contact', $output);
	}

	public function error($error = 404) {
		$output['title'] = $this->lang->line('error').' '.$error;
		$output['error'] = $error;
		$this->display_view('misc/error', $output);
	}

}
