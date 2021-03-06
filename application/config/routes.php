<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "guests_interface";
$route['404_override'] = '';
/***************************************************** GENERAL INTRERFACE *************************************************/
$route['admin'] = "general_interface/signIN";
$route['login-in'] = "general_interface/loginIn";
$route['log-off'] = "general_interface/logoff";
$route['redactor/upload'] = "general_interface/redactorUploadImage";
$route['redactor/get-uploaded-images'] = "general_interface/redactorUploadedImages";
$route['publications/view-document/:any'] = "general_interface/showDocumentIco";
$route['load-image/avatar/:num'] = "general_interface/loadimage";
/********** search *************/
$route['search-authors-list'] = "general_interface/searchAuthor";
/*******************************/
/********** sing in by social network *************/
$route['sign-in/vk'] = "general_interface/signInVK";
$route['sign-in/facebook'] = "general_interface/signInUpFacebook";
/*************************************************/
/*************************************************** AJAX INTRERFACE ***********************************************/
$route['get-authors-list'] = "ajax_interface/getAuthorsList";
$route['get-keywords-list'] = "ajax_interface/getKeyWordsList";
$route['send-publication-comment'] = "ajax_interface/sendPublicationComment";
/*********************************************/
$route['edit/issue/exec-script-2'] = "ajax_interface/execScript2";
/****************** pages ********************/
$route[ADMIN_START_PAGE.'/comment/update'] = "ajax_interface/updateComment";
$route[ADMIN_START_PAGE.'/comment/remove'] = "ajax_interface/removeComment";
/****************** pages ********************/
$route[ADMIN_START_PAGE.'/page/:any/update'] = "ajax_interface/updatePage";
$route[ADMIN_START_PAGE.'/pages/:any/upload/resource'] = "ajax_interface/pageUploadResources";
$route[ADMIN_START_PAGE.'/page/remove/resource'] = "ajax_interface/removePageResource";
$route[ADMIN_START_PAGE.'/page/caption/resource'] = "ajax_interface/pageCaptionSave";
/***************institutions *******************/
$route[ADMIN_START_PAGE.'/institutions/insert'] = "ajax_interface/insertInstitution";
$route[ADMIN_START_PAGE.'/institutions/update'] = "ajax_interface/updateInstitution";
$route[ADMIN_START_PAGE.'/institutions/remove'] = "ajax_interface/removeInstitution";
/****************** authors ********************/
$route[ADMIN_START_PAGE.'/authors/insert'] = "ajax_interface/insertAuthor";
$route[ADMIN_START_PAGE.'/authors/update'] = "ajax_interface/updateAuthor";
$route[ADMIN_START_PAGE.'/authors/remove'] = "ajax_interface/removeAuthor";
/****************** issues ********************/
$route[ADMIN_START_PAGE.'/issues/insert'] = "ajax_interface/insertIssue";
$route[ADMIN_START_PAGE.'/issues/update'] = "ajax_interface/updateIssue";
$route[ADMIN_START_PAGE.'/issues/remove'] = "ajax_interface/removeIssue";
/*************** publications *****************/
$route[ADMIN_START_PAGE.'/publications/insert'] = "ajax_interface/insertPublication";
$route[ADMIN_START_PAGE.'/publications/update'] = "ajax_interface/updatePublication";
$route[ADMIN_START_PAGE.'/publications/remove'] = "ajax_interface/removePublication";
$route[ADMIN_START_PAGE.'/publications/upload/resources'] = "ajax_interface/uploadResourcePublication";
$route[ADMIN_START_PAGE.'/publications/remove/resources'] = "ajax_interface/resourceDeletePublications";
$route[ADMIN_START_PAGE.'/publications/resources/caption'] = "ajax_interface/resourceCaptionSavePublications";

$route[ADMIN_START_PAGE.'/password-save'] = "ajax_interface/adminSavePassword";
/*************************************************** ADMIN INTRERFACE ***********************************************/
$route[ADMIN_START_PAGE] = "admin_interface/controlPanel";
$route[ADMIN_START_PAGE.'/password'] = "admin_interface/changePassword";
$route[ADMIN_START_PAGE.'/issue/:num/download-xml'] = "admin_interface/createXML";
/* ----------------------------------------------- Pages ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/comments(\/:any)*?'] = "admin_interface/commentsList";
$route[ADMIN_START_PAGE.'/comments/edit'] = "admin_interface/editComments";
/* ----------------------------------------------- Pages ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/pages'] = "admin_interface/pagesList";
$route[ADMIN_START_PAGE.'/pages/:any/edit'] = "admin_interface/editPages";
/* --------------------------------------------- Institutions ------------------------------------------------------ */
$route[ADMIN_START_PAGE.'/institutions'] = "admin_interface/institutionsList";
$route[ADMIN_START_PAGE.'/institutions/add'] = "admin_interface/insertInstitution";
$route[ADMIN_START_PAGE.'/institutions/edit'] = "admin_interface/editInstitution";
/* ----------------------------------------------- Authors ---------------------------------------------------------- */
$route[ADMIN_START_PAGE.'/authors(\/:any)*?'] = "admin_interface/authorsList";
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
$route[ADMIN_START_PAGE.'/publications/resources'] = "admin_interface/resourcesPublications";
/*************************************************** GUEST INTRERFACE ***********************************************/
$route['issue/publication/:any'] = "guests_interface/publication";
$route['issue/publication/:any/bibtext'] = "guests_interface/publicationBibText";
$route['issues'] = "guests_interface/issues";
$route['issue/:any'] = "guests_interface/issue";

$route['publication/get-resource'] = "guests_interface/getFileResource";
$route['publication/get-publication'] = "guests_interface/getFilePublication";

$route['authors'] = "guests_interface/authors";
$route['keywords'] = "guests_interface/keywords";
$route['search'] = "guests_interface/search";
$route['author/:any/:num'] = "guests_interface/author";

$route['/|for-authors|editorial|institutions|usefull-links'] = "guests_interface/pages";

//$route['reviews(\/:any)*?'] = "guests_interface/reviews";