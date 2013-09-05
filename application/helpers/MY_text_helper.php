<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	function unichr($symbol){
		return mb_convert_encoding('&#'.intval($symbol).';','UTF-8','HTML-ENTITIES');
	}
	
	function getTranslit($text){
		
		$CI = & get_instance();
		return $CI->translite($text);
	}
	
	function pluralPublications($n,$langURL){
		
		$language[RUSLAN] = array('публикация','публикации','публикаций');
		$language[ENGLAN] = array('publication','publications','publications');
		
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $language[$langURL][2];
		if ($n1 > 1 && $n1 < 5) return $language[$langURL][1];
		if ($n1 == 1) return $language[$langURL][0];
		return $language[$langURL][2];
	}
?>