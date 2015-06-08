<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$users = User::all();

		return View::make('users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$roles = Role::lists('name', 'id');

		return View::make('users.create', array('roles' => $roles));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validator = Validator::make($data = array_except(Input::all(), array('_token')), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['password'] = Hash::make($data['password']);
		$data['created_by'] = Auth::user()->id;
		$data['updated_by'] = Auth::user()->id;

		User::create($data);

		return Redirect::route('users.index');
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$user = User::with(array('role'))
						->findOrFail($id);

		$work = Job::leftJoin('job_equipment', 'jobs.id', '=', 'job_equipment.job_id')
						->selectRaw('jobs.*')
						->where(function($sql) use ($id)
						{
							$sql->whereBetween('status_id', array('2', '3'));
							$sql->orWhere('status_id', '=', '5');
						})
						->where('job_equipment.user_id', '=', $id)
						->with(array('customer', 'status', 'equipments', 'equipments.equip_type'))
						->groupBy('jobs.id')
						->orderBy('jobs.created_at')
						->get();

		return View::make('users.show', array_merge(compact('user'), array('work' => $work)));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$user = User::findOrFail($id);

		$roles = Role::lists('name', 'id');

		return View::make('users.edit', array_merge(compact('user'), array('roles' => $roles)));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$user = User::find($id);

		$validator = Validator::make($data = array_except(Input::all(), array('_token', 'username')), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['password'] = Hash::make($data['password']);
		$data['updated_by'] = Auth::user()->id;

		$user->update($data);

		return Redirect::route('users.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}