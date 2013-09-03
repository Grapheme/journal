<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	function unichr($symbol){
		return mb_convert_encoding('&#'.intval($symbol).';','UTF-8','HTML-ENTITIES');
	}
?>