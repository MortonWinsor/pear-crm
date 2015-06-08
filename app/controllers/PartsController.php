<?php

class PartsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /parts
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$parts = CommonPart::all();

		return View::make('parts.index', compact('parts'));
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
		return View::make('parts.create');
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
		$validator = Validator::make($data = Input::all(), CommonPart::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['created_by'] = Auth::user()->id;
		$data['updated_by'] = Auth::user()->id;
		$part = CommonPart::create($data);

		return Redirect::route('parts.index');
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
		return Redirect::route('parts.index');
		$part = CommonPart::findOrFail($id);

		//view file is not create
		return View::make('parts.show', compact('part'));
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
		$part = CommonPart::find($id);

		return View::make('parts.edit', compact('part'));
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
		$part = CommonPart::find($id);

		$validator = Validator::make($data = Input::all(), CommonPart::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['updated_by'] = Auth::user()->id;

		$part->update($data);

		return Redirect::route('parts.index'); 
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