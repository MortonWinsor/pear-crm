<?php

class JobsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /jobs
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$tab = Input::get('tab', 'in');

		$filter = Input::get('f', '');

		$q = Input::get('q', '');

		$types = Type::orderBy('name')
						->lists('name', 'id');

		$work_in = Job::whereBetween('status_id', array('1', '3'))
						->with(array('customer', 'status', 'equipments', 'equipments.equip_type'))
						->orderByRaw('status_id, updated_at DESC');
		if($filter != ''){
			$work_in->leftJoin('job_equipment', 'jobs.id', '=', 'job_equipment.job_id')
					->leftJoin('equipment', 'job_equipment.equipment_id', '=', 'equipment.id')
					->selectRaw('jobs.*')
					->where('equipment.type_id', '=', $filter)
					->groupBy('jobs.id');
		}
		if($q != ''){
			$work_in = $work_in->where('id', '=', $q);
		}
		$work_in = $work_in->get();

		$waiting_parts = Job::where('status_id', '=', '5')
						->with(array('customer', 'status', 'equipments', 'equipments.equip_type'))
						->orderBy('updated_at', 'DESC')
						->get();

		$work_complete = Job::whereBetween('status_id', array('2', '3'))
						->with(array('customer', 'status', 'equipments', 'equipments.equip_type'))
						->orderBy('updated_at', 'DESC')
						->get();

		return View::make('jobs.index', array('work_in' => $work_in,
													'waiting_parts' => $waiting_parts,
													'work_complete' => $work_complete,
													'tab' => $tab,
													'filter' => $filter,
													'q' => $q,
													'types' => $types));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /jobs/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$types = Type::orderBy('name')
						->lists('name', 'id');
		$works = Work::lists('name', 'id');

		return View::make('jobs.create', array('types' => $types,
												'works' => $works));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /jobs
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validator = Validator::make($data = Input::only('customer_id', 'description'), Job::$rules);

		$equip = Input::only('equip', 'equipCount');

		$equipOld = Input::only('equipOld');

		if ($validator->fails())
		{
			if (Request::ajax())
			{
				return Response::json(array(
						    'errors' => $validator->messages()->all(),
						    200)
						  );
			}
			else
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}
			
		}

		
		$data['updated_by'] = Auth::user()->id;
		$data['status_date'] = date('Y-m-d H:i:s', time());
		$data['status_id'] = '1';
		
		if(Input::get('job_id') == ''){
			$data['created_by'] = Auth::user()->id;
			$job = Job::create($data);
		} else {
			$job = Job::find(Input::get('job_id'));
			$job->update($data);
		}
		$jobE = array();

		foreach($equip['equip'] as $item){

			if($item['make'] != ''){
				//set works_id first to unset value as it will create error
				$jobEquipment['works_id'] = $item['works_id'];
				unset($item['works_id']);

				$item['created_by'] = Auth::user()->id;
				$item['updated_by'] = Auth::user()->id;
				$item['customer_id'] = $data['customer_id'];
				$item['last_service'] = date('Y-m-d', time());
				$equipment = Equipment::create($item);

				$jobE[] = $equipment->id;

				$jobEquipment['job_id'] = $job->id;
				$jobEquipment['equipment_id'] = $equipment->id;
				$jobEquipment['updated_by'] = Auth::user()->id;
				$jobEquipment['created_by'] = Auth::user()->id;

				JobEquipment::create($jobEquipment);			
			}
		}

		if(count($equipOld['equipOld'])){
			
			foreach ($equipOld['equipOld'] as $item) {
				# code...
				if(isset($item['id']) && $item['id'] != '0'){
					$je = JobEquipment::where('job_id', '=', $job->id)
									->where('equipment_id', '=', $item['id'])
									->get();
					if(!$je->count()){
						$jobEquipment['job_id'] = $job->id;
						$jobEquipment['equipment_id'] = $item['id'];
						$jobEquipment['works_id'] = $item['works_id'];
						$jobEquipment['updated_by'] = Auth::user()->id;
						$jobEquipment['created_by'] = Auth::user()->id;

						JobEquipment::create($jobEquipment);

						$jobE[] = $item;
					}
				}
			}
		}

		if (Request::ajax())
		{
			$thisJob = Job::with(array('equipments', 'equipments.equip_type'))
						->find($job->id);

			return $thisJob->toJson();
		}
		else
		{
			return Redirect::route('work.index'); //this should not happen but here just in case
		}
		
	}

	/**
	 * Display the specified resource.
	 * GET /jobs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$job = Job::with(array('customer', 'customer.equipment', 'customer.equipment.equip_type', 'customer.equipment.equip_type', 'status', 'equipments', 'equipments.equip_type', 'equipments.parts'))
					->findOrfail($id);

		$cParts = CommonPart::lists('part', 'id');
		$usedParts = array();

		if($job->equipments != ''){
            foreach($job->equipments as $equip){
            	if($equip->parts != '') {
            		foreach($equip->parts as $part) {
            			if($part->job_id == $job->id && array_search($part->name, $cParts) !== false) {
            				$usedParts[$equip->id][] = array_search($part->name, $cParts);
            			}
            		}
            	}
            	$jobEquip[] = $equip->id;
            }
        }

		$parts = CommonPart::orderBy('part')
							->get();
		$types = Type::orderBy('name')
					->lists('name', 'id');
		$status = JobStatus::lists('name', 'id');
		$equips = Equipment::selectRaw('concat(make, " ", model, " ", serial) AS full_name, equipment.id')
								->join('job_equipment', 'equipment.id', '=', 'job_equipment.equipment_id')
								->where('job_id', '=', $id)
								->whereNull('job_equipment.deleted_at')
								->orderBy('full_name')
								->lists('full_name', 'id');

		$users = User::where('role_id', '=', '3')
						->orderBy('username')
						->lists('username', 'id');

		return View::make('jobs.show',array_merge(compact('job'),  array('parts' => $parts,
																		'types' => $types,
																		'status' => $status,
																		'equips' => $equips,
																		'usedParts' => $usedParts,
																		'jobEquip' => $jobEquip,
																		'users' => $users)));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /jobs/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$job = Job::with(array('customer', 'status', 'equipments', 'equipments.equip_type'))
					->find($id);

		$status = JobStatus::lists('name', 'id');
		$types = Type::lists('name', 'id');
		$works = Work::all();

		return View::make('jobs.edit', array_merge(compact('job'), array('status' => $status,
														'types' => $types,
														'works' => $works)));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /jobs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$job = Job::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Job::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		StatusLogging::storeLog('job', $job->id, $job->status_id, $data['status_id']);

		if($job->status_id != '4' && $data['status_id'] == '4'){
			$data['status_date'] = time();
			$data['user_id'] = Auth::user()->id;
		}
		$data['updated_by'] = Auth::user()->id;

		$job->update($data);

		return Redirect::route('work.show', $id);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /jobs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	//custom views

	public function getHistory()
	{
		$start = Input::get('start', '01/02/2015');
		$end = Input::get('end', date('d/m/Y', time()));
		$q = Input::get('q', '');

		$history = Job::where('status_id', '=', '4')
						->where('id', 'LIKE', $q == '' ? '%' : $q)
						->whereBetween('created_at', array(date('Y-m-d H:i:s', strtotime(str_replace('/', '-',$start))), date('Y-m-d H:i:s', strtotime(str_replace('/', '-',$end)))))
						->with(array('customer', 'status', 'equipments', 'equipments.equip_type'))
						->orderBy('created_at', 'desc')
						->paginate(50);

		return View::make('jobs.history', array('history' => $history,
												'start' => $start,
												'end' => $end,
												'q' => $q));

	}

	//custom data handling

	public function postEngineer()
	{
		$data = Input::only('job_id', 'notes', 'status_id');
		$parts = Input::only('part', 'partsCounts');
		$equipment = Input::only('equip');

		$job = Job::find($data['job_id']);
		//$job->time = $data['time'];
		$job->notes = $data['notes'];
		$job->status_id = $data['status_id'];
		$job->updated_by = Auth::user()->id;
		$job->save();

		//loop around common parts and find any selected
		//store in parts table

		//loop around extra parts
		//store in parts table
		
		foreach($parts['part'] as $part){
			if(isset($part['name']) && $part['name'] != '') {
				$part['job_id'] = $data['job_id'];
				$part['customer_id'] = $job->customer_id;
				//$part['equipment_id'] = $key;

				$part['created_by'] = Auth::user()->id;
				$part['updated_by'] = Auth::user()->id;
				Part::create($part);
			}		
			
		}

		$complete = true;

		foreach($equipment['equip'] as $key => $e){
			if($e['time'] == '0') $complete = false;

			DB::table('job_equipment')->where('job_id', '=', $data['job_id'])
								->where('equipment_id', '=', $key)
								->update(array('time' => $e['time'],
												'user_id' => $e['user_id'],
												'notes' => $e['notes'],
												'updated_by' => Auth::user()->id));

			if(!isset($e['us']) || (isset($e['us']) && $e['us'] != '1')){
				$e['us'] = '0';
			}

			$equipment = Equipment::find($key);
			$equipment->us = $e['us'];
			$equipment->save();
		}

		if($complete == true && $job->status_id == '1'){
			$job->status_id = '2';
			$job->save();
		}

		//return '{"job" : '.$job->toJson().'}';
		return Redirect::route('work.show', array('id' => $data['job_id']));
	}

	//button updates

	public function getRemoved()
	{
		$id = Input::get('id');
		$eid = Input::get('eid');

		$job = JobEquipment::where('job_id', '=', $id)
							->where('equipment_id', '=', $eid)
							->delete();

		return Redirect::route('work.show', $id);
	}

	public function getPartRemoved()
	{
		$id = Input::get('id');
		$eid = Input::get('eid');
		$pid = Input::get('pid');

		Part::where('job_id', '=', $id)
				->where('equipment_id', '=', $eid)
				->where('id', '=', $pid)
				->delete();

		return Redirect::route('work.index', $id);
	}

	public function getStarted()
	{
		$id = Input::get('id');

		$job = Job::find($id);

		StatusLogging::storeLog('job', $job->id, $job->status_id, '1');

		$job->status_id = '1';
		$job->save();

		$b = Input::get('b', 'l');
		if($b == 'l'){
			return Redirect::route('work.index', array('tab' => Input::get('tab')));
		}elseif($b == 's'){
			return Redirect::route('work.show', $id);
		}
	}

	public function getCompleted()
	{
		$id = Input::get('id');

		$job = Job::find($id);

		StatusLogging::storeLog('job', $job->id, $job->status_id, '2');

		$job->status_id = '2';
		$job->status_date = date('Y-m-d H:i:s', time());
		$job->user_id = Auth::user()->id;
		$job->save();

		$b = Input::get('b', 'l');
		if($b == 'l'){
			return Redirect::route('work.index', array('tab' => Input::get('tab')));
		}elseif($b == 's'){
			return Redirect::route('work.show', $id);
		}
	}

	public function getWaiting()
	{
		$id = Input::get('id');

		$job = Job::find($id);

		StatusLogging::storeLog('job', $job->id, $job->status_id, '5');

		$job->status_id = '5';
		$job->save();

		$b = Input::get('b', 'l');
		if($b == 'l'){
			return Redirect::route('work.index', array('tab' => Input::get('tab')));
		}elseif($b == 's'){
			return Redirect::route('work.show', $id);
		}
	}

	public function getContacted()
	{
		$id = Input::get('id');

		$job = Job::find($id);

		StatusLogging::storeLog('job', $job->id, $job->status_id, '3');

		$job->status_id = '3';
		$job->save();

		$b = Input::get('b', 'l');
		if($b == 'l'){
			return Redirect::route('work.index', array('tab' => Input::get('tab')));
		}elseif($b == 's'){
			return Redirect::route('work.show', $id);
		}
	}

	public function getPaid()
	{
		$id = Input::get('id');

		$job = Job::find($id);

		StatusLogging::storeLog('job', $job->id, $job->status_id, '4');

		$job->status_id = '4';
		$job->save();

		$b = Input::get('b', 'l');
		if($b == 'l'){
			return Redirect::route('work.index', array('tab' => Input::get('tab')));
		}elseif($b == 's'){
			return Redirect::route('work.show', $id);
		}
	}


}