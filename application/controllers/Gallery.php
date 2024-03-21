<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('picture_model', 'drawing_model', 'vote_model', 'comment_model'));
	}

	public function index($mode = 1, $picture = 0, $page = 1) {
		$output['title'] = $this->lang->line('title_gallery');
		$output['mode'] = $mode;
		$output['picture_id'] = $picture;

		$where = '1 = 1';
		if($mode != 0){
			$where .= ' AND type = '.$mode;
		}
		if($picture != 0){
			$where .= ' AND fk_picture = '.$picture;
		}

		$this->db->order_by('title');
		$output['pictures'] = $this->picture_model->get_all();
		$output['drawings'] = $this->drawing_model->get_many_by($where);

		if($picture != 0){
			array_unshift($output['drawings'], $this->picture_model->get($picture));
		}

		$output['nb_pages'] = ceil(count($output['drawings'])/PER_PAGE);
		$output['page'] = $page < $output['nb_pages'] ? $page : $output['nb_pages'];
		$output['drawings'] = array_slice($output['drawings'], ($output['page']-1)*PER_PAGE, PER_PAGE);

		$this->display_view('gallery/index', $output);
	}

	public function details($id){
		$output['title'] = $this->lang->line('title_details');
		$output['drawing'] = $this->drawing_model->with('picture')->with_deleted()->get($id);
		$output['likes'] = $this->vote_model->count_by('fk_drawing', $id);
		$output['comments'] = $this->comment_model->with('user')->get_many_by('fk_drawing', $id);
		$this->display_view('gallery/details', $output);
	}

	public function like($id){
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
			if($this->vote_model->count_by('fk_user='.$_SESSION['user_id'].' AND fk_drawing='.$id) == 0){
				$req = array(
					'fk_user' => $_SESSION['user_id'],
					'fk_drawing' => $id
				);
				$this->vote_model->insert($req);
			} else {
				$this->vote_model->delete_by('fk_user='.$_SESSION['user_id'].' AND fk_drawing='.$id);
			}
			redirect('gallery/details/'.$id);
		} else {
			redirect('user/login');
		}
	}

	public function comment($id){
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
			$req = array(
				'fk_user' => $_SESSION['user_id'],
				'fk_drawing' => $id,
				'message' => $this->input->post('message'),
				'ip' => $_SERVER['REMOTE_ADDR']
			);
			$this->comment_model->insert($req);
		}
		redirect('gallery/details/'.$id);
	}

	public function replay($id){
		$output['title'] = $this->lang->line('title_replay');
		$output['drawing'] = $this->drawing_model->with('picture')->get($id);
		if($output['drawing']->type == CHAIN_MODE){
			$output['drawing']->picture = $this->db->query('SELECT * FROM drawings WHERE fk_picture = '.$output['drawing']->picture->id.' AND type = 2 AND id < '.$id.' AND deleted = 0 ORDER BY id DESC')->result_object()[0];
		}

		if(new DateTime($output['drawing']->date_drawing) < new DateTime('2019-07-01 00:00:00')){
			$this->display_view('gallery/old_replay', $output);
		} else {
			$this->display_view('gallery/replay', $output);
		}
	}

	public function story(){
		$output['title'] = $this->lang->line('title_story');
		$this->db->order_by('title');
		$output['pictures'] = $this->picture_model->get_all();
		foreach ($output['pictures'] as $picture) {
			$req = $this->db->query('SELECT * FROM drawings WHERE fk_picture = '.$picture->id.' AND type = 2 AND deleted = 0 ORDER BY id DESC')->result_object();
			$picture->count = count($req);
			if($picture->count > 0){
				$picture->drawing = $req[0];
			}
		}
		$this->display_view('gallery/story', $output);
	}

	public function censored($page = 1) {

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_MODO){

			$output['drawings'] = $this->drawing_model->with_deleted()->get_many_by('deleted = 1');

			$output['nb_pages'] = ceil(count($output['drawings'])/PER_PAGE);
			$output['page'] = $page < $output['nb_pages'] ? $page : $output['nb_pages'];
			$output['drawings'] = array_slice($output['drawings'], ($output['page']-1)*PER_PAGE, PER_PAGE);
			
			$output['censored'] = true;

			$this->display_view('gallery/index', $output);
		} else {
			redirect('user/login');
		}
	}
}