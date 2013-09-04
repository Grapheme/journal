<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_URI extends CI_URI{
	
	var $language_string = FALSE;
	
	function _set_uri_string($str){
		
		$uri_string = remove_invisible_characters($str,FALSE);
		if(!empty($uri_string) && $uri_string != '/'):
			$segments = array();
			if($uri_segments = explode('/',$uri_string)):
				$languages = array(ENGLAN,RUSLAN);
				if(isset($uri_segments[0]) && array_search($uri_segments[0],$languages) !== FALSE):
					$this->language_string = $uri_segments[0];
					for($i=1;$i<count($uri_segments);$i++):
						$segments[] = $uri_segments[$i];
					endfor;
					if(!$uri_string = implode('/',$segments)):
						$uri_string = '/';
					endif;
				endif;
			endif;
		endif;
		$this->uri_string = ($uri_string == '/')?'':$uri_string;
	}
}
?>