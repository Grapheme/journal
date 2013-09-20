<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb');
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b');
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('TEMPORARY',								'temporary');
define('PER_PAGE_DEFAULT',						10);
define('ADMIN_START_PAGE',						'admin-panel');
define('ALLOWED_TYPES_DOCUMENTS',				'doc|docx|xls|xlsx|txt|pdf|ppt|pptx|txt|text');
define('ALLOWED_TYPES_MEDIA',					'avi|mpg|mpe|mpeg|mp3');
define('ALLOWED_TYPES_IMAGES',					'jpg|gif|jpeg|png');

define('NO_AVATAR',								getcwd().'/img/icons/no-avatar.png');

define('ENGLAN',								'en');
define('RUSLAN',								'ru');
define('BASE_WIDTH',							960);
define('BASE_HEIGHT',							450);
define('BASE_THUMBNAIL_WIDTH',					120);
define('BASE_THUMBNAIL_HEIGHT',					120);
define('THUMBNAIL_PERCENT',						25);

define('ADMIN_GROUP_VALUE',						0);
define('USER_GROUP_VALUE',						1);

define('OAUTH_VK',								'https://oauth.vk.com/authorize?client_id=3867305&response_type=code&redirect_uri=');
define('OAUTH_FACEBOOK',						'https://www.facebook.com/dialog/oauth?client_id=229311657225307&response_type=code&redirect_uri=');
