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

Route::get('/', 'MainController@index');
Route::get('/home', 'MainController@index');
Route::get('/tags/{ctr}', 'MainController@tagsId');
Route::get('/category/{ctr}', 'MainController@ctrId');
Route::get('/popular', 'MainController@popular');
Route::get('/fresh', 'MainController@fresh');
Route::get('/trending', 'MainController@trending');
Route::get('/search/{ctr}', 'MainController@search');
Route::get('/search', 'MainController@searchNormal');
Route::get('/story/{id}', 'StoryController@story')->where(['id' => '[0-9]+']);
Route::get('/story/{id}/{title}', 'StoryController@story')->where(['id' => '[0-9]+']);
Route::get('/s/{id}', 'StoryController@story')->where(['id' => '[0-9]+']);

/*user*/
Route::get('/user/{iduser}', 'ProfileController@story')->where(['iduser' => '[0-9]+']);
Route::get('/u/{iduser}', 'ProfileController@story')->where(['iduser' => '[0-9]+']);

/*story*/
Route::get('/story/all', 'StoryController@allStory');

/*loves*/
Route::post('/loves/add', 'StoryController@addLoves');

/*comment*/
Route::get('/get/comment/{idstory}/{offset}/{limit}', 'CommentController@get')->where(['idstory' => '[0-9]+']);

Auth::routes();
Route::middleware('auth')->group(function() {
    /*user*/
    Route::get('/user/{iduser}/following', 'FollowController@following')->where(['iduser' => '[0-9]+']);
    Route::get('/user/{iduser}/followers', 'FollowController@followers')->where(['iduser' => '[0-9]+']);
    Route::get('/user/{iduser}/story', 'ProfileController@story')->where(['iduser' => '[0-9]+']);
    Route::get('/user/{iduser}/save', 'ProfileController@save')->where(['iduser' => '[0-9]+']);

	/*profile*/
	Route::get('/me', 'ProfileController@profile');
    Route::get('/me/notifications', 'ProfileController@profileNotif');
    Route::get('/me/setting', 'ProfileController@profileSetting');
    Route::get('/me/setting/profile', 'ProfileController@profileSettingProfile');
    Route::get('/me/setting/password', 'ProfileController@profileSettingPassword');
    Route::get('/timelines', 'MainController@timelines');
    Route::post('/save/profile', 'ProfileController@saveProfile');
    Route::post('/save/password', 'ProfileController@savePassword');

    /*compose*/
    Route::get('/compose', 'MainController@composeStory');
    Route::get('/compose/story', 'MainController@composeStory');
    Route::post('/story/image/upload', 'ImageController@upload');
    Route::post('/story/publish', 'StoryController@publish');
    Route::get('/story/{idstory}/edit/{iduser}/{token}', 'StoryController@storyEdit');
    Route::post('/story/save/editting', 'StoryController@saveEditting');
    Route::post('/story/delete', 'StoryController@deleteStory');

    /*Follow*/
    Route::post('/follow/add', 'FollowController@add');
    Route::post('/follow/remove', 'FollowController@remove');

    /*bookmark*/
    Route::post('/add/bookmark', 'BookmarkController@add');
    Route::post('/remove/bookmark', 'BookmarkController@remove');

    /*comment*/
    Route::post('/add/comment', 'CommentController@add');
    Route::post('/delete/comment', 'CommentController@delete');

    /*notifications*/
    Route::post('/notif/story', 'NotifController@notifStory');
    Route::post('/notif/following', 'NotifController@notifFollowing');
    Route::get('/notif/cek', 'NotifController@notifCek');
    Route::get('/notif/cek/story', 'NotifController@notifCekStory');
    Route::get('/notif/cek/following', 'NotifController@notifCekFollowing');
});