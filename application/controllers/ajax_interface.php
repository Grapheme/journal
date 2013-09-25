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
			$lang = RUSLAN;
			if($this->input->post('lang') !== FALSE):
				$lang = $this->input->post('lang');
			endif;
			if($authors = $this->authors->getAuthorsByChar($this->input->post('char'),$lang)):
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
	
	public function getKeyWordsList(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if($this->postDataValidation('char')):
			$this->load->model('keywords');
			if($keywords = $this->keywords->getKeywordsByChar($this->input->post('char'))):
				$this->load->helper('text');
				$this->config->set_item('base_url',baseURL($this->uri->language_string.'/'));
				$json_request['responseText'] = $this->load->view('html/keywords-list',array('keywords'=>$keywords),TRUE);
			else:
				$this->lang->load('localization/interface',$this->languages[$this->input->post('lang')]);
				$this->load->helper('language');
				$json_request['responseText'] = lang('not_found_keyword');
			endif;
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	/******************************************** admin interface *******************************************************/
	/* ------------------------------------- */
	public function execScript1(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		/* -------------------------------*/
		include_once(getcwd().'/scripts/script1.php');
		$json_request['status'] = TRUE;
		$json_request['responseText'] = 'Скрипт №1 выполнен успешно';
		/* -------------------------------*/
		echo json_encode($json_request);
	}
	
	public function execScript2(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		/* -------------------------------*/
		include_once(getcwd().'/scripts/script2.php');
		$json_request['status'] = TRUE;
		$json_request['responseText'] = 'Скрипт №2 выполнен успешно';
		/* -------------------------------*/
		echo json_encode($json_request);
	}
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
	/* ------------- Institution ----------------- */
	public function insertInstitution(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('institution')):
			if($this->ExecuteInsertingInstitution($_POST)):
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Учреждение добавлено';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/institutions');
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function updateInstitution(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url(ADMIN_START_PAGE));
		if($this->postDataValidation('institution')):
			if($this->ExecuteUpdatingInstitution($this->input->get('id'),$_POST)):
				$json_request['status'] = TRUE;
				$json_request['responseText'] = 'Учреждение cохранено';
				$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/institutions');
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function removeInstitution(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		$this->load->model('institutions');
		$this->institutions->delete($this->input->post('id'));
		$json_request['status'] = TRUE;
		echo json_encode($json_request);
	}
	
	private function ExecuteInsertingInstitution($post){
		
		if(empty($post['ru_site_link']) && !empty($post['en_site_link'])):
			$post['ru_site_link'] = $post['en_site_link'];
		elseif(!empty($post['ru_site_link']) && empty($post['en_site_link'])):
			$post['en_site_link'] = $post['en_site_link'];
		endif;
		return $this->insertItem(array('insert'=>$post,'model'=>'institutions'));
		return TRUE;
	}
	
	private function ExecuteUpdatingInstitution($id,$post){
		
		$post['id'] = $id;
		$this->updateItem(array('update'=>$post,'model'=>'institutions'));
		return TRUE;
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
	
	public function uploadResourcePublication(){
		
		if(!$this->input->is_ajax_request() && !$this->input->get_request_header('X-file-name',TRUE)):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','responsePhotoSrc'=>'');
		$uploadPath = getcwd().'/download';
		$issueUploadPath = '';
		$this->load->model('issues');
		if($this->input->get('issue') !== FALSE):
			if($issue = $this->issues->getWhere($this->input->get('issue'))):
				$issueUploadPath = $issue['year'].'/'.$issue['month'];
			endif;
		endif;
		$resultUpload = $this->uploadSingleDocument($uploadPath.'/'.$issueUploadPath,'file',ALLOWED_TYPES_DOCUMENTS.'|'.ALLOWED_TYPES_IMAGES.'|'.ALLOWED_TYPES_MEDIA);
		if($resultUpload['status'] == TRUE):
			$json_request['responsePhotoSrc'] = $this->saveDocumentPublication($this->input->get('issue'),$this->input->get('publication'),$resultUpload['uploadData']);
			$json_request['status'] = TRUE;
		else:
			$json_request['responseText'] = 'Ошибка при загрузке';
		endif;
		echo json_encode($json_request);
	}
	
	public function resourceDeletePublications(){
		
		if(!$this->input->is_ajax_request() || !$this->loginstatus):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if($this->input->post('resourceID') != FALSE):
			$this->load->model('publications_resources');
			$resource = $this->publications_resources->getWhere($this->input->post('resourceID'));
			$file = json_decode($resource['resource'],TRUE);
			$this->publications_resources->delete($this->input->post('resourceID'));
			$this->filedelete($file['full_path']);
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	public function sendPublicationComment(){
		
		if(!$this->input->is_ajax_request() && $this->loginstatus && $this->account['group'] == USER_GROUP_VALUE):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','parent_comment'=>0);
		if($this->postDataValidation('publication_comment')):
			if($publicationIВD = $this->ExecuteInsertingComment($_POST)):
				$comment = array(
					'id' => $this->account['id'],
					'link' => $this->profile['link'],
					'name' => $this->profile['name'],
					'comment_id' => $publicationIВD,
					'comment' => $this->input->post('comment',TRUE)
				);
				if($this->input->post('parent') == 0):
					$json_request['responseText'] = $this->load->view('html/comments-list',array('comment'=>$comment),TRUE);
				else:
					$json_request['responseText'] = $this->load->view('html/comments-answer-list',array('comment'=>$comment),TRUE);
				endif;
				$json_request['parent_comment'] = $this->input->post('parent');
				$json_request['status'] = TRUE;
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function resourceCaptionSavePublications(){
		
		if(!$this->input->is_ajax_request()):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE);
		if($this->postDataValidation('resources_caption')):
			$this->load->model('publications_resources');
			$this->publications_resources->updateField($this->input->post('id'),'caption',$this->input->post('caption'));
			$this->publications_resources->updateField($this->input->post('id'),'number',$this->input->post('number'));
			$json_request['status'] = TRUE;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>FALSE),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function updateComment(){
		
		if(!$this->input->is_ajax_request() || !$this->loginstatus || $this->account['group'] > ADMIN_GROUP_VALUE):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'redirect'=>$this->session->userdata('backpath'),'responseText'=>'Сохранено');
		$this->load->model('publications_comments');
		$this->publications_comments->updateField($this->input->get('id'),'comment',$this->input->post('comment'));
		$json_request['status'] = TRUE;
		echo json_encode($json_request);
	}
	
	public function removeComment(){
		
		if(!$this->input->is_ajax_request() || !$this->loginstatus || $this->account['group'] > ADMIN_GROUP_VALUE):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'Удалено');
		$this->load->model('publications_comments');
		$this->publications_comments->delete($this->input->get('id'));
		$json_request['status'] = TRUE;
		echo json_encode($json_request);
	}
	
	private function ExecuteInsertingComment($post){
		
		$post['account'] = $this->account['id'];
		return $this->insertItem(array('insert'=>$post,'model'=>'publications_comments'));
	}
	
	private function ExecuteInsertingPublication($post){
		
		$post['issue'] = $this->input->get('issue');
		if(!empty($post['ru_title'])):
			$post['page_url'] = $this->translite($post['ru_title']);
		elseif(!empty($post['en_title'])):
			$post['page_url'] = $this->translite($post['en_title']);
		endif;
		if(!empty($post['keywords'])):
			$keywords = $post['keywords'];
		endif;
		unset($post['ru_document'],$post['en_document'],$post['keywords']);
		if($publicationID = $this->insertItem(array('insert'=>$post,'model'=>'publications'))):
			if(!empty($keywords)):
				$this->setKeyWords($publicationID,$keywords);
			endif;
			return $publicationID;
		else:
			return FALSE;
		endif;
	}
	
	private function ExecuteUpdatingPublication($publicationID,$post){
		
		$post['id'] = $publicationID;
		if(!empty($post['ru_title'])):
			$post['page_url'] = $this->translite($post['ru_title']);
		elseif(!empty($post['en_title'])):
			$post['page_url'] = $this->translite($post['en_title']);
		endif;
		if(!empty($post['keywords'])):
			$keywords = $post['keywords'];
		endif;
		unset($post['ru_document'],$post['en_document'],$post['keywords']);
		$this->deleteKeyWords($publicationID);
		if(!empty($keywords)):
			$this->setKeyWords($publicationID,$keywords);
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
		$resultUpload = $this->uploadSingleDocument($uploadPath.'/'.$issueUploadPath,$document,'pdf');
		if($resultUpload['status'] == TRUE):
			$responseDocumentSrc = $issueUploadPath.'/'.$resultUpload['uploadData']['file_name'];
			$this->publications->updateField($publicationID,$document,$responseDocumentSrc);
			return TRUE;
		else:
			return $resultUpload['message'];
		endif;
	}
	
	private function saveDocumentPublication($issueID,$publicationID,$resource){
		
		$this->load->model('publications_resources');
		$number = $this->publications_resources->getNextNumber(array('publication'=>$publicationID));
		$resourceData = array("publication"=>$publicationID,"number"=>$number+1,"issue"=>$issueID,"resource"=>json_encode($resource));
		/**************************************************************************************************************/
		if($resourceID = $this->insertItem(array('insert'=>$resourceData,'model'=>'publications_resources'))):
			$this->load->helper('string');
			$html = '<img class="" src="'.site_url(RUSLAN.'/publications/view-document/'.random_string('alnum',16).'?resource_id='.$resourceID).'" alt="" />';
			$html .= '<a href="#" data-resource-id="'.$resourceID.'" class="delete-resource-item">&times;</a>';
			return $html;
		else:
			return '';
		endif;
	}
	/* ------------- keywords ----------------- */
	private function setKeyWords($publicationID,$keywords){
		
		if($KeyWordsList = explode(',',$keywords)):
			$this->load->model(array('keywords','matching'));
			for($i=0;$i<count($KeyWordsList);$i++):
				if(!empty($KeyWordsList[$i])):
					$insert_word = array('word'=>trim($KeyWordsList[$i]),'word_hash'=>md5(trim($KeyWordsList[$i])));
					if(!$wordID = $this->keywords->search('word_hash',$insert_word['word_hash'])):
						if($wordID = $this->insertItem(array('insert'=>$insert_word,'model'=>'keywords'))):
							$insert_match = array('word'=>$wordID,'publication'=>$publicationID);
							$matchID = $this->insertItem(array('insert'=>$insert_match,'model'=>'matching'));
						endif;
					elseif(!$this->matching->getWhere(NULL,array('word'=>$wordID,'publication'=>$publicationID))):
						$insert_match = array('word'=>$wordID,'publication'=>$publicationID);
						$matchID = $this->insertItem(array('insert'=>$insert_match,'model'=>'matching'));
					endif;
				endif;
			endfor;
		endif;
	}
	
	private function deleteKeyWords($publicationID){
		
		$this->load->model('matching');
		$this->matching->delete(NULL,array('publication'=>$publicationID));
	}
	
}