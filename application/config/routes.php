<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "guests_interface";
$route['404_override'] = '';

/***************************************************** GENERAL INTRERFACE *************************************************/
$route['admin'] = "general_interface/signIN";
$route['login-in'] = "general_interface/loginIn";
$route['log-off'] = "general_interface/logoff";
$route['redactor/upload'] = "general_interface/redactorUploadImage";
$route['redactor/get-uploaded-images'] = "general_interface/redactorUploadedImages";
/*************************************************** AJAX INTRERFACE ***********************************************/

/*************************************************** GUEST INTRERFACE ***********************************************/

$route['issues'] = "guests_interface/issues";
$route['authors'] = "guests_interface/authors";

$route['reviews(\/:any)*?'] = "guests_interface/reviews";
$route[':any'] = "guests_interface/pages";