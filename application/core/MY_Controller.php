<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	var $account = array('id'=>0,'group'=>0);
	var $profile = '';
	var $loginstatus = FALSE;
	
	var $acceptedDocTypes = array();
	
	var $baseURL = '';
	var $baseLanguageURL = RUSLAN;
	var $languages = array(RUSLAN=>'russian',ENGLAN=>'english');
	
	function __construct(){
		
		parent::__construct();
		$this->baseURL = base_url();
		
		$sessionLogon = $this->session->userdata('logon');
		if($sessionLogon):
			$this->account = json_decode($this->session->userdata('account'),TRUE);
			if($this->account):
				if($this->session->userdata('profile') == FALSE):
					$profile = $this->accounts->getWhere($this->account['id']);
					if($profile && ($sessionLogon == md5($profile['login']))):
						$this->profile = $profile;
						$this->session->set_userdata('profile',json_encode($this->profile));
						$this->loginstatus = TRUE;
					endif;
				else:
					$this->profile = json_decode($this->session->userdata('profile'),TRUE);
					$this->loginstatus = TRUE;
				endif;
			endif;
		endif;
		$this->acceptedDocTypes = array(
			'text/plain' => base_url('img/icons/txt.png'),
			'application/pdf' => base_url('img/icons/pdf.png'),
			'application/x-zip-compressed' => base_url('img/icons/zip.png'),
			'application/msword' => base_url('img/icons/doc.png'),
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => base_url('img/icons/doc.png'),
			'application/vnd.ms-excel' => base_url('img/icons/doc.png'),
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => base_url('img/icons/doc.png'),
			'application/vnd.ms-powerpoint' => base_url('img/icons/doc.png'),
			'application/vnd.openxmlformats-officedocument.presentationml.presentation' => base_url('img/icons/doc.png'),
			
			'image/png' => base_url('img/icons/pic.png'),
			'image/jpeg'=> base_url('img/icons/pic.png'),
			'image/gif'=> base_url('img/icons/pic.png'),
			
			'audio/mpeg' => base_url('img/icons/sound.png'),
			'audio/ogg'=> base_url('img/icons/sound.png'),
			'audio/webm'=> base_url('img/icons/sound.png'),
			
			'video/avi' => base_url('img/icons/video.png'),
			'video/mpeg' => base_url('img/icons/video.png'),
			'video/mp4'=> base_url('img/icons/video.png'),
			'video/webm'=> base_url('img/icons/video.png'),
		);
	}
	
	public function clearSession($redirect = TRUE){
		
		if($redirect == TRUE):
			redirect('');
		endif;
		return TRUE;
		
	}
	
	/*************************************************************************************************************/
	
	public function parseAndSendMail($langURL,$parserData){
		
		if(isset($parserData['email']) && !empty($parserData['email'])):
			$this->load->library('parser');
			$mailtext = $this->parser->parse('mails/'.$langURL.'_callback',$parserData,TRUE);
			return $this->sendMail('info@arrendamenti.su','robot@arrendamenti.su','arrendamenti.su','Контактная форма',$mailtext);
		else:
			return FALSE;
		endif;
	}
	
	public function pagination($url,$uri_segment,$total_rows,$per_page){
		
		$this->load->library('pagination');
		$config['base_url'] = site_url($url.'/offset/');
		$config['uri_segment'] = $uri_segment;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['num_links'] = 4;
		$config['first_link'] = 'В начало';
		$config['last_link'] = 'В конец';
		$config['next_link'] = 'Далее &raquo;';
		$config['prev_link'] = '&laquo; Назад';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
	public function sendMail($to,$from_mail,$from_name,$subject,$text,$attach = NULL){
		
		$this->load->library('phpmailer');
		$mail = new PHPMailer();
		$mail->IsSendmail();
		$mail->SetFrom($from_mail,$from_name);
		$mail->AddReplyTo($from_mail,$from_name);
		$mail->AddAddress($to);
		$mail->Subject = $subject;
		$mail->MsgHTML($text);
		$mail->AltBody = strip_tags($text,'<p>,<br>');
		//$mail->AddAttachment('images/phpmailer-mini.gif');
		return $mail->Send();
	}
	
	public function loadimage(){
		
		$image = NULL;
		switch($this->uri->segment(2)):
			case 'news': $this->load->model('news'); $image = $this->news->getImage($this->uri->segment(3),'photo'); break;
			case 'events': $this->load->model('events'); $image = $this->events->getImage($this->uri->segment(3),'photo'); break;
			case 'avatar': $this->load->model('accounts'); $image = $this->accounts->getImage($this->uri->segment(3),'photo'); break;
		endswitch;
		if(is_null($image) || empty($image)):
			$image = file_get_contents(NO_IMAGE);
		endif;
		header('Content-type: image/jpeg');
		echo $image;
	}
	
	public function showDocumentIco(){
		
		$resource = NULL;
		$access = FALSE;
		if($this->input->get('resource_id') != FALSE && is_numeric($this->input->get('resource_id'))):
			$this->load->model('publications_resources');
			$record = $this->publications_resources->getWhere($this->input->get('resource_id'));
			if($FileData = json_decode($record['resource'],TRUE)):
				if(isset($this->acceptedDocTypes[$FileData['file_type']])):
					$resource = file_get_contents($this->acceptedDocTypes[$FileData['file_type']]);
				else:
					$resource = file_get_contents(base_url('img/icons/no_icon.jpg'));
				endif;
			endif;
		endif;
		header('Content-type: image/jpeg');
		echo $resource;
	}
	
	public function getImageContent($content = NULL,$manupulation = NULL){
		
		if(!is_null($content)):
			$filepath = TEMPORARY.'file-content.tmp';
			file_put_contents($filepath,$content);
			if(!is_null($manupulation) && is_array($manupulation)):
				$this->imageManupulation($filepath,$manupulation['dim'],$manupulation['ratio'],$manupulation['width'],$manupulation['height']);
			endif;
			$fileContent = file_get_contents($filepath);
			$this->filedelete($filepath);
			return $fileContent;
		else:
			return '';
		endif;
	}
	
	public function imageManupulation($filePath,$dim = NULL,$no_more = TRUE,$user_width = NULL,$user_height = NULL,$create_thumb = FALSE){
		
		if(is_file($filePath)):
			list($width,$height,$type) = getimagesize($filePath);
			if(!is_null($user_width) && !is_null($user_height)):
				if($no_more === TRUE):
					if($width > $user_width):
						$width = $user_width;
					endif;
					if($height > $user_height):
						$height = $user_height;
					endif;
				else:
					$width = $user_width;
					$height = $user_height;
				endif;
			endif;
			if(is_null($dim)):
				if($width > $height):
					$dim = 'width';
				else:
					$dim = 'height';
				endif;
			endif;
			if($create_thumb === TRUE):
				$width = round(($width*THUMBNAIL_PERCENT)/100,0);
				$height = round(($height*THUMBNAIL_PERCENT)/100,0);
				$max_width = (!is_null($user_width))?$user_width:BASE_THUMBNAIL_WIDTH;
				$max_height = (!is_null($user_height))?$user_height:BASE_THUMBNAIL_HEIGHT;
				if($width < $max_width):
					$width = $max_width;
				endif;
				if($height < $max_height):
					$height = $max_height;
				endif;
			else:
				if($width > BASE_WIDTH && $no_more === FALSE):
					$width = BASE_WIDTH;
				endif;
				if($height > BASE_HEIGHT && $no_more === FALSE):
					$height = BASE_HEIGHT;
				endif;
			endif;
			$this->load->library('image_lib');
			$this->image_lib->clear();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $filePath;
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['master_dim'] = $dim;
			$config['width'] = $width;
			$config['height'] = $height;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			return TRUE;
		else:
			return FALSE;
		endif;
		
	}
	
	public function CropToSquare(){
		
		$arguments = &func_get_args();
		$fileName = (isset($arguments[0]['filepath']))?$arguments[0]['filepath']:NULL;
		$edgeWidth = (isset($arguments[0]['edgeSize']))?$arguments[0]['edgeSize']:800;
		$copy = (isset($arguments[0]['copy']))?TRUE:FALSE;
		
		if(!is_null($fileName) && is_file($fileName)):
			$this->load->library('images');
			$newFile = FALSE;
			if($copy === TRUE):
				$this->load->helper('string');
				$newFile = getcwd().'/download/tmp/'.random_string('alnum',12).'.tmp';
			endif;
			if($this->images->cropToSquare($fileName,$edgeWidth,$edgeWidth,$newFile)):
				if($copy === TRUE):
					return $newFile;
				else:
					return TRUE;
				endif;
			endif;
		endif;
		return FALSE;
	}
	
	public function validationUploadImage(){
		
		$arguments = &func_get_args();
		$fileName = (isset($arguments[0]['file_name']))?$arguments[0]['file_name']:NULL;
		$minWidth = (isset($arguments[0]['min_width']))?$arguments[0]['min_width']:NULL;
		$onlyWide = (isset($arguments[0]['only_wide']))?$arguments[0]['only_wide']:FALSE;
		$maxSize = (isset($arguments[0]['max_size']))?$arguments[0]['max_size']:NULL;
		$return = array('status'=>FALSE,'response'=>'Нет ошибок');
		if(!is_null($fileName) && is_file($fileName)):
			$fileSize = getimagesize($fileName);
			$acceptedTypes = array('image/png','image/jpeg','image/gif');
			if(array_search($fileSize['mime'],$acceptedTypes) != FALSE):
				if(!is_null($minWidth)):
					if($fileSize[0] >= $minWidth):
						$return['status'] = TRUE;
					else:
						$return['status'] = FALSE;
						$return['response'] = 'Ширина меньше '.$minWidth.'px';
					endif;
				endif;
				if($return['status'] == TRUE && $onlyWide == TRUE):
					if($fileSize[0] > $fileSize[1]):
						$return['status'] = TRUE;
					else:
						$return['status'] = FALSE;
						$return['response'] = 'Ширина меньше высоты';
					endif;
				endif;
				if($return['status'] == TRUE && !is_null($maxSize)):
					if(filesize($fileName) < $maxSize):
						$return['status'] = TRUE;
					else:
						$return['status'] = FALSE;
						$return['response'] = 'Размер более '.round($maxSize/1048576).'Мб';
					endif;
				endif;
			endif;
		endif;
		return $return;
	}
	
	public function uploadSingleImage($uploadPath = NULL){
		
		$uploadStatus = array('status'=>FALSE,'message'=>'','uploadData'=>array());
		if(is_null($uploadPath) || ($this->createDir($uploadPath) === FALSE)):
			$uploadPath = NULL;
		endif;
		if(!is_null($uploadPath)):
			if(!empty($_FILES)):
				$this->load->library('upload');
				$this->load->helper('string');
				$config = array();
				$config['upload_path'] = $uploadPath.'/';
				$config['allowed_types'] = ALLOWED_TYPES_IMAGES;
				$config['remove_spaces'] = TRUE;
				$config['overwrite'] = TRUE;
				$config['max_size'] = 5120;
				$config['file_name'] = random_string('nozero',12).'.'.substr(strrchr($_FILES['file']['name'], '.'),1);
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('file')):
					$uploadStatus['message'] = $this->load->view('html/print-error',array('alert_header'=>'Файл: '.$_FILES['file']['name'],'message'=>$this->upload->display_errors()),TRUE);
				else:
					$uploadStatus['uploadData'] = $this->upload->data();
					$uploadStatus['status'] = TRUE;
				endif;
			endif;
		endif;
		return $uploadStatus;
	}
	
	public function uploadSingleDocument($uploadPath = NULL,$document = 'file',$allowed_types = ALLOWED_TYPES_DOCUMENTS){
		
		$uploadStatus = array('status'=>FALSE,'message'=>'','uploadData'=>array());
		if(is_null($uploadPath) || ($this->createDir($uploadPath) === FALSE)):
			$uploadPath = NULL;
		endif;
		if(!is_null($uploadPath)):
			if(!empty($_FILES)):
				$this->load->library('upload');
				$config = array();
				$config['upload_path'] = $uploadPath.'/';
				$config['allowed_types'] = $allowed_types;
				$config['remove_spaces'] = TRUE;
				$config['overwrite'] = FALSE;
				$config['max_size'] = 50000;
				$config['file_name'] = $this->translite(substr($_FILES[$document]['name'],0,strripos($_FILES[$document]['name'],'.'))).'.'.substr(strrchr($_FILES[$document]['name'],'.'),1);
				$this->upload->initialize($config);
				if(!$this->upload->do_upload($document)):
					$uploadStatus['message'] = $this->load->view('html/print-error',array('alert_header'=>'Файл: '.$_FILES[$document]['name'],'message'=>$this->upload->display_errors()),TRUE);
				else:
					$uploadStatus['uploadData'] = $this->upload->data();
					$uploadStatus['status'] = TRUE;
				endif;
			endif;
		endif;
		return $uploadStatus;
	}
	
	public function filedelete($file = NULL){
		
		if(!is_null($file) && is_file($file)):
			@unlink($file);
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	public function dirDelete($dir = NULL){
		
		if(!is_null($dir) && is_dir($dir)):
			return rmdir($dir);
		endif;
		return FALSE;
	}

	public function translite($string){
		
		$rus = array("1","2","3","4","5","6","7","8","9","0","ё","й","ю","ь","ч","щ","ц","у","к","е","н","г","ш","з","х","ъ","ф","ы","в","а","п","р","о","л","д","ж","э","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","С","М","И","Т","Б"," ");
		$eng = array("1","2","3","4","5","6","7","8","9","0","yo","iy","yu","","ch","sh","c","u","k","e","n","g","sh","z","h","","f","y","v","a","p","r","o","l","d","j","е","ya","s","m","i","t","b","Yo","Iy","Yu","CH","","SH","C","U","K","E","N","G","SH","Z","H","","F","Y","V","A","P","R","O","L","D","J","E","YA","S","M","I","T","B","-");
		$string = str_replace($rus,$eng,$string);
		if(!empty($string)):
			$string = preg_replace('/[^a-z0-9-]/','',strtolower($string));
			$string = preg_replace('/[-]+/','-',$string);
			$string = preg_replace('/[\.]+/','.',$string);
			return $string;
		else:
			return FALSE;
		endif;
	}

	public function postDataValidation($rules){
		
		$this->load->library('form_validation');
		return $this->form_validation->run($rules);
	}
	
	public function createDir($path){
		
		if(!file_exists($path) && !is_dir($path)):
			return mkdir($path,0775,TRUE);
		else:
			return TRUE;
		endif;
	}

	public function insertItem(){
		
		$arguments = &func_get_args();
		$insert = (isset($arguments[0]['insert']))?$arguments[0]['insert']:NULL;
		$model = (isset($arguments[0]['model']))?$arguments[0]['model']:NULL;
		$translit = (isset($arguments[0]['translit']))?$arguments[0]['translit']:NULL;
		unset($arguments);
		if(!is_null($insert) && is_array($insert)):
			if(!is_null($translit)):
				$insert['translit'] = $this->translite($translit);
			endif;
			if(!is_null($model)):
				$this->load->model($model);
				return $this->$model->insertRecord($insert);
			endif;
		endif;
		return FALSE;
	}
	
	public function updateItem(){
		
		$arguments = &func_get_args();
		$update = (isset($arguments[0]['update']))?$arguments[0]['update']:NULL;
		$model = (isset($arguments[0]['model']))?$arguments[0]['model']:NULL;
		$translit = (isset($arguments[0]['translit']))?$arguments[0]['translit']:NULL;
		unset($arguments);
		if(!is_null($update) && is_array($update)):
			if(!is_null($translit)):
				$update['translit'] = $this->translite($translit);
			endif;
			if(!is_null($model)):
				$this->load->model($model);
				return $this->$model->updateRecord($update);
			endif;
		endif;
		return FALSE;
	}
	
	public function getCurlLink($url){
		
		$ch = curl_init($url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_HEADER,0);
		$result = curl_exec($ch);
		curl_close($ch);
		if($result === FALSE):
			return file_get_contents($url);
		else:
			return $result;
		endif;
	}

	public function getValuesInArray($array,$value = 'id'){
		
		$ids = array();
		for($i=0;$i<count($array);$i++):
			$ids[] = $array[$i][$value];
		endfor;
		return $ids;
	}
	
	public function TranspondIDtoIndex($array,$delete_field = TRUE,$field = 'id'){
		
		if(!empty($array)):
			$TmpIDs = array();
			for($i=0;$i<count($array);$i++):
				$TmpIDs[$array[$i][$field]] = $array[$i];
			endfor;
			$ids = array();
			if($delete_field):
				foreach($TmpIDs as $key => $values):
					unset($values[$field]);
					$ids[$key] = $values;
				endforeach;
			else:
				$ids = $TmpIDs;
			endif;
			return $ids;
		endif;
		return NULL;
	}
	
	public function reIndexArray($array){
		
		$newArray = array();
		foreach($array as $key => $value):
			$newArray[] = $value;
		endforeach;
		return $newArray;
	}
	
	public function getFileUploadErrorMessage($FileData){
		
		if(isset($FileData['name'])):
			$responseText = 'Файл: '.$FileData['name'].' не загружен.';
			if($FileData['error'] == 1):
				$responseText .= '<br/>Размер принятого файла превысил максимально допустимый размер';
			elseif($FileData['error'] == 3):
				$responseText .= '<br/>Загружаемый файл был получен только частично';
			elseif($FileData['error'] == 4):
				$responseText .= '<br/>Отсутствует файл для загрузки';
			endif;
			return $responseText;
		endif;
		return '';
	}
	
	public function getDBRecordsIDs($courses,$field = 'id'){
		
		$ids = array();
		for($i=0;$i<count($courses);$i++):
			$ids[] = $courses[$i][$field];
		endfor;
		return $ids;
	}
	
	/* -------------------------------------------------------------------------------------------- */
	
	public function getProductKeyWords($publication){
		
		$this->load->model('keywords');
		if($KeyWords = $this->keywords->getProductKeyWords($publication)):
			for($i=0;$i<count($KeyWords);$i++):
				$KeyWordsList[] = $KeyWords[$i]['word'];
			endfor;
			return implode(', ',$KeyWordsList);
		endif;
		return '';
	}

	public function getAuthorsByIDs($authors){
		
		$authorsList = array();
		if($authorsIDs = explode(',',$authors)):
			$this->load->model('authors');
			$authorsList = $this->authors->getAuthorsByIDs($authorsIDs);
		endif;
		return $authorsList;
	}
}