<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$hook['post_controller_constructor'] = array(
	'class' => '',
	'function' => 'sess_update',
	'filename' => 'sess_update.php',
	'filepath' => 'hooks'
);