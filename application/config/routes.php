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

$route['get-authors-list'] = "ajax_interface/getAuthorsList";

/****************** pages ********************/
$route[ADMIN_START_PAGE.'/page/:any/update'] = "ajax_interface/updatePage";
$route[ADMIN_START_PAGE.'/pages/:any/upload/resource'] = "ajax_interface/pageUploadResources";
$route[ADMIN_START_PAGE.'/page/remove/resource'] = "ajax_interface/removePageResource";
$route[ADMIN_START_PAGE.'/page/caption/resource'] = "ajax_interface/pageCaptionSave";
/****************** authors ********************/
$route[ADMIN_START_PAGE.'/authors/insert'] = "ajax_interface/insertAuthor";
$route[ADMIN_START_PAGE.'/authors/update'] = "ajax_interface/updateAuthor";
$route[ADMIN_START_PAGE.'/authors/remove'] = "ajax_interface/removeAuthor";
/****************** issues ********************/
$route[ADMIN_START_PAGE.'/issues/insert'] = "ajax_interface/insertIssue";
$route[ADMIN_START_PAGE.'/issues/update'] = "ajax_interface/updateIssue";
$route[ADMIN_START_PAGE.'/issues/remove'] = "ajax_interface/removeIssue";
/*************************************************** ADMIN INTRERFACE ***********************************************/
$route[ADMIN_START_PAGE] = "admin_interface/controlPanel";
/* ----------------------------------------------- Pages ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/pages'] = "admin_interface/pagesList";
$route[ADMIN_START_PAGE.'/pages/:any/edit'] = "admin_interface/editPages";
/* ----------------------------------------------- Authors ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/authors'] = "admin_interface/authorsList";
$route[ADMIN_START_PAGE.'/authors/add'] = "admin_interface/insertAuthor";
$route[ADMIN_START_PAGE.'/authors/edit'] = "admin_interface/editAuthor";
/* ----------------------------------------------- Issues ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/issues'] = "admin_interface/issuesList";
$route[ADMIN_START_PAGE.'/issues/add'] = "admin_interface/insertIssue";
$route[ADMIN_START_PAGE.'/issues/edit'] = "admin_interface/editIssue";
/* --------------------------------------------- Publications ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/publications'] = "admin_interface/publicationsList";
$route[ADMIN_START_PAGE.'/publications/add'] = "admin_interface/insertPublications";
$route[ADMIN_START_PAGE.'/publications/edit'] = "admin_interface/editPublications";
/*************************************************** GUEST INTRERFACE ***********************************************/

/*************************************************** GUEST INTRERFACE ***********************************************/
$route['issues'] = "guests_interface/issues";
$route['authors'] = "guests_interface/authors";
$route['keywords'] = "guests_interface/keywords";
$route['search'] = "guests_interface/search";
$route['author/:any/:num'] = "guests_interface/author";

$route['/|for-authors|editorial|institutions|usefull-links'] = "guests_interface/pages";

//$route['reviews(\/:any)*?'] = "guests_interface/reviews";