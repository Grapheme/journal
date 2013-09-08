<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	$config = array(
		'signin' =>array(
			array('field'=>'login','label'=>'Логин','rules'=>'required|trim'),
			array('field'=>'password','label'=>'Пароль','rules'=>'required|trim')
		),
		'page' =>array(
			array('field'=>'title','label'=>'Название','rules'=>'required|trim'),
			array('field'=>'page_url','label'=>'URL страницы','rules'=>'required|trim|alpha_dash'),
		),
		'char' =>array(
			array('field'=>'char','label'=>'char','rules'=>'required|trim'),
			array('field'=>'lang','label'=>'lang','rules'=>'trim')
		),
		'author' =>array(
			array('field'=>'ru_page_title','label'=>'Title страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_page_description','label'=>'Description страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_page_h1','label'=>'H1 страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_name','label'=>'Имя','rules'=>'trim|xss_clean'),
			array('field'=>'ru_position','label'=>'Должность','rules'=>'trim|xss_clean'),
			array('field'=>'ru_abbreviation_institution','label'=>'Аббревиатура','rules'=>'trim|xss_clean'),
			array('field'=>'ru_decipher_institution','label'=>'Раcшифровка','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_title','label'=>'Title page','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_description','label'=>'Description page','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_h1','label'=>'H1 page','rules'=>'trim|xss_clean'),
			array('field'=>'en_name','label'=>'Name','rules'=>'trim|xss_clean'),
			array('field'=>'en_position','label'=>'Position','rules'=>'trim|xss_clean'),
			array('field'=>'en_abbreviation_institution','label'=>'Abbreviation','rules'=>'trim|xss_clean'),
			array('field'=>'en_decipher_institution','label'=>'Deciphering','rules'=>'trim|xss_clean'),
			array('field'=>'email','label'=>'Email','rules'=>'valid_email|trim|xss_clean'),
			array('field'=>'ru_address','label'=>'Адрес','rules'=>'trim|xss_clean'),
			array('field'=>'en_address','label'=>'address','rules'=>'trim|xss_clean')
		),
		'institution' =>array(
			array('field'=>'ru_title','label'=>'Название','rules'=>'trim|xss_clean'),
			array('field'=>'ru_description','label'=>'Описание','rules'=>'trim|xss_clean'),
			array('field'=>'en_title','label'=>'Title','rules'=>'trim|xss_clean'),
			array('field'=>'en_description','label'=>'Description','rules'=>'trim|xss_clean'),
			array('field'=>'site_link','label'=>'Ссылка на сайт','rules'=>'prep_url|trim|xss_clean')
		),
		'issues' =>array(
			array('field'=>'ru_page_title','label'=>'Title страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_page_description','label'=>'Description страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_page_h1','label'=>'H1 страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_name','label'=>'Имя','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_title','label'=>'Title page','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_description','label'=>'Description page','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_h1','label'=>'H1 page','rules'=>'trim|xss_clean'),
			array('field'=>'en_name','label'=>'Name','rules'=>'trim|xss_clean'),
			array('field'=>'number','label'=>'Номер','rules'=>'required|trim|numeric'),
			array('field'=>'year','label'=>'Год','rules'=>'required|trim|numeric'),
			array('field'=>'month','label'=>'Месяц','rules'=>'required|trim|numeric'),
		),
		'publication' =>array(
			array('field'=>'ru_page_title','label'=>'Title страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_page_description','label'=>'Description страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_page_h1','label'=>'H1 страницы','rules'=>'trim|xss_clean'),
			array('field'=>'ru_title','label'=>'Имя','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_title','label'=>'Title page','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_description','label'=>'Description page','rules'=>'trim|xss_clean'),
			array('field'=>'en_page_h1','label'=>'H1 page','rules'=>'trim|xss_clean'),
			array('field'=>'en_title','label'=>'Name','rules'=>'trim|xss_clean'),
			array('field'=>'ru_annotation','label'=>'Аннотация','rules'=>'trim|xss_clean'),
			array('field'=>'ru_content','label'=>'Текст статьи','rules'=>'trim|xss_clean'),
			array('field'=>'ru_support','label'=>'При поддержке','rules'=>'trim|xss_clean'),
			array('field'=>'ru_bibliography','label'=>'Библиографический список','rules'=>'trim|xss_clean'),
			array('field'=>'en_annotation','label'=>'Annotation','rules'=>'trim|xss_clean'),
			array('field'=>'en_content','label'=>'Text of the publication','rules'=>'trim|xss_clean'),
			array('field'=>'en_support','label'=>'With support','rules'=>'trim|xss_clean'),
			array('field'=>'en_bibliography','label'=>'Bibliographic list','rules'=>'trim|xss_clean')
		)
		
	);
?>