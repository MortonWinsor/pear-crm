<?php

class TypesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /parts
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$types = Type::all();

		return View::make('types.index', compact('types'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /parts/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('types.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /parts
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validator = Validator::make($data = Input::all(), Type::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['created_by'] = Auth::user()->id;
		$data['updated_by'] = Auth::user()->id;
		$part = Type::create($data);

		return Redirect::route('types.index');
	}

	/**
	 * Display the specified resource.
	 * GET /parts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//this should not happen
		return Redirect::route('types.index');
		$type = Type::findOrFail($id);

		//view file is not create
		return View::make('types.show', compact('type'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /parts/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$type = Type::find($id);

		return View::make('types.edit', compact('type'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /parts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$type = Type::find($id);

		$validator = Validator::make($data = Input::all(), Type::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['updated_by'] = Auth::user()->id;

		$type->update($data);

		return Redirect::route('types.index'); 
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /parts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}