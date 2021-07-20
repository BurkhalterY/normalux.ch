<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Misc extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('suggestion_model');
	}

	public function contact() {
		$output['title'] = $this->lang->line('title_gallery');
		$this->display_view('misc/contact', $output);
	}

	public function bd() {
		$output['title'] = $this->lang->line('title_bd');
		$this->display_view('misc/bd', $output);
	}

	public function suggestion() {
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
			$output['title'] = $this->lang->line('title_suggestion');

			if(isset($_POST['send'])){
				$message = htmlspecialchars($_POST['message']);

				for($i = 0; $i < count($_FILES['files']['name']); $i++){
					if($_FILES['files']['error'][$i] != 4){

						$file_name = htmlspecialchars(basename($_FILES['files']['name'][$i]));
						$file_const = $file_name;
						$j = 1;
						while(file_exists(FCPATH.'medias/uploads/'.$file_name)){
							$file_name = pathinfo($file_const, PATHINFO_FILENAME).'('.$j.').'.pathinfo($file_const, PATHINFO_EXTENSION);
							$j++;
						}

						move_uploaded_file($_FILES['files']['tmp_name'][$i], FCPATH.'medias/uploads/'.$file_name);

						$extension_upload = strtolower(pathinfo($_FILES['files']['name'][$i])['extension']);
						$extensions_images = array('jpg', 'jpeg', 'gif', 'png', 'ico', 'svg', 'bmp');
						$extensions_audios = array('mp3', 'wav');
						$extensions_videos = array('mp4', 'webm');
						$extensions_object = array('swf');

						if(in_array($extension_upload, $extensions_images)){
							$message .= '<br><img src="'.base_url(htmlspecialchars('medias/uploads/'.$file_name)).'" alt="'.htmlspecialchars($file_name).'">';
						} else if(in_array($extension_upload, $extensions_audios)){
							$message .= '<br><audio controls><source src="'.base_url(htmlspecialchars('medias/uploads/'.$file_name)).'" type="audio/'.$extension_upload.'"></audio>';
						} else if(in_array($extension_upload, $extensions_videos)){
							$message .= '<br><video controls><source src="'.base_url(htmlspecialchars('medias/uploads/'.$file_name)).'" type="video/'.$extension_upload.'"></video>';
						} else if(in_array($extension_upload, $extensions_object)){
							$message .= '<br><object data="'.base_url(htmlspecialchars('medias/uploads/'.$file_name)).'"></object>';
						} else {
							$message .= '<br><a href="'.base_url(htmlspecialchars('medias/uploads/'.$file_name)).'">'.htmlspecialchars($file_name).'</a>';
						}
					}
				}

				$req = array('fk_user' => $_SESSION['user_id'], 'content' => nl2br($message));
				$this->suggestion_model->insert($req);
				$output['ok'] = true;
			}

			$this->display_view('misc/suggestion', $output);
		} else {
			redirect('user/login');
		}
	}

	public function suggestions() {
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN){
			$output['title'] = $this->lang->line('title_suggestion');
			$this->db->order_by('id', 'DESC');
			$output['suggestions'] = $this->suggestion_model->with('user')->get_all();
			$this->display_view('misc/suggestions', $output);
		} else {
			$this->error(403);
		}
	}

	public function error($error = 404) {
		$output['title'] = $this->lang->line('error').' '.$error;
		$output['error'] = $error;
		$this->display_view('misc/error', $output);
	}

}
