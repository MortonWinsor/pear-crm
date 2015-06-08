<?php

class ReportsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /reports
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$users = DB::SELECT(DB::raw('SELECT SUM(job_equipment.`time`) AS total,  COUNT(job_equipment.equipment_id) AS equip, users.username, `jobs`.`status_date` FROM `jobs` LEFT JOIN `job_equipment` ON jobs.id = job_equipment.job_id LEFT JOIN users ON job_equipment.user_id = users.id  WHERE jobs.`status_date` > "'.strtotime('- 7 days', time()).'" GROUP BY `job_equipment`.`user_id`, DATE(jobs.status_date)'));
	
		$status = DB::SELECT(DB::raw('SELECT COUNT(jobs.id) AS total, job_status.name FROM `jobs` LEFT JOIN job_status ON jobs.status_id = job_status.id WHERE 1 GROUP BY status_id'));

		$service = Equipment::where('last_service', '<', date('Y-m-d', strtotime('-12 months')))
								->with(array('customer', 'equip_type'))
								->get();

		return View::make('reports.index', array('users' => $users,
													'status' => $status,
													'service' => $service));
	}

	public function users()
	{
		$users = DB::SELECT(DB::raw('SELECT SUM(job_equipment.`time`) AS total,  COUNT(job_equipment.equipment_id) AS equip, users.username, `jobs`.`status_date` FROM `jobs` LEFT JOIN `job_equipment` ON jobs.id = job_equipment.job_id LEFT JOIN users ON job_equipment.user_id = users.id  WHERE jobs.`status_date` > "'.strtotime('- 42 days', time()).'" GROUP BY `job_equipment`.`user_id`, DATE(jobs.status_date)'));

		return View::make('reports.users', array('users' => $users));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /reports/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /reports
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /reports/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}