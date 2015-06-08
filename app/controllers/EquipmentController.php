<?php

class EquipmentController extends \BaseController {

	/**
	 * Display a listing of equipment
	 *
	 * @return Response
	 */
	public function index()
	{
		//equipment listed in customer details
		$equipment = Equipment::all();

		return View::make('equipment.index', compact('equipment'));
	}

	/**
	 * Show the form for creating a new equipment
	 *
	 * @return Response
	 */
	public function create()
	{

		$types = Type::lists('name', 'id');

		return View::make('equipment.create', array('types' => $types));
	}

	/**
	 * Store a newly created equipment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Equipment::$rules);

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

		if($data['make'] != ''){
			$data['created_by'] = Auth::user()->id;
			$data['updated_by'] = Auth::user()->id;
			$data['customer_id'] = $data['customer_id'];
			$data['last_service'] = date('Y-m-d', strtotime(str_replace('/', '-',$data['last_service'])));
			$equipment = Equipment::create($data);

		}
		

		if (Request::ajax())
		{
			return Equipment::with(array('equip_type'))->find($equipment->id)->toJson();
		}
		else
		{
			return Redirect::route('work.index');
		}
	}

	public function storemultiple()
	{
		$data = Input::only('customer_id');

		$equip = Input::only('equip', 'equipCount');

		$equipOld = Input::only('equipOld');

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
				$item['created_by'] = Auth::user()->id;
				$item['updated_by'] = Auth::user()->id;
				$item['customer_id'] = $data['customer_id'];
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
				$je = JobEquipment::where('job_id', '=', $job->id)
									->where('equipment_id', '=', $item)
									->get();
				if(!$je->count()){
					$jobEquipment['job_id'] = $job->id;
					$jobEquipment['equipment_id'] = $item;
					$jobEquipment['updated_by'] = Auth::user()->id;
					$jobEquipment['created_by'] = Auth::user()->id;

					JobEquipment::create($jobEquipment);

					$jobE[] = $item;
				}
				
			}
		}
		return Redirect::route('work.show', $job->id); 
	}

	/**
	 * Display the specified equipment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//equipment will be list on customer page
		$equipment = Equipment::with('equip_type')
								->findOrFail($id);

		return View::make('equipment.show', compact('equipment'));
	}

	/**
	 * Show the form for editing the specified equipment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$equipment = Equipment::find($id);

		$types = Type::lists('name', 'id');

		return View::make('equipment.edit', array_merge(compact('equipment'), array('types' => $types)));
	}

	/**
	 * Update the specified equipment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$equipment = Equipment::find($id);

		$validator = Validator::make($data = Input::all(), Equipment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if(isset($data['last_serviced'])) {
			$data['last_serviced'] = date('Y-m-d', strtotime(str_replace('/', '-',$data['last_service'])));
		}

		if(isset($data['job_id'])){
			$job_id = $data['job_id'];
			unset($data['job_id']);
			$return = Redirect::route('work.show', $job_id);
		}else{
			$return = Redirect::route('work.index'); 
		}

		$equipment->update($data);

		return $return;
	}

	/**
	 * Remove the specified equipment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Equipment::destroy($id);

		return Redirect::route('equipment.index');
	}

	//ajax to get equipment for autocomplete and to edit equipment on work.show route
	public function getEquipment()
	{
		$q = Input::get('q', '');
		$id = Input::get('id', '');

		if($q != ''){
			$equipment = Equipment::where('make', 'LIKE', '%'.$q.'%')
								->orWhere('model', 'LIKE', '%'.$q.'%')
								->orWhere('serial', 'LIKE', '%'.$q.'%')
								->get();
		}elseif($id != ''){
			$equipment = Equipment::find($id);
		}else{
			return false;
		}
		
		return $equipment->toJson();
	}
}
