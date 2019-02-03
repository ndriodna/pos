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

		Route::group(['middleware' => ['role:Admin']],function(){
			Route::resource('/role','RoleController')->except([
				'create','show','edit','update'
			]);
			Route::resource('/users','UserController')->except([
			'show'
			]);
			Route::get('/users/role/{id}','UserController@roles')->name('users.roles');
			Route::put('/users/role/{id}','UserController@setRole')->name('users.set_roles');
			Route::post('/users/permission','UserController@addPermission')->name('users.add_permission');
			Route::get('/users/role-permission','UserController@rolePermission')->name('users.role_permission');
			Route::put('/users/permission/{role}','UserController@setRolePermission')->name('users.setRolePermission');
			});

		// Route::group(['middleware' => ['permission:create ']]);
});