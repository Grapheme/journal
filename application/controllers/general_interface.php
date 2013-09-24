<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class General_interface extends MY_Controller{
	
	function __construct(){

		parent::__construct();
	}
	
	public function signIN(){
		
		$this->load->view("general_interface/signin");
	}
	
	public function loginIn(){
		
		if(!$this->input->is_ajax_request() && $this->loginstatus === FALSE):
			show_error('В доступе отказано');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url());
		if($this->postDataValidation('signin') == TRUE):
			if($user = $this->accounts->authentication($this->input->post('login'),$this->input->post('password'))):
				if($user['active']):
					$this->setLoginSession($user['id']);
					if($user['group'] == ADMIN_GROUP_VALUE):
						$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/pages');
					elseif($user['group'] == USER_GROUP_VALUE && isset($_SERVER['HTTP_REFERER'])):
						$json_request['redirect'] = $_SERVER['HTTP_REFERER'];
					endif;
					$json_request['status'] = TRUE;
				else:
					$json_request['responseText'] = 'Аккаунт не активирован';
				endif;
			else:
				$json_request['responseText'] = 'Неверный логин или пароль';
			endif;
		else:
			$json_request['responseText'] = $this->load->view('html/validation-errors',array('alert_header'=>'Неверно заполнены поля'),TRUE);
		endif;
		echo json_encode($json_request);
	}
	
	public function logoff(){
		
		$this->session->unset_userdata(array('logon'=>'','profile'=>'','account'=>'','backpath'=>'','order_list'=>''));
		if(isset($_SERVER['HTTP_REFERER'])):
			redirect($_SERVER['HTTP_REFERER']);
		else:
			redirect('');
		endif;
	}
	
	public function redactorUploadImage(){
		
		if($this->loginstatus):
			$uploadPath = 'download';
			if(isset($_FILES['file']['name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK):
				if($this->imageResize($_FILES['file']['tmp_name'])):
					$uploadResult = $this->uploadSingleImage(getcwd().'/'.$uploadPath);
					if($uploadResult['status'] === TRUE && !empty($uploadResult['uploadData'])):
						if($this->imageResize($_FILES['file']['tmp_name'],NULL,TRUE,100,100,TRUE)):
							$this->uploadSingleImage(getcwd().'/'.$uploadPath.'/thumbnail','thumb_'.$uploadResult['uploadData']['file_name']);
						endif;
						$file = array(
							'filelink'=>base_url($uploadPath.'/'.$uploadResult['uploadData']['file_name'])
						);
						echo stripslashes(json_encode($file));
					endif;
				endif;
			elseif($_FILES['file']['error'] !== UPLOAD_ERR_OK):
				$message['error'] = $this->getFileUploadErrorMessage($_FILES['file']);
				echo json_encode($message);
			endif;
		endif;
	}
	
	public function redactorUploadedImages(){
		
		if($this->loginstatus):
			$uploadPath = 'download';
			$fullList[0] = $fileList = array('thumb'=>'','image'=>'','title'=>'Изображение','folder'=>'Миниатюры');
			if($listDir = scandir($uploadPath)):
				$index = 0;
				foreach($listDir as $number => $file):
					if(is_file(getcwd().'/'.$uploadPath.'/'.$file)):
						$thumbnail = getcwd().'/'.$uploadPath.'/thumbnail/thumb_'.$file;
						if(file_exists($thumbnail) && is_file($thumbnail)):
							$fileList['thumb'] = site_url($uploadPath.'/thumbnail/thumb_'.$file);
						endif;
						$fileList['image'] = site_url($uploadPath.'/'.$file);
						$fullList[$index] = $fileList;
						$index++;
					endif;
				endforeach;
			endif;
			echo json_encode($fullList);
		endif;
	}
	/********** sing in by social network *************/
	public function signInVK(){
				
		if($vkontakte = $this->getVKontakteAccessToken($this->input->get('code'),site_url($this->uri->language_string.'/sign-in/vk'))):
			if($VKontakteAccountInformation = $this->getVKontakteAccountInformation($vkontakte)):
				$VKontakteAccountInformation['access_token'] = $vkontakte['access_token'];
				if($userID = $this->accounts->search('vkid',$VKontakteAccountInformation['uid'])):
					$this->signInAccount($userID);
					$this->accounts->updateField($userID,'vk_access_token',$vkontakte['access_token']);
				else:
					if($userID = $this->registerUserByVK($VKontakteAccountInformation)):
						$this->signInAccount($userID);
					endif;
				endif;
			else:
				show_error('Ошибка при авторизации. Попробуйте позже');
			endif;
		endif;
		redirect($this->session->userdata('current_page').'#comments-form');
	}
	
	public function signInUpFacebook(){
		
		if($accessToken = $this->getFaceBookAccessToken($this->input->get('code'),site_url($this->uri->language_string.'/sign-in/facebook'))):
			if($faceBookAccountInformation = $this->getFaceBookAccountInformation($accessToken)):
				$faceBookAccountInformation['access_token'] = $accessToken;
				if($userID = $this->accounts->search('facebookid',$faceBookAccountInformation['id'])):
					$this->signInAccount($userID);
					$this->accounts->updateField($userID,'facebook_access_token',$accessToken);
				else:
					if($userID = $this->registerUserByFaceBook($faceBookAccountInformation)):
						$this->signInAccount($userID);
					endif;
				endif;
			else:
				show_error('Ошибка при авторизации. Попробуйте позже');
			endif;
		endif;
		redirect($this->session->userdata('current_page').'#comments-form');
	}
	
	private function signInAccount($userID){
		
		if($user = $this->accounts->getWhere($userID,array('active'=>1))):
			$this->setLoginSession($user['id']);
			return TRUE;
		endif;
		return FALSE;
	}

	private function setLoginSession($accountID){
		
		if($accountInfo = $this->accounts->getWhere($accountID)):
			$account = json_encode(array('id'=>$accountInfo['id'],'group'=>$accountInfo['group']));
			$this->session->set_userdata(array('logon'=>md5($accountInfo['login']),'account'=>$account));
			return TRUE;
		endif;
		return FALSE;
	}
	/*************************************************************************************************************/
	
	private function getVKontakteAccessToken($code,$redirect){
		
		$url = "https://oauth.vk.com/access_token?client_id=3867305&client_secret=qFZITMpsU8aHlO2OlJbP&code=".$code."&redirect_uri=".$redirect;
		$VKontakteResponse = json_decode($this->getCurlLink($url),TRUE);
		if(isset($VKontakteResponse['access_token'])):
			return $VKontakteResponse;
		else:
			return FALSE;
		endif;
	}
	
	private function getVKontakteAccountInformation($vkontakte){
		
		$url = "https://api.vk.com/method/getProfiles?uid=".$vkontakte['user_id']."&fields=photo,photo_big,sex,bdate,contacts,timezone,screen_name&access_token=".$vkontakte['access_token'];
		$VKontakteResponse = json_decode($this->getCurlLink($url),TRUE);
		if(isset($VKontakteResponse['response'][0])):
			return $VKontakteResponse['response'][0];
		else:
			return FALSE;
		endif;
	}
	
	private function getFaceBookAccessToken($code,$redirect){
		
		$url = "https://graph.facebook.com/oauth/access_token?client_id=229311657225307&client_secret=bf7516bd1fa176fe76c86899d1d092cc&code=".$code."&redirect_uri=".$redirect;
		$FaceBookResultString = $this->getCurlLink($url);
		$FaceBookResultArray = explode('&',$FaceBookResultString);
		$accessToken = explode('=',$FaceBookResultArray[0]);
		if(!empty($accessToken[1])):
			return $accessToken[1];
		else:
			return FALSE;
		endif;
	}
	
	private function getFaceBookAccountInformation($token){
		
		$url = "https://graph.facebook.com/me?fields=id,first_name,email,last_name,timezone,gender,birthday,link,picture.width(200).height(200)&access_token=".$token;
		$FaceBookResponse = $this->getCurlLink($url);
		$response = json_decode($FaceBookResponse,TRUE);
		if(isset($response['id'])):
			return $response;
		endif;
		return FALSE;
	}
	
	private function registerUserByVK($signUpVK){
		
		if(isset($signUpVK['uid']) && $signUpVK['uid']):
			$photo = '';
			if(!empty($signUpVK['photo'])):
				$photo = file_get_contents($signUpVK['photo']);
			endif;
			$signUpData = array(
				"group"=>1,"vkid"=>$signUpVK['uid'],"vk_access_token"=>$signUpVK['access_token'],"facebookid"=>0,"facebook_access_token"=>'',
				"photo"=>$photo,"name"=>$signUpVK['first_name'].' '.$signUpVK['last_name'],
				"link"=>'http://vk.com/'.$signUpVK['screen_name'],'login'=>'','password'=>'','active'=>1
			);
			return $this->insertItem(array('insert'=>$signUpData,'model'=>'accounts'));
		else:
			return FALSE;
		endif;
	}
	
	private function registerUserByFaceBook($signUpFB){
		
		if(isset($signUpFB['id']) && $signUpFB['id']):
			$photo = '';
			if(!empty($signUpFB['picture']['data']['url'])):
				$photo = $this->getImageContent(file_get_contents($signUpFB['picture']['data']['url']),array('dim'=>'width','ratio'=>TRUE,'width'=>60,'height'=>60));
			endif;
			$signUpData = array(
				"group"=>1,"vkid"=>0,"vk_access_token"=>'',"facebookid"=>$signUpFB['id'],"facebook_access_token"=>$signUpFB['access_token'],
				"photo"=>$photo,"name"=>$signUpFB['first_name'].' '.$signUpFB['last_name'],
				"link"=>$signUpFB['link'],'login'=>'','password'=>'','active'=>1
			);
			return $this->insertItem(array('insert'=>$signUpData,'model'=>'accounts'));
		else:
			return FALSE;
		endif;
	}
	
	/*************************************************************************************************************/
	
	public function searchAuthor(){
		
		$json_request = json_encode(array());
		$this->load->model('authors');
		if($authors = $this->authors->searchAuthorsByChar($this->input->get('q'),RUSLAN)):
			$json_request = json_encode($authors);
		endif;
		echo $json_request;
	}
}