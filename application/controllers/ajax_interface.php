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
	
	public function getAuthorsList(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if($this->postDataValidation('char')):
			$this->load->model('authors');
			if($authors = $this->authors->getAuthorsByChar($this->input->post('char'),$this->input->post('lang'))):
				$this->load->helper('text');
				$this->config->set_item('base_url',baseURL($this->uri->language_string.'/'));
				$json_request['responseText'] = $this->load->view('html/authors-list',array('authors'=>$authors,'langName'=>$this->input->post('lang')),TRUE);
			else:
				$this->lang->load('localization/interface',$this->languages[$this->input->post('lang')]);
				$this->load->helper('language');
				$json_request['responseText'] = lang('not_found_authors');
			endif;
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	/******************************************** admin interface *******************************************************/
	/* ------------- Pages ----------------- */
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
	/* ------------- authors ----------------- */
	public function insertAuthor(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('author')):
			if($this->ExecuteInsertingAuthor($_POST)):
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Автор добавлен';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/authors');
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function updateAuthor(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('author')):
			if($this->ExecuteUpdatingAuthor($this->input->get('id'),$_POST)):
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Автор cохранен';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/authors');
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function removeAuthor(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		$this->load->model('authors');
		$this->authors->delete($this->input->post('id'));
		$json_request['status'] = TRUE;
		echo json_encode($json_request);
	}
	
	private function ExecuteInsertingAuthor($post){
		
		return $this->insertItem(array('insert'=>$post,'model'=>'authors'));
		return TRUE;
	}
	
	private function ExecuteUpdatingAuthor($id,$post){
		
		$post['id'] = $id;
		$this->updateItem(array('update'=>$post,'model'=>'authors'));
		return TRUE;
	}
	/* ------------- Issues ----------------- */
	public function insertIssue(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('issues')):
			if($this->ExecuteInsertingIssue($_POST)):
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Выпуск добавлен';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/issues');
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function updateIssue(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('issues')):
			if($this->ExecuteUpdatingIssue($this->input->get('id'),$_POST)):
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Выпуск cохранен';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/issues');
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function removeIssue(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		$this->load->model('issues');
		$this->issues->delete($this->input->post('id'));
		$json_request['status'] = TRUE;
		echo json_encode($json_request);
	}
	
	private function ExecuteInsertingIssue($post){
		
		return $this->insertItem(array('insert'=>$post,'model'=>'issues'));
		return TRUE;
	}
		
	private function ExecuteUpdatingIssue($id,$post){
		
		$post['id'] = $id;
		$this->updateItem(array('update'=>$post,'model'=>'issues'));
		return TRUE;
	}
	/* ------------- Publications ----------------- */
	public function insertPublication(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('publication')):
			if($publicationID = $this->ExecuteInsertingPublication($_POST)):
				if(isset($_FILES['ru_document']['tmp_name'])):
					$this->uploadPublicationDocument($publicationID,'ru_document');
				endif;
				if(isset($_FILES['en_document']['tmp_name'])):
					$this->uploadPublicationDocument($publicationID,'en_document');
				endif;
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Публикация добавлена.';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/publications?issue='.$this->input->get('issue'));
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function updatePublication(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('publication')):
			if($this->ExecuteUpdatingPublication($this->input->get('id'),$_POST)):
				if(isset($_FILES['ru_document']['tmp_name'])):
					$this->uploadPublicationDocument($this->input->get('id'),'ru_document');
				endif;
				if(isset($_FILES['en_document']['tmp_name'])):
					$this->uploadPublicationDocument($this->input->get('id'),'en_document');
				endif;
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Выпуск cохранен';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/publications?issue='.$this->input->get('issue'));
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function removePublication(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		$this->load->model('publications');
		if($publication = $this->publications->getWhere($this->input->post('id'))):
			$this->filedelete(getcwd().'/download/'.$publication['ru_document']);
			$this->filedelete(getcwd().'/download/'.$publication['en_document']);
		endif;
		$this->publications->delete($this->input->post('id'));
		$json_request['status'] = TRUE;
		echo json_encode($json_request);
	}
	
	private function ExecuteInsertingPublication($post){
		
		$post['issue'] = $this->input->get('issue');
		unset($post['ru_document'],$post['en_document']);
		if(!empty($post['ru_title'])):
			$post['page_url'] = $this->translite($post['ru_title']);
		elseif(!empty($post['en_title'])):
			$post['page_url'] = $this->translite($post['en_title']);
		endif;
		return $this->insertItem(array('insert'=>$post,'model'=>'publications'));
	}
	
	private function ExecuteUpdatingPublication($id,$post){
		
		$post['id'] = $id;
		unset($post['ru_document'],$post['en_document']);
		if(!empty($post['ru_title'])):
			$post['page_url'] = $this->translite($post['ru_title']);
		elseif(!empty($post['en_title'])):
			$post['page_url'] = $this->translite($post['en_title']);
		endif;
		$this->updateItem(array('update'=>$post,'model'=>'publications'));
		return TRUE;
	}
	
	private function uploadPublicationDocument($publicationID,$document){
		
		$uploadPath = getcwd().'/download';
		$issueUploadPath = '';
		$this->load->model(array('issues','publications'));
		if($this->input->get('issue') !== FALSE):
			if($issue = $this->issues->getWhere($this->input->get('issue'))):
				$issueUploadPath = $issue['year'].'/'.$issue['month'];
			endif;
		endif;
		$resultUpload = $this->uploadSingleDocument($uploadPath.'/'.$issueUploadPath,$document);
		if($resultUpload['status'] == TRUE):
			$responseDocumentSrc = $issueUploadPath.'/'.$resultUpload['uploadData']['file_name'];
			$this->publications->updateField($publicationID,$document,$responseDocumentSrc);
			return TRUE;
		else:
			return $resultUpload['message'];
		endif;
		
		
	}
	
	/* ------------- keywords ----------------- */
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