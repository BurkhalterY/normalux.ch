<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Japan extends MY_Controller {

	protected $access_level = ACCESS_LVL_USER;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('unit_model', 'word_model', 'tracing_model', 'kdlt_model'));
	}
	
	public function index(){
		$this->display_view('japan/index');
	}

	public function active($id = -1, $is_unit = 0){
		if($id >= 0){
			if($is_unit == 0){
				if($this->word_model->with('unit')->get($id)->unit->fk_user == $_SESSION['user_id']){
					$this->db->query('UPDATE words SET active = NOT active, nb_time = 0 WHERE id = '.$id);
					redirect('japan/active#word-'.$id);
				} else {
					redirect('misc/error/403');
				}
			} else {
				if($id == 0){
					$this->db->query('UPDATE words SET active = '.($is_unit>0?1:0).', nb_time = 0 WHERE fk_unit IN (SELECT id FROM units WHERE fk_user = '.$_SESSION['user_id'].')');
					redirect('japan/active');	
				} else {
					if($this->unit_model->get($id)->fk_user == $_SESSION['user_id']){
						$this->db->query('UPDATE words SET active = '.($is_unit>0?1:0).', nb_time = 0 WHERE fk_unit = '.$id);
						redirect('japan/active#unit-'.$id);
					} else {
						redirect('misc/error/403');
					}
				}
			}
		} else {
			$this->unit_model->order_by('no');
			$output['units'] = $this->unit_model->with('words')->get_many_by(['fk_user' => $_SESSION['user_id'], 'archive' => 0]);
			$this->display_view('japan/active', $output);
		}
	}
	
	public function calligraphy(){
		$output['word'] = $this->db->query('SELECT * FROM words WHERE active = 1 AND archive = 0 AND fk_unit IN (SELECT id FROM units WHERE fk_user = '.$_SESSION['user_id'].') ORDER BY nb_time, RAND() LIMIT 1')->result_object();
		if(count($output['word']) == 0){
			$this->display_view('japan/calligraphy/error', $output);
		} else {
			$output['word'] = $output['word'][0];
			$this->display_view('japan/calligraphy/index', $output, false);
		}
	}

	public function post($word){
		$dir = FCPATH."medias/drawings/".date("Y-m");
		if(!is_dir($dir)){
			mkdir($dir);
		}

		$picture_name = "JAP_".$word."_".date("Ymd-His");
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

		$json_filename = "JAP_".$word."_".date("Ymd-His");
		$json_temp_name = $json_filename.'.json';
		$i = 0;
		while(is_file($dir.'/'.$json_temp_name)){
			$i++;
			$json_temp_name = $json_filename.'('.$i.').json';
		}
		
		file_put_contents($dir.'/'.$json_temp_name, $_POST['json']);


		$req = array(
			'fk_word' => $word,
			'filename' => date("Y-m").'/'.$temp_name,
			'json' => date("Y-m").'/'.$json_temp_name,
			'ip' => $_SERVER['REMOTE_ADDR']
		);
		$id = $this->tracing_model->insert($req);
		
		$this->db->query('UPDATE words SET `nb_time` = `nb_time`+1 WHERE id = '.$word);
		
		redirect('japan/validate/'.$id);
	}

	public function validate($tracing, $valid = null){
		$output['tracing'] = $this->tracing_model->with('word')->with('unit')->get($tracing);
		if($this->word_model->with('unit')->get($output['tracing']->fk_word)->unit->fk_user == $_SESSION['user_id']){
			if(is_null($valid)){
				$this->display_view('japan/calligraphy/validate', $output, false);
			} else {
				$this->tracing_model->update($tracing, array('correct' => $valid));
				redirect('japan/results');
			}
		} else {
			redirect('misc/error/403');
		}
	}

	public function results(){
		$output['tracings'] = $this->db->query('SELECT tracings.id, tracings.correct, tracings.filename, words.french, words.kana, words.kanji FROM tracings INNER JOIN words ON fk_word = words.id WHERE fk_word IN (SELECT id FROM words WHERE fk_unit IN (SELECT id FROM units WHERE fk_user = '.$_SESSION['user_id'].')) ORDER BY tracings.id DESC LIMIT 50')->result_object();
		
		if(count($output['tracings']) > 0){
			$sum = 0;
			foreach ($output['tracings'] as $tracing) {
				$sum += $tracing->correct;
			}
			$output['moy'] = round($sum / count($output['tracings']) * 100);
			$output['moy'] = $output['moy'].'%';
		} else {
			$output['moy'] = '';
		}

		$this->display_view('japan/calligraphy/results', $output);
	}
	
	public function kdlt_list(){
		$output['list'] = $this->kdlt_model->get_all();
		$this->display_view('japan/kdlt-list', $output);
	}
	
	public function kdlt($id = 1){
		if($id > 0){
			$output['kanji'] = $this->kdlt_model->get($id);
		} else {
			$output['kanji'] = $this->kdlt_model->get_by('keyword', $id);
		}
		$this->display_view('japan/kdlt', $output);
	}
}