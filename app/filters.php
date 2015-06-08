<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			Session::set('rURL', Request::fullUrl());
			if(Session::get('rURL') == 'http://gitmit.co.uk/public/logout'){
				Session::forget('rURL');
			}
			return Redirect::action('HomeController@login')
							->with('top-message', 'You need to be logged in to view that page.');
		}
	}
	if(Session::get('rURL') == 'http://gitmit.co.uk/public/logout'){
		Session::forget('rURL');
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('redirect', function()
{
	if(Session::get('rURL') == 'http://gitmit.co.uk/public/logout'){
		Session::forget('rURL');
	}
});
/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) {
		if(Auth::user()->role_id == '3'){ //
			return Redirect::away(Session::get('rURL', route('work.index')))
	    		->with('top-message', 'You are already logged in!');
		}else{
			return Redirect::away(Session::get('rURL', route('work.create')))
	    		->with('top-message', 'You are already logged in!');
		}
	}
});

Route::filter('salesperson', function()
{
	if (Auth::check()) {
		if(Auth::user()->role_id == '3'){ //
			return Redirect::away(Session::get('rURL', route('work.index')))
	    		->with('top-message', 'You do not have permission to view that page!');
		}
	}
});

Route::filter('admin', function()
{
	if (Auth::check()) {
		if(Auth::user()->role_id == '3'){ //
			return Redirect::away(Session::get('rURL', route('work.index')))
	    		->with('top-message', 'You do not have permission to view that page!');
		}else if(Auth::user()->role_id == '2'){
			return Redirect::away(Session::get('rURL', route('work.create')))
	    		->with('top-message', 'You do not have permission to view that page!');
		}
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|------------------------------------------------------------------------------
| Logging Filter
|------------------------------------------------------------------------------
*/

Route::filter('logging', function()
{
	if(Auth::check()){
		$user = Auth::user()->id;
	}else {
		$user = 0;	//should nt happen but here just in case
	}

	$all =  print_r(Input::all(), true);
	$all = is_array($all) == true ? $all : array($all);
	$logging = new Logging;
	$logging->user = $user;
	$logging->ip = Request::server('REMOTE_ADDR');
	$logging->url = Request::fullUrl();
	$logging->all = implode( ", ", $all);
	$logging->save();
});

//Email errors to stephen.miles@mortonwinsor.co.uk

Log::listen(function($level, $message, $context)
{
    //
    
		
});