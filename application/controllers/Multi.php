<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Multi extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->display_view('multi/index');
	}

	public function room($room_code = '') {
		if(isset($_POST['pseudo']) && !empty($_POST['pseudo'])){
			$_SESSION['pseudo'] = htmlspecialchars($_POST['pseudo']);
		}

		if(isset($_POST['room_code'])){
			$_SESSION['room_code'] = $_POST['room_code'];
			redirect('multi/room/'.$_SESSION['room_code']);
		} else if(!empty($room_code)){
			$_SESSION['room_code'] = $room_code;
		}

		if(isset($_SESSION['pseudo']) && !empty($room_code)){
			
			$output['title'] = $this->lang->line('title_draw');
			$this->display_view('multi/room', $output, false);

		} else {
			redirect('multi');
		}
	}

	public function create() {
		if(isset($_POST['pseudo']) && !empty($_POST['pseudo'])){
			$_SESSION['pseudo'] = htmlspecialchars($_POST['pseudo']);
			$room_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0 ,4);
			
			redirect('multi/room/'.$room_code);
		} else {
			redirect('multi');
		}
	}

	public function random() {
		$result = $this->db->query('SELECT * FROM pictures ORDER BY RAND() LIMIT 1')->result_object()[0];
		$array = [
			'url' => base_url('medias/pictures/'.$result->file),
			'title' => $result->title
		];

		header('Content-type: application/json');
		echo json_encode($array);
	}
}
