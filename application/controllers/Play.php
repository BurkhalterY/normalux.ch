<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Play extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('picture_model', 'drawing_model'));
	}

	public function index($mode = 1) {
		unset($_SESSION['picture_id']);
		if($mode == INFINITY_MODE){
			if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
				$output['models'] = $this->picture_model->get_dropdown();
			} else {
				redirect('user/login');
			}
		}
		$output['mode'] = $mode;
		switch ($mode) {
			case NORMAL_MODE:
				$output['title'] = $this->lang->line('title_home');
				break;
			case CHAIN_MODE:
				$output['title'] = $this->lang->line('title_chain_mode');
				break;
			case PROFILE_PICTURE:
				$output['title'] = $this->lang->line('title_home');
				break;
			case ROTATION_MODE:
				$output['title'] = $this->lang->line('title_rotation_mode');
				break;
			case PIXEL_ART_MODE:
				$output['title'] = $this->lang->line('title_pixel_art_mode');
				break;
			case BLINDED_MODE:
				$output['title'] = $this->lang->line('title_blind_mode');
				break;
			case INFINITY_MODE:
				$output['title'] = $this->lang->line('title_unlimited_mode');
				break;
			default:
				$output['title'] = $this->lang->line('title_home');
				break;
		}
		$this->display_view('play/index', $output);
	}

	public function draw($mode = 1) {
		if(!empty($_POST['pseudo'])){
			$_SESSION['pseudo'] = htmlspecialchars($_POST['pseudo']);
			
			$output['title'] = $this->lang->line('title_draw');
			$output['mode'] = $mode;
			if($mode == INFINITY_MODE){
				$output['picture'] = $this->picture_model->get($_POST['model']);
			} else if(isset($_SESSION['picture_id'])) {
				$output['picture'] = $this->picture_model->get($_SESSION['picture_id']);
			} else {
				$output['picture'] = $this->db->query('SELECT * FROM pictures ORDER BY RAND() LIMIT 1')->result_object()[0];
			}
			$output['id'] = $output['picture']->id;
			$_SESSION['picture_id'] = $output['id'];

			if($mode == CHAIN_MODE){
				$drawing_real = $this->db->query('SELECT * FROM drawings WHERE fk_picture = '.$output['picture']->id.' AND type = 2 AND deleted = 0 ORDER BY id DESC');
				if(count($drawing_real) > 0){
					$output['picture'] = $drawing_real->result_object()[0];
				} else {
					$output['picture'] = $this->picture_model->get($_SESSION['picture_id']);
				}
			}

			switch ($mode) {
				case NORMAL_MODE:
					$output['time'] = 45;
					break;
				case CHAIN_MODE:
					$output['time'] = 45;
					break;
				case PROFILE_PICTURE:
					$output['time'] = 45;
					break;
				case ROTATION_MODE:
					$output['time'] = 30;
					break;
				case PIXEL_ART_MODE:
					$output['time'] = 60;
					break;
				case BLINDED_MODE:
					$output['time'] = 2;
					break;
				case INFINITY_MODE:
					$output['time'] = '&infin;';
					break;
				default:
					$output['time'] = 45;
					break;
			}
			$this->display_view('play/draw', $output, false);
		} else {
			redirect('play/index/'.$mode);
		}
	}

	public function post($mode, $picture){
		unset($_SESSION['picture_id']);
		$dir = FCPATH."medias/drawings/".date("Y-m");
		if(!is_dir($dir)){
			mkdir($dir);
		}

		if($mode == PROFILE_PICTURE){
			$picture_name = 'U'.$_SESSION['user_id']."_".date("Ymd-His");
		} else {
			$picture_name = $picture."_".date("Ymd-His");
		}
		$temp_name = $picture_name.'.png';
		$i = 0;
		while(is_file($dir.'/'.$temp_name)){
			$i++;
			$temp_name = $picture_name.'('.$i.').png';
		}
		
		file_put_contents($dir.'/'.$temp_name, base64_decode(explode('base64,', $_POST['image'])[1]));


		$dir = FCPATH."medias/json/".date("Y-m");
		if(!is_dir($dir)){
			mkdir($dir);
		}

		if($mode == PROFILE_PICTURE){
			$json_filename = 'U'.$_SESSION['user_id']."_".date("Ymd-His");
		} else {
			$json_filename = $picture."_".date("Ymd-His");
		}
		$json_temp_name = $json_filename.'.json';
		$i = 0;
		while(is_file($dir.'/'.$json_temp_name)){
			$i++;
			$json_temp_name = $json_filename.'('.$i.').json';
		}
		
		file_put_contents($dir.'/'.$json_temp_name, $_POST['json']);


		$req = array(
			'pseudo' => $_SESSION['pseudo'],
			'fk_user' => isset($_SESSION['user_id'])?$_SESSION['user_id']:null,
			'fk_picture' => $picture,
			'type' => $mode,
			'file' => date("Y-m").'/'.$temp_name,
			'json' => date("Y-m").'/'.$json_temp_name,
			'ip' => $_SERVER['REMOTE_ADDR']
		);
		$this->drawing_model->insert($req);
		redirect('gallery/index/'.$mode.'/'.$picture);
	}
}
