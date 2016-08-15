<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group( [ 'middleware' => 'sentinel.guest'], function(){

	Route::get( '/', [ 'as' => 'index', function(){ return view('new.index'); }] );
	Route::get( 'signin.html', [ 'as' => 'signin',  function(){ return view('new.signin'); }] );
	Route::get( 'signup.html', [ 'as' => 'signup', function(){ return view('new.register'); }] );
	Route::get( 'reminder.html', [ 'as' => 'reminder', function() { return view( 'new.reminder' ); }] );
	Route::post( 'reminder.html', [ 'uses' => 'mcUserController@postReminder'] );

	Route::get( 'reset.html', [ 'as' =>'reset', 'uses' => 'mcUserController@getReset' ] );
	Route::post( 'reset.html', [ 'as' =>'reset', 'uses' => 'mcUserController@postReset' ] );

	//Route::get( 'login', ['as' => 'login', 'uses' => 'mcUserController@getLogin'] );
	Route::post( 'login', ['as' => 'login', 'uses' => 'mcUserController@postLogin'] );

	//Route::get( 'register', ['as' => 'register', function(){ return view('register'); }]);
	Route::post( 'register', ['as' => 'register', 'uses' => 'mcUserController@postRegister']);
});

Route::group( [ 'middleware' => 'sentinel.auth'], function () {
	Route::get( '/home', ['as' => 'home', 'uses' => 'mcIndexController@getIndex']);
	Route::get( 'logout', ['as' => 'logout', 'uses' => 'mcUserController@getLogout'] );


/**
* keywords routes
*/
	Route::get( 'keywords', ['as' => 'settings.keywords', 'uses' => 'mcIndexController@getKeywords']);
	Route::post( 'keywords', ['as' => 'settings.keywords', 'uses' => 'mcIndexController@postKeywords']);
	Route::get( 'keywords/delete/{id}', ['as' => 'keyword.delete', 'uses' => 'mcIndexController@getDeleteKeyword'] )->where( 'id', '[0-9]+');
/**
*	comunities routes
*/
	Route::get( 'comunities', ['as' => 'settings.comunities', 'uses' => 'mcIndexController@getComunities']);
	Route::post( 'comunities', ['as' => 'settings.comunities','uses' => 'mcIndexController@postComunities']);
	Route::get( 'comunities/delete/{id}', [ 'as' =>'comunity.delete', 'uses' => 'mcIndexController@getDeleteComunity'] )->where( 'id', '[0-9]+');

	Route::get( 'proposal', ['as' => 'settings.proposal', 'uses' => 'mcIndexController@getProposals'] );
	Route::post( 'proposal', ['as' => 'settings.proposal', 'uses' => 'mcIndexController@postProposals'] );
	Route::get( 'proposal/delete/{id}', ['as' =>'proposal.delete', 'uses' => 'mcIndexController@getDeleteProposal'])->where( 'id', '[0-9]+' );

	Route::get( 'invites', [ 'as' => 'settings.invites', 'uses' => 'mcUserController@getInvites'] );

	Route::get( 'settings', ['as' => 'settings.main', 'uses' => 'mcUserController@getSettings']);
	Route::post( 'settings', ['as' => 'settings.main', 'uses' => 'mcUserController@postSettings']);

	Route::get( 'post/delete/{id}', ['as' => 'post.delete', 'uses' => 'mcIndexController@getDeletePost'] )->where( 'id', '[0-9]+' );

	Route::get( 'message/to/{id}', ['as' => 'message', 'uses' => 'mcUpdateController@getSendMessage'] )->where( 'id', '[0-9]+' );

	Route::get( 'xmpp', ['as' =>'xmpp', 'uses' => 'mcXmppController@getSendMessage'] );

//	Route::post( 'invites', ['uses' => 'mcUserController@postInvites'] );

});
	Route::get( 'update', ['as' =>'update', 'uses' => 'mcUpdateController@getData'] );

//	Route::get( 'xmpp', ['uses' => 'mcXmppController@getSendMessage'] );
//Route::get( 'mail', ['uses' => 'mcUpdateController@sendMail']);

//Route::get( 'message/{id}/{message}', ['uses' => 'mcUpdateController@sendMessage']);
