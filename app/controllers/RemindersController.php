<?php

class RemindersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /reminders
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$service = Equipment::where('last_service', '<', date('Y-m-d', strtotime('-12 months')))
								->with(array('customer', 'equip_type'))
								->get();

		foreach($service as $email){
			$send = ReminderLog::where('equipment_id', '=', $email->id)
								->where('customer_id', '=', $email->customer_id)
								->where('created_at', '>', date('Y-m-d', strtotime('-14 days')))
								->get();
			if(!$send->count() && $email->customer->email != ''){
				//send email
				Mail::send('emails.reminder', array('details' => $email), function($message) use ( $email )
				{
					$message->to($email->customer->email); 
				});
				//log email
				$data['equipment_id'] = $email->id;
				$data['customer_id'] = $email->customer_id;
				ReminderLog::create($data);
			}
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /reminders/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /reminders
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /reminders/{id}
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
	 * GET /reminders/{id}/edit
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
	 * PUT /reminders/{id}
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
	 * DELETE /reminders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}