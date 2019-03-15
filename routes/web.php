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

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['namespace' => 'Admin'], function () {
   // Route::any('/home', 'IndexController@index'); //后台展示界面
});
Route::group(['middleware' => ['checkLogin','check-permission'],'namespace' => 'Admin','prefix'=>'permission'], function () {
    //用户组
    Route::any('roles', ['as' => 'permission_roles', 'uses' => 'RolesController@index']);
    Route::any('roles/create', ['as' => 'permission_roles_create', 'uses' => 'RolesController@create']);
    Route::any('roles/rolelist/{id}', ['as' => 'permission_roles_rolelist', 'uses' => 'RolesController@userRoleList']);//查看用户用户组中已经有的用户
    Route::any('roles/rolepermlist', ['as' => 'permission_roles_rolepermlist', 'uses' => 'RolesController@rolePermList']); //角色权限分配列表页
    Route::any('roles/userroleadd', ['as' => 'permission_roles_userroleadd', 'uses' => 'RolesController@userRoleAdd']);//分配用户角色
    Route::any('roles/userroledel', ['as' => 'permission_roles_userroledel', 'uses' => 'RolesController@userRoleDel']);//删除用户所在用户组
    Route::post('roles/delrole', ['as' => 'permission_roles_delrole', 'uses' => 'RolesController@delRole']);//删除用户组
    Route::post('roles/updatestate', ['as' => 'permission_roles_updatestate', 'uses' => 'RolesController@roleEdit']);

    //操作节点
    Route::any('permission', ['as' => 'permission_permission', 'uses' => 'PermissionController@index']);
    Route::any('permission/store', ['as' => 'permission_permission_store', 'uses' => 'PermissionController@store']);
    Route::post('permission/delPerm', ['as' => 'permission_permission_delperm', 'uses' => 'PermissionController@delPerm']);//删除操作
    Route::any('permission/edit', ['as' => 'permission_permission_edit', 'uses' => 'PermissionController@edit']);

    //用户管理
    Route::any('users', ['as' => 'permission_users', 'uses' => 'UserController@index']);
    Route::any('user/add', ['as' => 'permission_users_add', 'uses' => 'UserController@add']);
    Route::any('users/{id}/edit', ['as' => 'permission_users_edit', 'uses' => 'UserController@edit']);
});

//根据email检测用户是否已经存在
Route::any('user/isemailexist', ['as' => 'permission_users_add', 'uses' => 'UserController@getUserByEmail']);
Route::any('captcha/{cofig?}', function(\Mews\Captcha\Captcha $captcha,$config='default'){
    return $captcha->create($config);
});





Route::group(['middleware' => ['checkLogin','check-permission'],'namespace' => 'Admin','prefix'=>'finance'], function () {
    //财务管理
    Route::any('finance', ['as' => 'finance_finance', 'uses' => 'UserController@index']);
    Route::any('finance/{id}/info', ['as' => 'finance_finance_info', 'uses' => 'UserController@index']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/logout', 'Auth\LoginController@logout');
