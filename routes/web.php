<?php
// Route::get('/',function(){
// 	return view('auth.login');
// });
Auth::routes();
Route::group(['middleware' => 'auth'],function(){
	Route::get('/', 'HomeController@index')->name('home');
	Route::resource('/kategori','CategoryController')->except([
	'create','show'
	]);
	Route::resource('/produk','ProductController')->except([
	'show'
	]);
	Route::resource('/role','RoleController')->except([
		'create','show','edit','update'
	]);
	Route::resource('/users','UserController')->except([
		'show'
	]);
	Route::get('/users/role/{id}','UserController@roles')->name('users.roles');
});