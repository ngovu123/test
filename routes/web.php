<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// user auth
Auth::routes();

// admin auth
Route::GET ('admin/login',['as'=> 'getlogin','uses'=> 'AdminAuth\LoginController@showLoginForm']);               
Route::POST('admin/login', ['as'=>'postlogin','uses'=>'AdminAuth\LoginController@login']);                      
Route::POST('admin/logout',['as'=>'adminlogout', 'uses'=>'AdminAuth\LoginController@logout']);      
Route::POST('admin/password/email', ['as'=>'sendmaillinkreset', 'uses'=>'AdminAuth\ForgotPasswordController@sendResetLinkEmail']);
Route::GET('admin/password/reset',  ['as'=>'getpasswordreset','uses'=>'AdminAuth\ForgotPasswordController@showLinkRequestForm']);
Route::POST('admin/password/reset', ['as'=>'postpasswordreset','uses'=>'AdminAuth\ResetPasswordController@reset']);           
Route::GET('admin/password/reset/{token} ', ['as'=>'getreset','uses'=>'AdminAuth\ResetPasswordController@showResetForm']); 

// paypal controller 
Route::resource('payment', 'PaymentController');

Route::pattern('page', '[0-9]+');

// **********	LOADMORE ROUTE *********//
Route::get('/loadmore/{pageNumber}', 'PagesController@loadmore');

Route::get('/loadmoredownload/{pageNumber}', 'DownloadController@loadmore');
Route::get('/loadmorecategories/{pageNumber}/{url_slug}', 'CategoriesController@loadmore');


// **********	HOME/ROOT ROUTE *********//
Route::get('/{page?}', 'PagesController@home');
Route::get('/home', 'PagesController@home');
Route::get('/latest', 'PagesController@home');
Route::get('/popular', 'PagesController@popular');
Route::post('/like/{id}', 'PagesController@like');
Route::post('/bookmarks/{id}', 'PagesController@bookmarks');
Route::post('/report/{id}', 'PagesController@report');
Route::post('/msg/{id}', 'PagesController@msg');
Route::post('/search', 'PagesController@seacrh');
Route::get('/rss', 'PagesController@rss');
Route::get('/rules', 'PagesController@rules');

// **********	DOWNLOAD ROUTES  ********** //
Route::get('/downloadpage/{id}/{slug}', [
    'as' => 'downloadpage', 'uses' => 'DownloadController@index'
]);
Route::get('/countdownload/{id}', [
    'as' => 'countdownload', 'uses' => 'DownloadController@countdownload'
]);
Route::get('/imgdownload/{id}', [
    'as' => 'imgdownload', 'uses' => 'DownloadController@download'
]);
Route::get('/afterdownload/{id}', [
    'as' => 'afterdownload', 'uses' => 'DownloadController@afterdownload'
]);

Route::get('/tags/{tagname}', 'TagsController@tags');

Route::get('/category/{url_slug}', 'CategoriesController@showcategory');

// **********	ABOUT ROUTES  ********** //
Route::get('/about', [
	'as' => 'about', 'uses' => 'AboutController@index'
]);

// **********	CONTACT ROUTES  ********** //
Route::get('/contact', [
	'as' => 'contact', 'uses' => 'ContactController@index'
]);
Route::post('/sendcontact',['as'=>'sendcontact','uses'=>'ContactController@sendcontact']);
// find more upload by user

Route::get('users/{slug}/{id}', 'MemberController@findmore');

Auth::routes();

Route::get('/member',['as'=>'memhome', 'uses'=>'HomeController@index']) ;
Route::get('/member/uploads', 'HomeController@getuploads');
Route::post('/member/uploads', 'HomeController@postuploads');

Route::post('member/uploadimg', 'HomeController@uploadimgs');

Route::get('/member/media/edit/{slug}', 'HomeController@showeditmedia');
Route::post('/member/media/uploads/{slug}', 'HomeController@editmedia');

Route::get('/member/delete/{id}', 'HomeController@delete');

Route::get('/member/profile',['as'=>'profile','uses'=>'HomeController@getprofile']);
Route::post('/member/profile', 'HomeController@postprofile');

Route::get('/member/history', 'HomeController@gethistory');
Route::post('/member/history', 'HomeController@posthistory');

Route::get('/member/download', 'HomeController@download');
Route::post('/member/download', 'HomeController@download');

Route::get('/member/statistical', ['as'=>'getstatistical', 'uses'=>'HomeController@getstatistical']);

Route::get('/member/bookmarks', ['as'=>'mask', 'uses'=>'HomeController@bookmarks']);

Route::post('/member/bookmarks', 'HomeController@bookmarks');
Route::get('/member/unmask/{id}', ['as' => 'unmask', 'uses' => 'HomeController@unmask']);
// payment
Route::get('/member/pay', ['as' => 'getpay', 'uses' => 'HomeController@pay']);
Route::get('/member/pay/cancel/{id}', ['as' => 'cancelpay', 'uses' => 'HomeController@cancel']);
Route::get('/member/pay/new', ['as' => 'getnewpay', 'uses' => 'HomeController@new']);
Route::post('/member/pay/new', ['as' => 'postnewpay', 'uses' => 'HomeController@postnew']);

// msg member 
Route::get('/member/msg', ['as' => 'msg', 'uses' => 'HomeController@msg']);
Route::get('/member/msg/{id}',['as'=>'msg_detail','uses' => 'HomeController@msg_detail']);
Route::post('/member/msg/{id}',['as'=>'tmsg_detail','uses' => 'HomeController@reply']);
Route::post('/member/msg/del/{id}',['as'=>'getlistmsg_del','uses' => 'HomeController@msg_del']);
Route::get('/member/msg/delete/{id}',['as'=>'delete_inbox','uses' => 'HomeController@remove_msg']);


 //============================== back-end ==========================================

Route::get('/admin', 'AdminHomeController@index');

// ***  Media Route  *** //
	Route::get('/admin/media', [
		'as' => 'media', 'uses' => 'AdminHomeController@media'
	]);
	Route::get('admin/media/add', 'AdminHomeController@showaddmedia');
	Route::post('admin/media/add', 'AdminHomeController@addnewmedia');
	Route::post('admin/media/uploadimg', 'AdminHomeController@uploadimgs');

	Route::get('admin/media/edit/{slug}', [
		'as' => 'editmedia', 'uses' => 'AdminHomeController@showeditmedia'
	]);
	Route::post('/admin/media/edit/{slug}', 'AdminHomeController@editmedia');
	//Route::get('/admin/delete/{id}', 'AdminHomeController@delete');
	Route::get('/admin/delete/{id}', [
		'as' => 'mediadelete', 'uses' => 'AdminHomeController@delete'
	]);

	// check media upload by member
	Route::get('admin/media/check',['as'=>'checkmedia','uses'=>'AdminHomeController@getcheckmedia']);
	Route::post('admin/media/check', 'AdminHomeController@postgetcheckmedia');

	Route::get('/admin/approved/{id}', ['as' => 'approved', 'uses' => 'AdminHomeController@Approved']);
	// report manager
	Route::get('/admin/report',['as'=>'getlistreport','uses' => 'AdminHomeController@report']);
	Route::get('/admin/report/cancel/{id}',['as'=>'cancelrp','uses' => 'AdminHomeController@report_cancel']);
	// mesager 
	Route::get('/admin/msg',['as'=>'getlistmsg','uses' => 'AdminHomeController@msg']);
	Route::get('/admin/msg/{id}',['as'=>'getlistmsg_detail','uses' => 'AdminHomeController@msg_detail']);
	Route::post('/admin/msg/{id}',['as'=>'getlistmsg_detail','uses' => 'AdminHomeController@reply']);
	Route::post('/admin/msg/del/{id}',['as'=>'getlistmsg_del','uses' => 'AdminHomeController@msg_del']);
	Route::get('/admin/msg/delete/{id}',['as'=>'delete_inbox','uses' => 'AdminHomeController@remove_msg']);
	// payment process
	Route::get('/admin/pay/',['as'=>'admingetpay','uses' => 'AdminHomeController@getpay']);
	Route::get('/admin/pay/cancel/{id}', ['as' => 'admincancelpay', 'uses' => 'AdminHomeController@cancel']);
	Route::get('/admin/pay/done/{id}', ['as' => 'admindonepay', 'uses' => 'AdminHomeController@done']);


// ***  About Route  *** //

	Route::get('/admin/about', [
		'as' => 'about', 'uses' => 'AdminHomeController@showadminabout'
	]);
	Route::post('/admin/about', 'AdminHomeController@updateabout');
// rules
	Route::get('/admin/rules', [
		'as' => 'rules', 'uses' => 'AdminHomeController@showrules'
	]);
	Route::post('/admin/rules', 'AdminHomeController@updaterules');
	
	// ***  Settings Route  *** //
	Route::get('/admin/settings', [
		'as' => 'settings', 'uses' => 'AdminHomeController@showsettings'
	]);
	Route::post('/admin/settings', 'AdminHomeController@postsettings');

	// ***  Categories Route  *** //
	Route::get('/admin/categories', ['as' => 'getcategories', 'uses' => 'AdminHomeController@showcategories']);
	Route::post('admin/categories', 'AdminHomeController@addcategory');
	Route::get('/admin/category/edit/{url_slug}', 'AdminHomeController@showcategory');
	Route::post('/admin/category/edit/{id}', 'AdminHomeController@editcategory');
	Route::get('/admin/category/delete/{id}', 'AdminHomeController@deletecategory');

	// admin member manager
	Route::get('/admin/members',['as'=>'members','uses'=>'AdminHomeController@showmember']);
