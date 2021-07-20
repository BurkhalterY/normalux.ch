<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bd extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$output['title'] = $this->lang->line('title_bd');
		$this->display_view('bd/index', $output);
	}

	public function fan() {
		$output['title'] = $this->lang->line('title_fan');
		$this->display_view('bd/fan', $output);
	}

	public function pdt() {
		$output['title'] = $this->lang->line('title_pdt');
		$this->display_view('bd/pdt', $output);
	}
}
