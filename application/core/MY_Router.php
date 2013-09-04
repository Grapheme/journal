<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router{
	
	function _parse_routes(){
		
		$languages = array(ENGLAN,RUSLAN);
		$uri_segments = $this->uri->segments;
		$segments = array();
		if(isset($uri_segments[0]) && array_search($uri_segments[0],$languages)):
			for($i=1;$i<count($uri_segments);$i++):
				$segments[] = $uri_segments[$i];
			endfor;
		else:
			$segments = $uri_segments;
		endif;
		$uri = implode('/', $segments);
		if(isset($this->routes[$uri])):
			return $this->_set_request(explode('/', $this->routes[$uri]));
		endif;
		foreach($this->routes as $key => $val):
			$key = str_replace(':any', '.+',str_replace(':num','[0-9]+',$key));
			if(preg_match('#^'.$key.'$#', $uri)):
				if(strpos($val,'$') !== FALSE AND strpos($key,'(') !== FALSE):
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				endif;
				return $this->_set_request(explode('/', $val));
			endif;
		endforeach;
		$this->_set_request($segments);
	}
}
?>