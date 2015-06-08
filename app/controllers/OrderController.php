<?php

class OrderController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /order
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$tab = Input::get('tab', 'req');

		$required = Order::with(array('items', 'customer'))
							->whereHas('items', function($q)
							{
							    $q->where('status_id', '=', '1');

							})->get();

		$ordered = Order::with(array('items', 'customer'))
							->whereHas('items', function($q)
							{
							    $q->where('status_id', '=', '2');

							})->get();

		$recieved = Order::with(array('items', 'customer'))
							->whereHas('items', function($q)
							{
							    $q->where('status_id', '=', '3');

							})->get();

		return View::make('order.index', array('required' => $required,
													'ordered' => $ordered,
													'recieved' => $recieved,
													'tab' => $tab));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /order/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$status = PartStatus::lists('name', 'id');

		return View::make('order.create', array('status' => $status));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /order
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validator = Validator::make($data = Input::only('customer_id', 'order_id'), Order::$rules);

		$equip = Input::only('order', 'orderCount');

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
		
		if(Input::get('order_id') == ''){
			$data['created_by'] = 0;
			$order = Order::create($data);
		} else {
			$order = Order::find(Input::get('order_id'));
			$order->update($data);
		}

		foreach($equip['order'] as $item){

			if($item['name'] != ''){
				$item['created_by'] = Auth::user()->id;
				$item['updated_by'] = Auth::user()->id;
				$item['order_id'] = $order->id;
				$item['status_id'] = isset($item['status_id']) ? '2' : '1';
				OrderItem::create($item);
			}
		}

		$thisOrder = Order::with(array('items'))->find($order->id);

		if (Request::ajax())
		{
			return $thisOrder->toJson();
		}
		else
		{
			return Redirect::route('work.index'); //this should not happen but here just in case
		}
	}

	/**
	 * Display the specified resource.
	 * GET /order/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//

		$order = Order::with(array('customer', 'items', 'items.status'))
					->findOrfail($id);

		return View::make('order.show', compact('order'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /order/{id}/edit
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
	 * PUT /order/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$equip = Input::only('order', 'orderCount');

		foreach($equip['order'] as $item){

			if($item['name'] != ''){
				$item['created_by'] = Auth::user()->id;
				$item['updated_by'] = Auth::user()->id;
				$item['order_id'] = $id;

				StatusLogging::storeLog('order', $id, null, isset($item['status_id']) ? $item['status_id'] : '1');

				$item['status_id'] = isset($item['status_id']) ? $item['status_id'] : '1';
				OrderItem::create($item);
			}
		}

		return Redirect::route('order.show', $id);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /order/{id}
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
		$history = Order::with(array('items', 'customer'))
							->whereHas('items', function($q)
							{
							    $q->where('status_id', '=', '4');

							})->get();

		return View::make('order.history', array('history' => $history));

	}

	//button updates

	public function getOrdered()
	{
		$id = Input::get('id');

		$item = OrderItem::find($id);

		StatusLogging::storeLog('order', $item->id, $item->status_id, '2');

		$item->status_id = '2';
		$item->save();

		return Redirect::route('orders.index');
	}

	public function getReceived()
	{
		$id = Input::get('id');

		$item = OrderItem::find($id);

		StatusLogging::storeLog('order', $item->id, $item->status_id, '3');

		$item->status_id = '3';
		$item->save();

		return Redirect::route('orders.index');
	}

	public function getPickUp()
	{
		$id = Input::get('id');

		$item = OrderItem::find($id);

		StatusLogging::storeLog('order', $item->id, $item->status_id, '4');

		$item->status_id = '4';
		$item->save();

		return Redirect::route('orders.index');
	}

	public function getRemoved()
	{
		$id = Input::get('id');

		$item = OrderItem::find($id);
		$item->delete();

		return Redirect::route('orders.index');
	}
}