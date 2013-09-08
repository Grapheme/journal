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
					$account = json_encode(array('id'=>$user['id']));
					$this->session->set_userdata(array('logon'=>md5($this->input->post('login')),'account'=>$account));
					$json_request['redirect'] = site_url(ADMIN_START_PAGE.'/pages');
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
		
		if($vkontakte = $this->getVKontakteAccessToken($this->input->get('code'),site_url('sign-in/vk'))):
			if($VKontakteAccountInformation = $this->getVKontakteAccountInformation($vkontakte)):
				$VKontakteAccountInformation['access_token'] = $vkontakte['access_token'];
				if($userID = $this->accounts->search('vkid',$VKontakteAccountInformation['uid'])):
					$this->signInAccount($userID);
					$this->accounts->updateField($userID,'vk_access_token',$vkontakte['access_token']);
				else:
					$this->signUp();
					$this->session->set_userdata(array('signinvk'=>json_encode($VKontakteAccountInformation),'link-account'=>TRUE));
					if($this->session->userdata('current_url') === FALSE || $this->session->userdata('current_url') == ''):
						redirect('?mode=link-account&status=1');
					elseif(strripos($this->session->userdata('current_url'),'?') === FALSE):
						redirect($this->session->userdata('current_url').'?mode=link-account&status=1');
					else:
						redirect($this->session->userdata('current_url').'&mode=link-account&status=1');
					endif;
				endif;
			else:
				show_error('Ошибка при авторизации. Попробуйте позже');
			endif;
		endif;
		redirect($this->session->userdata('current_url'));
	}
	
	public function signInUpFacebook(){
		
		if($accessToken = $this->getFaceBookAccessToken($this->input->get('code'),site_url('sign-in/facebook'))):
			if($faceBookAccountInformation = $this->getFaceBookAccountInformation($accessToken)):
				$faceBookAccountInformation['access_token'] = $accessToken;
				if($userID = $this->accounts->search('facebookid',$faceBookAccountInformation['id'])):
					$this->signInAccount($userID);
					$this->accounts->updateField($userID,'facebook_access_token',$accessToken);
				else:
					$this->session->set_userdata(array('signinfb'=>json_encode($faceBookAccountInformation),'link-account'=>TRUE));
					if($this->session->userdata('current_url') === FALSE || $this->session->userdata('current_url') == ''):
						redirect('?mode=link-account&status=1');
					elseif(strripos($this->session->userdata('current_url'),'?') === FALSE):
						redirect($this->session->userdata('current_url').'?mode=link-account&status=1');
					else:
						redirect($this->session->userdata('current_url').'&mode=link-account&status=1');
					endif;
				endif;
			else:
				show_error('Ошибка при авторизации. Попробуйте позже');
			endif;
		endif;
		redirect($this->session->userdata('current_url'));
	}
	
	private function signInAccount($userID){
		
		if($user = $this->accounts->getWhere($userID,array('active'=>1))):
			$this->setLoginSession($user['id']);
			$this->clearTemporaryCode($user['id']);
			return TRUE;
		endif;
		return FALSE;
	}

	private function setLoginSession($accountID){
		
		if($accountInfo = $this->accounts->getWhere($accountID)):
			$account = json_encode(array('id'=>$accountInfo['id']));
			$this->session->set_userdata(array('logon'=>md5($accountInfo['login']),'account'=>$account));
			return TRUE;
		endif;
		return FALSE;
	}
	/*************************************************************************************************************/
	
	private function signUp(){
		
		if($accountInfo = $this->getRegisterAccount($_POST)):
			if($this->registerUserByVK($accountInfo['accountID'],$accountInfo['userID']) == TRUE):
				$this->session->unset_userdata('signinvk');
			elseif($this->registerUserByFaceBook($accountInfo['accountID'],$accountInfo['userID']) == TRUE):
				$this->session->unset_userdata('signinfb');
			endif;
			$this->createDir(getcwd().'/diskspace/user'.$accountInfo['userID']);
			$json_request['status'] = TRUE;
			$json_request['responseText'] = 'Круто! Вы зарегистрированы.<br/>Мы отправили на email cсылку для активации аккаунта.';
			$mailtext = $this->load->view('mails/signup',array('data'=>$_POST,'activate_code'=>$accountInfo['activate_code']),TRUE);
			$this->sendMail($_POST['email'],'robot@universiality.com','Universiality Learning','Регистрация на UNIVERSIALITY LEARNING',$mailtext);
		endif;
	}
	
	private function getRegisterAccount($post = NULL){
		
		if(!is_null($post)):
			$this->load->helper(array('string','date'));
			$account = array();
			$account['accountID'] = $this->accounts->insertRecord(array('group'=>2,'account'=>$account['userID'],'email'=>$post['email'],'password'=>md5($post['password']),'signdate'=>date("Y-m-d H:i:s"),'language'=>$this->language,'temporary_code'=>$account['activate_code'],'code_life'=>future_days()));
			return $account;
		endif;
		return FALSE;
	}
	
	private function getVKontakteAccessToken($code,$redirect){
		
		$url = "https://oauth.vk.com/access_token?client_id=3539213&client_secret=6juI1xBlfDgTpen0EdyS&code=".$code."&redirect_uri=".$redirect;
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
		
		$url = "https://graph.facebook.com/oauth/access_token?client_id=341255199337226&client_secret=81dffd355fc48f7e41a487a9f3841e3e&code=".$code."&redirect_uri=".$redirect;
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
	
	private function resetSNAccountID($SN,$value){
		
		if($SNAccountID = $this->accounts->search($SN.'id',$value)):
			$this->accounts->updateField($SNAccountID,$SN.'id','');
			$this->accounts->updateField($SNAccountID,$SN.'_access_token','');
		endif;
	}
	
	/*************************************************************************************************************/
	
}