<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Multi extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('online_word_model', 'online_theme_model', 'online_theme_word_model'));
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
			$output['online_mode'] = true;
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

	public function word() {
		if(!is_null($_GET['themes'])){
			$word = $this->online_theme_word_model->with('word')->order_by('RAND()')->limit(1)->get_by(['fk_theme' => $_GET['themes'], 'in_validation' => 0])->word;
			$array = [
				'id' => $word->id,
				'word' => $word->word
			];
			
			header('Content-type: application/json');
			echo json_encode($word);
		}
	}

	public function propose_words() {
		$this->display_view('multi/propose/words');
	}

	public function propose_themes() {
		$words = explode(PHP_EOL, $_POST['words']);
		$output['words'] = [];
		foreach ($words as $word) {
			$word = trim($word);
			if(!empty($word)){
				if($this->online_word_model->count_by(['word' => $word]) == 0){
					$this->online_word_model->insert(['word' => $word, 'in_validation' => 1]);
				}
				$output['words'][] = $this->online_word_model->get_by(['word' => $word]);
			}
		}
		$output['themes'] = $this->online_theme_model->order_by('theme')->get_all();
		$this->display_view('multi/propose/themes', $output);
	}

	public function propose_finale() {
		foreach ($_POST['words'] as $id => $word) {
			$themes = explode(',', $word);
			if(count($themes) == 0){
				$themes[] = 'non classés';
			}
			foreach ($themes as $theme) {
				$theme = trim($theme);
				if($this->online_theme_model->count_by(['theme' => $theme]) == 0){
					$this->online_theme_model->insert(['theme' => $theme, 'in_validation' => 1]);
				}
				$themeDb = $this->online_theme_model->get_by(['theme' => $theme]);

				$relation = [
					'fk_theme' => $themeDb->id,
					'fk_word' => $id,
					'in_validation' => 1
				];
				if($this->online_theme_word_model->count_by($relation) == 0){
					$this->online_theme_word_model->insert($relation);
				}
			}
		}
		redirect('multi');
	}
}
