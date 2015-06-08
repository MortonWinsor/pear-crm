<?php

class CustomersController extends \BaseController {

	/**
	 * Display a listing of customers
	 *
	 * @return Response
	 */
	public function index()
	{
		$q = Input::get('q', '');

		$customers = Customer::where('name', 'LIKE', $q == '' ? '%' : '%'.$q.'%') 
								->orWhere('phone', 'LIKE', $q == '' ? '%' : '%'.$q.'%')
								->paginate(50);

		return View::make('customers.index', array_merge(compact('customers'), array('q' => $q)));
	}

	/**
	 * Show the form for creating a new customer
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('customers.create');
	}

	/**
	 * Store a newly created customer in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = array_except(Input::all(), array('_token')), Customer::$rules);

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

		$data['phone'] = str_replace(' ', '', $data['phone']);
		$data['mobile'] = str_replace(' ', '', $data['mobile']);
		$data['postcode'] = str_replace(' ', '', $data['postcode']);

		$data['created_by'] = Auth::user()->id;
		$data['updated_by'] = Auth::user()->id;

		$customer = Customer::create($data);

		if (Request::ajax())
		{
			return $customer->toJson();
		}
		else
		{
			return Redirect::route('customer.show', $customer->id);
		}
	}

	/**
	 * Display the specified customer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$customer = Customer::findOrFail($id);

		$equipment = Equipment::where('customer_id', '=', $id)
								->with(array('equip_type'))
								->orderBy('created_at', 'desc')
								->get();

		$work = Job::where('customer_id', '=', $id)
						->with(array('status', 'equipments', 'equipments.equip_type'))
						->orderBy('created_at', 'desc')
						->get();

		$orders = Order::where('customer_id', '=', $id)
							->with(array('items'))
							->orderBy('created_at', 'desc')
							->get();

		return View::make('customers.show', array_merge(compact('customer'), array('equipment' => $equipment,
																					'work' => $work,
																					'orders' => $orders)));
	}

	/**
	 * Show the form for editing the specified customer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customer = Customer::find($id);

		return View::make('customers.edit', compact('customer'));
	}

	/**
	 * Update the specified customer in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$customer = Customer::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Customer::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$customer->update($data);

		return Redirect::route('customer.show', $id);
	}

	/**
	 * Remove the specified customer from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Customer::destroy($id);

		return Redirect::route('customer.index');
	}

	public function getCustomers()
	{
		$q = Input::get('q');

		$customers = Customer::select('customers.*')
								->with(array('equipment', 'equipment.equip_type', 'jobs', 'jobs.status', 'jobs.equipments', 'jobs.equipments.equip_type', 'orders', 'orders.items', 'orders.items.status'))
								->leftJoin('jobs', 'customers.id', '=', 'jobs.customer_id')
								->where('name', 'LIKE', '%'.$q.'%')
								->orWhere('jobs.id', 'LIKE', $q)
								->groupBy('customers.id')
								->get();

		//also equipment

		return $customers->toJson();
	}

	public function getEquipment()
	{
		$q = Input::get('q');
		$customer = Input::get('c');

		$equipment = Equipment::where('customer_id', 'LIKE', $customer)
								->where(function($sql) use ($q)
								{
									$sql->where('make', '=', $q);
									$sql->orWhere('model', '=', $q);
									$sql->orWhere('serial', '=', $q);
								})
								->get();

		return $equipment->toJson();
	}

}
