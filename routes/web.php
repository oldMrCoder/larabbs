<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'PagesController@root')->name('root');

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// 《个人中心页面》相关路由
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

// 代码生成器自动建立的《话题》路由
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
// 提高 SEO ，把帖子 URL 翻译成更易于被搜索引擘发现
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

// 话题分类路由
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

// 在创建新话题的《编辑器》中，上传图片
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
Route::resource('replies', 'RepliesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);