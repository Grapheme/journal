<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	function url_underscore($uri_string){
		
		if(!empty($uri_string)):
			return preg_replace('/[\/ ~%.:\-]+/','_',$uri_string);
		else:
			return FALSE;
		endif;
	}
	
	function getDomainURL($url){
		$parse = parse_url($url,PHP_URL_HOST);
		return preg_replace('/(www\.)/','',$parse);
	}

	function getUrlLink(){
		
		$CI = & get_instance();
		$get = $CI->input->get();
		$getLink = '';
		if($get !== FALSE):
			$temp = array();
			foreach($get as $key => $value):
				$temp[] = $key.'='.$value;
			endforeach;
			$getLink = '?'.implode('&',$temp);
		endif;
		return $getLink;
	}

?>