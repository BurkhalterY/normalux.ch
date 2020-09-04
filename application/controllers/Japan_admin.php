<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Japan_admin extends MY_Controller {

	protected $access_level = ACCESS_LVL_USER;

	public function __construct() {
		parent::__construct();
		$this->load->model(array('unit_model', 'word_model'));
	}

	public function index(){
		$this->display_view('japan/admin/index');
	}

	public function units_list(){
		$this->unit_model->order_by('no');
		$output['units'] = $this->unit_model->get_many_by(['fk_user' => $_SESSION['user_id'], 'archive' => 0]);
		$this->display_view('japan/admin/units/list', $output);
	}

	public function unit_form($id = 0){
		if($id > 0){
			if($_SESSION['user_id'] == $this->unit_model->get($id)->fk_user){
				$output['update'] = true;
				$output['unit'] = $this->unit_model->get($id);
			} else {
				redirect('misc/error/403');
			}
		} else {
			$output['update'] = false;
		}
		$this->display_view('japan/admin/units/form', $output);
	}

	public function unit_validation(){
		$id = $this->input->post('id');
		if(isset($_POST['save'])){
			$req = array(
				'fk_user' => $_SESSION['user_id'],
				'no' => $this->input->post('unit_no'),
				'unit' => $this->input->post('unit_name')
			);

			if($id > 0){
				if($_SESSION['user_id'] == $this->unit_model->get($id)->fk_user){
					$this->unit_model->update($id, $req);
				} else {
					redirect('misc/error/403');
				}
			} else {
				$this->unit_model->insert($req);
			}
		} else if(isset($_POST['delete'])){
			if($_SESSION['user_id'] == $this->unit_model->get($id)->fk_user){
				$this->unit_model->update($id, ['archive' => 1]);
			} else {
				redirect('misc/error/403');
			}
		}
		redirect('japan_admin/units_list#unit-'.$id);
	}

	public function words_list(){
		$output['units'] = $this->unit_model->with('words')->get_many_by(['fk_user' => $_SESSION['user_id']]);
		$this->display_view('japan/admin/words/list', $output);
	}

	public function word_form($id = 0){
		$output['units'] = $this->unit_model->get_dropdown("fk_user = ".$_SESSION['user_id']." AND archive = 0");
		if($id > 0){
			if($_SESSION['user_id'] == $this->word_model->with('unit')->get($id)->unit->fk_user){
				$output['update'] = true;
				$output['word'] = $this->word_model->get($id);
			} else {
				redirect('misc/error/403');
			}
		} else {
			$output['update'] = false;
		}
		$this->display_view('japan/admin/words/form', $output);
	}

	public function word_validation(){
		$id = $this->input->post('id');
		if(isset($_POST['save'])){
			$req = array(
				'french' => $this->input->post('french'),
				'kana' => $this->input->post('kana'),
				'kanji' => $this->input->post('kanji'),
				'fk_unit' => $this->input->post('unit')
			);

			if($id > 0){
				if($_SESSION['user_id'] == $this->word_model->with('unit')->get($id)->unit->fk_user){
					$this->word_model->update($id, $req);
				} else {
					redirect('misc/error/403');
				}
			} else {
				$this->word_model->insert($req);
			}
		} else if(isset($_POST['delete'])){
			if($_SESSION['user_id'] == $this->word_model->with('unit')->get($id)->unit->fk_user){
				$this->word_model->update($id, ['archive' => 1]);
			} else {
				redirect('misc/error/403');
			}
		}
		redirect('japan_admin/words_list#word-'.$id);
	}
	
	public function import(){
		$arr = explode("\n", trim($this->input->post('field')));
		$id = $this->unit_model->insert(['fk_user' => $_SESSION['user_id'], 'no' => -1, 'unit' => $arr[0]]);

		for($i = 1; $i < count($arr); $i++){
			$arr2 = explode("\t", $arr[$i]);
			$req = array(
				'french' => $arr2[0],
				'kana' => $arr2[1],
				'kanji' => $arr2[2],
				'fk_unit' => $id
			);
			$this->word_model->insert($req);
		}
		redirect('japan_admin/units_list');
	}
	
	public function export($id){
		$unit = $this->unit_model->get($id);
		if($_SESSION['user_id'] == $unit->fk_user){
			$words = $this->word_model->get_many_by('fk_unit', $id);
			$txt = $unit->unit;
			foreach($words as $word){
				$txt .= "\n".$word->french."\t".$word->kana."\t".$word->kanji;
			}
			header('Content-Type: text/plain');
			echo $txt;
		} else {
			redirect('misc/error/403');
		}
	}
}