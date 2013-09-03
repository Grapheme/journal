<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
	}
	
	public function existEmail(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$statusval = array('status'=>FALSE);
		if($parametr = trim($this->input->post('parametr'))):
			if(!$this->accounts->search('email',$parametr)):
				$statusval['status'] = TRUE;
			endif;
		else:
			$statusval['status'] = TRUE;
		endif;
		echo json_encode($statusval);
	}
	
	/******************************************** admin interface *******************************************************/

	public function updatePage(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>FALSE);
		if($this->postDataValidation('page')):
			if($this->ExecuteUpdatingPage($this->input->get('id'),$_POST)):
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Cтраница cохранена';
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function pageUploadResources(){
		
		if($this->loginstatus === FALSE || !$this->input->get_request_header('X-file-name',TRUE)):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','responsePhotoSrc'=>'');
		$uploadPath = 'download';
		if(isset($_FILES['file']['name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK):
			if($this->imageResize($_FILES['file']['tmp_name'])):
				$uploadResult = $this->uploadSingleImage(getcwd().'/'.$uploadPath);
				if($uploadResult['status'] === TRUE && !empty($uploadResult['uploadData'])):
					if($this->imageResize($_FILES['file']['tmp_name'],NULL,TRUE,100,100,TRUE)):
						$thumbNailUpload = $this->uploadSingleImage(getcwd().'/'.$uploadPath.'/thumbnail','thumb_'.$uploadResult['uploadData']['file_name']);
					endif;
					if($uploadResult['status'] == TRUE && $thumbNailUpload['status'] == TRUE):
						$json_request['status'] = TRUE;
						$json_request['responsePhotoSrc'] = $this->savePageResource($uploadPath,$uploadResult['uploadData'],$thumbNailUpload['uploadData']);
					else:
						$json_request['responseText'] = 'Ошибка при загрузке';
					endif;
				endif;
			endif;
		elseif($_FILES['file']['error'] !== UPLOAD_ERR_OK):
			$message['error'] = $this->getFileUploadErrorMessage($_FILES['file']);
		endif;
		echo json_encode($json_request);
	}
	
	public function removePageResource(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if($this->input->post('resourceID') != FALSE):
			$this->load->model('page_resources');
			$resourcePath = getcwd().'/'.$this->page_resources->value($this->input->post('resourceID'),'resource');
			$this->page_resources->delete($this->input->post('resourceID'));
			$this->filedelete($resourcePath);
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	public function pageCaptionSave(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE);
		if($this->postDataValidation('banner_caption')):
			$this->load->model('page_resources');
			$this->page_resources->updateField($_POST['id'],'caption',$_POST['caption']);
			$this->page_resources->updateField($_POST['id'],'number',$_POST['number']);
			$json_request['status'] = TRUE;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		
		echo json_encode($json_request);
	}
	
	private function ExecuteUpdatingPage($id,$post){
		
		$post['id'] = $id;
		$this->updateItem(array('update'=>$post,'model'=>'pages'));
		return TRUE;
	}
	
	private function savePageResource($path,$resource,$thumbnail){
		
		$this->load->model('page_resources');
		$number = $this->page_resources->getNextNumber(array("page_url"=>$this->uri->segment(3)));
		$resourceData = array("page_url"=>$this->uri->segment(3),'number'=>$number+1,'thumbnail'=>$path.'/thumbnail/'.$thumbnail['file_name'],"resource"=>$path.'/'.$resource['file_name']);
		/**************************************************************************************************************/
		if($resourceID = $this->insertItem(array('insert'=>$resourceData,'model'=>'page_resources'))):
			$this->load->helper('string');
			$html = '<img class="img-rounded" src="'.base_url($resourceData['thumbnail']).'" alt="" />';
			$html .= '<a href="#" data-resource-id="'.$resourceID.'" class="delete-resource-item">&times;</a>';
			return $html;
		else:
			return '';
		endif;
	}
		
	private function setKeyWords($productID,$keywords){
		
		if($KeyWordsList = explode(',',$keywords)):
			$this->load->model(array('keywords','matching'));
			for($i=0;$i<count($KeyWordsList);$i++):
				if(!empty($KeyWordsList[$i])):
					$insert_word = array('word'=>trim($KeyWordsList[$i]),'word_hash'=>md5(trim($KeyWordsList[$i])));
					if(!$wordID = $this->keywords->search('word_hash',$insert_word['word_hash'])):
						if($wordID = $this->insertItem(array('insert'=>$insert_word,'model'=>'keywords'))):
							$insert_match = array('word'=>$wordID,'product'=>$productID);
							$matchID = $this->insertItem(array('insert'=>$insert_match,'model'=>'matching'));
						endif;
					elseif(!$this->matching->getWhere(NULL,array('word'=>$wordID,'product'=>$productID))):
						$insert_match = array('word'=>$wordID,'product'=>$productID);
						$matchID = $this->insertItem(array('insert'=>$insert_match,'model'=>'matching'));
					endif;
				endif;
			endfor;
		endif;
	}
	
	private function deleteKeyWords($productID){
		
		$this->load->model('matching');
		$this->matching->delete(NULL,array('product'=>$productID));
	}
	
}