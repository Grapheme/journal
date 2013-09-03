<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	$config = array(
		'signin' =>array(
			array('field'=>'login','label'=>'Логин','rules'=>'required|trim'),
			array('field'=>'password','label'=>'Пароль','rules'=>'required|trim')
		),
		'page' =>array(
			array('field'=>'title','label'=>'Название','rules'=>'required|trim'),
			array('field'=>'page_url','label'=>'URL страницы','rules'=>'required|trim|alpha_dash'),
		)
		
	);
?>