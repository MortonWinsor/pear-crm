<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	/**
	 * This is the login page
	 * GET /login
	 *
	 * @return View
	 */
	public function login()
	{
		return View::make('home.login');
	}

	/**
	 * This is the login page
	 * POST /login
	 *
	 * @return View
	 */
	public function postLogin()
	{
		// get username and password from form
		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);

		//check login details
		if (Auth::attempt($user)) {
    		if(Auth::user()->role_id == '3'){ //engineer
				return Redirect::route('work.index')
		    		->with('message', 'You are successfully logged in.');
			}else{
				if(strpos(Session::get('rURL'), 'logout') !== false){
					return Redirect::route('work.create')
		    			->with('message', 'You are successfully logged in.');
				}
				return Redirect::away(Session::get('rURL', route('work.create')))
		    		->with('message', 'You are successfully logged in.');
			}
    		        	
   	 	}

		//login failed, redirect back to login page
		return Redirect::action('HomeController@login')
			->with('message', 'Your email / password combination was incorrect.')
			->withInput();
	}

	/**
	 * This is the logout function, it redirects to home page
	 * GET /logout
	 *
	 * @return View
	 */
	public function logout()
	{
		//logout
		Auth::logout();

		//redirect
		return Redirect::action('HomeController@login')
				->with('message', 'You are successfully logged out.');
	}

	public function changeUser()
	{
		$user = User::where('role_id', '=', '3')
						->lists('username', 'id');

		return View::make('home.user', array('user' => $user));
	}

	public function user()
	{
		$user = User::find(Input::get('user'));

		Auth::login($user);

		return Redirect::route('work.index')
		    		->with('message', 'You are now logged in as ' . $user->username . '.');
	}
}
