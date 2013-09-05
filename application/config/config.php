<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$config['base_url'] 			= "http://localhost/journal/";
$config['index_page'] 			= '';
$config['uri_protocol']			= 'AUTO';
$config['url_suffix'] 			= '';
$config['language']				= 'russian';
$config['charset'] 				= 'UTF-8';
$config['enable_hooks'] 		= TRUE;
$config['subclass_prefix'] 		= 'MY_';
$config['permitted_uri_chars'] 	= 'a-z0-9-.';
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use
$config['log_threshold'] 		= 0;
$config['log_path'] 			= '';
$config['log_date_format'] 		= 'Y-m-d H:i:s';
$config['cache_path'] 			= '';
$config['encryption_key'] 		= '271a10b478a7027c5e11f2d049859203';
$config['sess_cookie_name']		= 'ptosnm';
$config['sess_expiration']		= 28800; //2 часа сессия
$config['sess_expire_on_close']	= TRUE;
$config['sess_encrypt_cookie']	= TRUE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']		= 'sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= $config['sess_expiration'];
$config['cookie_prefix']		= "";
$config['cookie_domain']		= "";
$config['cookie_path']			= "/";
$config['cookie_secure']		= FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] 		= FALSE;
$config['csrf_token_name'] 		= 'csrf_test_name';
$config['csrf_cookie_name'] 	= 'csrf_cookie_name';
$config['csrf_expire'] 			= 7200;
$config['compress_output'] 		= FALSE;
$config['time_reference'] 		= 'local';
$config['rewrite_short_tags'] 	= FALSE;
$config['proxy_ips'] 			= '';