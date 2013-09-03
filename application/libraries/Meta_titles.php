<?php if(!defined('BASEPATH')) exit('no direct scripting allowed');

class Meta_titles {
	
	var $CI = '';
	
	public function __construct(){
		
		$this->CI = & get_instance();
	}
	
	public function getPageTitle($table = 'pages'){
		
		if($record = $this->getRecord($table)):
			return $record['page_title'];
		else:
			return '';
		endif;
	}
	
	public function getPageDescription($table = 'pages'){
		
		if($record = $this->getRecord($table)):
			return $record['page_description'];
		else:
			return '';
		endif;
	}
	
	public function getPageH1($table = 'pages'){
		
		if($record = $this->getRecord()):
			return $record['page_h1'];
		else:
			return '';
		endif;
	}
	
	public function getPageURL($table = 'pages'){
		
		if($record = $this->getRecord($table)):
			return $record['page_url'];
		else:
			return '';
		endif;
	}
	
	private function getRecord($table){
		
		$this->CI->load->model($table);
		$record = array();
		switch($this->CI->uri->total_segments()):
			case 0: $record = $this->CI->$table->getWhere(NULL,array('page_url'=>'home')); break;
			case 1: $record = $this->CI->$table->getWhere(NULL,array('page_url'=>uri_string())); break;
			default: $record = $this->CI->$table->getWhere(NULL,array('page_url'=>uri_string())); break;
		endswitch;
		return $record;
	}
}
?>