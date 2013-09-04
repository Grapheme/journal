<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	function unichr($symbol){
		return mb_convert_encoding('&#'.intval($symbol).';','UTF-8','HTML-ENTITIES');
	}
	
	function pluralBrends($n,$langURL){
		
		$language[RUSLAN] = array('фабрика','фабрики','фабрик');
		$language[ENGLAN] = array('factory','factories','factories');
		
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $language[$langURL][2];
		if ($n1 > 1 && $n1 < 5) return $language[$langURL][1];
		if ($n1 == 1) return $language[$langURL][0];
		return $language[$langURL][2];
	}
?>