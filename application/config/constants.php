<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



/* THEME DIR NAME*/
define('THEMES_DIR', 'themes/');
define('PROJECT_DIR', 'themes/withyou/');
define('PROJECT_CSS_DIR',PROJECT_DIR.'css/');
define('PROJECT_JS_DIR',PROJECT_DIR.'js/');
define('PROJECT_IMG_DIR',PROJECT_DIR.'images/');
define('PROJECT_UP_DIR',PROJECT_DIR.'uploads/');
define('PROJECT_AVATAR_DIR',PROJECT_DIR.'uploads/avatar');
define('PROJECT_MEDIA_DIR',PROJECT_DIR.'uploads/media');
define('PROJECT_BOARD_DIR',PROJECT_DIR.'uploads/boards');
define('PROJECT_PRODUCT_DIR',PROJECT_DIR.'uploads/product');
define('PROJECT_COMPANY_DIR',PROJECT_DIR.'uploads/business');
define('PROJECT_MALL_DIR',PROJECT_DIR.'uploads/mall');

/*STATIC ASSETS URL*/
define('ASSETS_DIR', 'assets/');

//ADDMIN JS/CSS/IMAGE PATHA
define('ADMIN_ASSETS_DIR',ROOTPATH.ASSETS_DIR.'adminpanel/');
define('ADMIN_CSS_DIR',ROOTPATH.ASSETS_DIR.'adminpanel/css/');
define('ADMIN_JS_DIR',ROOTPATH.ASSETS_DIR.'adminpanel/js/');
define('ADMIN_IMG_DIR',ROOTPATH.ASSETS_DIR.'adminpanel/images/');

//FRONT END JS/CSS/IMAGE PATHA
define('DEFAULT_CSS_DIR',ROOTPATH.ASSETS_DIR.'css/');
define('DEFAULT_JS_DIR',ROOTPATH.ASSETS_DIR.'js/');
define('DEFAULT_IMG_DIR',ROOTPATH.ASSETS_DIR.'images/');

define('ADMIN_LOGIN_PATH','admin');
define('SESSION_DOMAIN','withyou-com');  //donot enter (dot). here or cookie will not work
define('ADMIN_LOGIN_SESSION','admin_login');
define('USER_LOGIN_SESSION','user_login');

/*Define Admin*/
define('ADMIN_PUBLIC_DIR', 'adminpanel');
define('ADMIN_MODULE_DIR','secureAdminPanel');
define('ADMIN_LOGIN_SECURE_CODE','SecureWithyouNetControlPanel');
define('USER_LOGIN_SECURE_CODE','SecureWithyouNetFrontUser');

/* Define Frontend */
define('FRONTEND_LOGIN_PUBLIC_DIR', 'login');
define('FRONTEND_LOGOUT_PUBLIC_DIR', 'logout');
define('FRONTEND_REGISTER_PUBLIC_DIR', 'register');
define('FRONTEND_USER_PROFILE_DIR', 'profile');
define('FRONTEND_USER_FORGOT_PASS_DIR', 'forgotpassword');
define('FRONTEND_USER_RESET_PASS_DIR', 'resetpassword');

define('COOKIE_EXPIRE_TIME',86400);  //24hr
define('SYSTEM_ENCRYPTION_KEY','APANWITHYOUI1B');

/*Login*/
define('MAX_LOGIN_ATTEMPTS_CAPTCHA',5);
define('MAX_LOGIN_ATTEMPTS_BRUTEFORCE',5);
define('BRUTEFORCE_TIME_IN_SECONDS',3600);  //eg. 2hr = (2*60*60)

// Api
define('API_DIR', 'api');



// Custom Constant

define('RESTAURANT','https://www.restaurant.kpabal.com/');
define('TRADE','https://www.trade.kpabal.com/');