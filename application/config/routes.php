<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */

$route['default_controller']   = 'home';
$route['404_override']         = '';
$route['translate_uri_dashes'] = false;

//SecureAdminPanel
$route[ADMIN_PUBLIC_DIR]                = "admin/login";
$route[ADMIN_PUBLIC_DIR . '/dashboard'] = "admin/dashboard";
$route[ADMIN_PUBLIC_DIR . '/logout']    = "admin/logout";

// // Admin Video
$route[ADMIN_MALL_DIR . 'adminpanel/video/news'] = ADMIN_MALL_CTRL . "/admin_video/news";

// Category Management
$route[ADMIN_PUBLIC_DIR . '/category/get/([a-z_-]+)']             = "admin/category_get/$1";
$route[ADMIN_PUBLIC_DIR . '/category/save/([a-z_-]+)']            = "admin/category_save/$1";
$route[ADMIN_PUBLIC_DIR . '/category/remove/([a-z_-]+)']          = "admin/category_remove/$1";
$route[ADMIN_PUBLIC_DIR . '/category/get/([a-z_-]+)/([0-9]+)']    = "admin/category_get/$1/$2";
$route[ADMIN_PUBLIC_DIR . '/category/save/(:any)/([0-9]+)']   = "admin/category_save/$1/$2";
$route[ADMIN_PUBLIC_DIR . '/category/remove/([a-z_-]+)/([0-9]+)'] = "admin/category_remove/$1/$2";
$route[ADMIN_PUBLIC_DIR . '/category/([a-z_-]+)']                 = "admin/category/$1";
$route[ADMIN_PUBLIC_DIR . '/category/([a-z_-]+)/([0-9]+)']        = "admin/category/$1/$2";

// Basis Data Management
$route[ADMIN_PUBLIC_DIR . '/basis/get/([a-z_-]+)']                    = "admin/basis_get/$1";
$route[ADMIN_PUBLIC_DIR . '/basis/save/([a-z_-]+)']                   = "admin/basis_save/$1";
$route[ADMIN_PUBLIC_DIR . '/basis/save/([a-z_-]+)/([0-9]+)']          = "admin/basis_save/$1/$2";
$route[ADMIN_PUBLIC_DIR . '/basis/upload_attach/([a-z_-]+)/([0-9]+)'] = "admin/upload_attach/$1/$2";
$route[ADMIN_PUBLIC_DIR . '/basis/remove/([a-z_-]+)']                 = "admin/basis_remove/$1";
$route[ADMIN_PUBLIC_DIR . '/basis/([a-z_-]+)']                        = "admin/basis/$1";
$route[ADMIN_PUBLIC_DIR . '/basis/([a-z_-]+)/([0-9]+)']               = "admin/basis/$1/$2";

// Admin Management
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/add_new']                               = "admin_$1/edit";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/([a-z_-]+)']                            = "admin_$1/$2";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/([a-z_-]+)/([0-9]+)']                   = "admin_$1/$2/$3";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/([a-z_-]+)/(:any+)']                    = "admin_$1/$2/$3";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/([a-z_-]+)/([0-9]+)/([0-9]+)']          = "admin_$1/$2/$3/$4";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/([a-z_-]+)/([0-9]+)/([a-z_-]+)']        = "admin_$1/$2/$3/$4";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/([a-z_-]+)/([0-9]+)/([0-9]+)/([0-9]+)'] = "admin_$1/$2/$3/$4/$5";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)/([0-9]+)']                              = "admin_$1/index/$2";
$route[ADMIN_PUBLIC_DIR . '/([a-z_-]+)']                                       = "admin_$1";


$route[ADMIN_PUBLIC_DIR . '/video/sport']                            = "admin_video/sport";


//Frontend

//Customer Part
$route[FRONTEND_LOGIN_PUBLIC_DIR]     = "home/login";
$route[FRONTEND_LOGOUT_PUBLIC_DIR]    = "home/logout";
$route[FRONTEND_REGISTER_PUBLIC_DIR]  = "home/register";
$route[FRONTEND_USER_PROFILE_DIR]     = "home/profile";
$route[FRONTEND_USER_FORGOT_PASS_DIR] = "home/forgot_password";
$route[FRONTEND_USER_RESET_PASS_DIR]  = "home/reset_password";

$route[API_DIR] = "api";

$route['us-stock']                     = "home/usstock";
$route['article/([0-9]+)']                     = "blogs/article/$1";
$route['article_([a-z_-]+)/([0-9]+)']          = "blogs/article_$1/$2";
$route['article_([a-z_-]+)/([0-9]+)/([0-9]+)'] = "blogs/article_$1/$2/$3";

$route['weekly-circlar'] = 'saving/index';

/* Shopping Mall Management */

// Category Management
$route[ADMIN_MALL_DIR . '/category/get/([a-z_-]+)']             = ADMIN_MALL_CTRL . "/admin/category_get/$1";
$route[ADMIN_MALL_DIR . '/category/save/([a-z_-]+)']            = ADMIN_MALL_CTRL . "/admin/category_save/$1";
$route[ADMIN_MALL_DIR . '/category/remove/([a-z_-]+)']          = ADMIN_MALL_CTRL . "/admin/category_remove/$1";
$route[ADMIN_MALL_DIR . '/category/get/([a-z_-]+)/([0-9]+)']    = ADMIN_MALL_CTRL . "/admin/category_get/$1/$2";
$route[ADMIN_MALL_DIR . '/category/save/([a-z_-]+)/([0-9]+)']   = ADMIN_MALL_CTRL . "/admin/category_save/$1/$2";
$route[ADMIN_MALL_DIR . '/category/remove/([a-z_-]+)/([0-9]+)'] = ADMIN_MALL_CTRL . "/admin/category_remove/$1/$2";
$route[ADMIN_MALL_DIR . '/category/([a-z_-]+)']                 = ADMIN_MALL_CTRL . "/admin/category/$1";
$route[ADMIN_MALL_DIR . '/category/([a-z_-]+)/([0-9]+)']        = ADMIN_MALL_CTRL . "/admin/category/$1/$2";

// Basis Data Management
$route[ADMIN_MALL_DIR . '/basis/get/([a-z_-]+)']                    = ADMIN_MALL_CTRL . "/admin/basis_get/$1";
$route[ADMIN_MALL_DIR . '/basis/save/([a-z_-]+)']                   = ADMIN_MALL_CTRL . "/admin/basis_save/$1";
$route[ADMIN_MALL_DIR . '/basis/save/([a-z_-]+)/([0-9]+)']          = ADMIN_MALL_CTRL . "/admin/basis_save/$1/$2";
$route[ADMIN_MALL_DIR . '/basis/upload_attach/([a-z_-]+)/([0-9]+)'] = ADMIN_MALL_CTRL . "/admin/upload_attach/$1/$2";
$route[ADMIN_MALL_DIR . '/basis/remove/([a-z_-]+)']                 = ADMIN_MALL_CTRL . "/admin/basis_remove/$1";
$route[ADMIN_MALL_DIR . '/basis/([a-z_-]+)']                        = ADMIN_MALL_CTRL . "/admin/basis/$1";
$route[ADMIN_MALL_DIR . '/basis/([a-z_-]+)/([0-9]+)']               = ADMIN_MALL_CTRL . "/admin/basis/$1/$2";

// Admin Management
$route[ADMIN_MALL_DIR . '/([a-z_-]+)/add_new']                               = ADMIN_MALL_CTRL . "/admin_$1/edit";
$route[ADMIN_MALL_DIR . '/([a-z_-]+)/([a-z_-]+)']                            = ADMIN_MALL_CTRL . "/admin_$1/$2";
$route[ADMIN_MALL_DIR . '/([a-z_-]+)/([a-z_-]+)/([0-9]+)']                   = ADMIN_MALL_CTRL . "/admin_$1/$2/$3";
$route[ADMIN_MALL_DIR . '/([a-z_-]+)/([a-z_-]+)/([0-9]+)/([0-9]+)']          = ADMIN_MALL_CTRL . "/admin_$1/$2/$3/$4";
$route[ADMIN_MALL_DIR . '/([a-z_-]+)/([a-z_-]+)/([0-9]+)/([0-9]+)/([0-9]+)'] = ADMIN_MALL_CTRL . "/admin_$1/$2/$3/$4/$5";
$route[ADMIN_MALL_DIR . '/([a-z_-]+)/([0-9]+)']                              = ADMIN_MALL_CTRL . "/admin_$1/index/$2";
$route[ADMIN_MALL_DIR . '/([a-z_-]+)']                                       = ADMIN_MALL_CTRL . "/admin_$1";
