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
/****************** pages ********************/
$route[ADMIN_START_PAGE.'/page/:any/update'] = "ajax_interface/updatePage";
$route[ADMIN_START_PAGE.'/pages/:any/upload/resource'] = "ajax_interface/pageUploadResources";
$route[ADMIN_START_PAGE.'/page/remove/resource'] = "ajax_interface/removePageResource";
$route[ADMIN_START_PAGE.'/page/caption/resource'] = "ajax_interface/pageCaptionSave";
/*************************************************** ADMIN INTRERFACE ***********************************************/
$route[ADMIN_START_PAGE] = "admin_interface/controlPanel";
/* ------------------------------------------- Contents ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/pages'] = "admin_interface/pagesList";
$route[ADMIN_START_PAGE.'/pages/add'] = "admin_interface/insertPage";
$route[ADMIN_START_PAGE.'/pages/:any/edit'] = "admin_interface/editPages";
/*************************************************** GUEST INTRERFACE ***********************************************/

/*************************************************** GUEST INTRERFACE ***********************************************/

$route['issues'] = "guests_interface/issues";
$route['authors'] = "guests_interface/authors";
$route['keywords'] = "guests_interface/keywords";
$route['search'] = "guests_interface/search";
$route[':any'] = "guests_interface/pages";


//$route['reviews(\/:any)*?'] = "guests_interface/reviews";