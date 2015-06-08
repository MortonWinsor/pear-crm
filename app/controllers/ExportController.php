<?php

class ExportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /export
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$type = array('All', 'Customers', 'Equipment', 'Jobs', 'Orders');

		return View::make('export.index', array('type' => $type));
	}

	/**
	 * create the export file.
	 * POST /export/export
	 *
	 * @return CSV File
	 */
	public function export()
	{
		$type = Input::get('type');

		switch ($type){
			case '0':
				$output = $this->exportAll();
				break;
			case '1':
				$output = $this->exportCustomers();
				break;
			case '2':
				$output = $this->exportEquipment();
				break;
			case '3':
				$output = $this->exportJobs();
				break;
			case '4':
				$output = $this->exportOrders();
				break;
		}

		$headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="CRMExport_' . date('Y-m-d') . '.csv"',
            );
		return Response::make($output, 200, $headers);
	}

	protected function exportAll()
	{
		$output = $this->exportCustomers();
		$output .= "\n";
		$output .= $this->exportEquipment();
		$output .= "\n";
		$output .= $this->exportJobs();
		$output .= "\n";
		$output .= $this->exportOrders();

		return $output;
	}

	protected function exportCustomers()
	{
		$customers = Customer::select(array('name', 'address', 'postcode', 'phone', 'mobile', 'email'))
						->get();

		$output = 'Name,Address,Postcode,Phone,Mobile,Email'."\n";

		if($customers->count()){
			foreach($customers as $row)
			{
				$output .=  implode(",",$row->toArray());
				$output .= "\n";
			}
		}

		return $output;
	}

	protected function exportEquipment()
	{
		$equipment = Equipment::select(array('make', 'model', 'serial', ))
							->get();

		$output = 'Make,Model,Serial'."\n";

		if($equipment->count()){
			foreach($equipment as $row){
				$output .=  implode(",",$row->toArray());
				$output .= "\n";
			}

		}

		return $output;

	}

	protected function exportJobs()
	{
		$jobs = Job::selectRaw('jobs.id, customers.name, customers.address, customers.postcode, customers.phone, customers.mobile, customers.email, description, notes, works.name AS work_name, job_status.name AS status_name, make, model, serial')
					->leftJoin('job_status', 'jobs.status_id', '=', 'job_status.id')
					->leftJoin('job_equipment', 'jobs.id', '=', 'job_equipment.job_id')
					->leftJoin('equipment', 'job_equipment.equipment_id', '=', 'equipment.id')
					->leftJoin('customers', 'jobs.customer_id', '=', 'customers.id')
					->leftJoin('works', 'jobs.works_id', '=', 'works.id')
					->get();

		$output = 'Job#,Customer Name,Address,Postcode,Phone,Mobile,Email,Description,Notes,Work,Status,Make,Model,Serial'."\n";

		if($jobs->count()){
			foreach($jobs as $row){
				$output .=  implode(",",$row->toArray());
				$output .= "\n";
			}

		}

		return $output;
	}

	protected function exportOrders()
	{
		$orders = Order::selectRaw('orders.id, customers.name, customers.address, customers.postcode, customers.phone, customers.mobile, customers.email, order_items.part_number, order_items.name AS part_name, parts_status.name AS status_name')
					->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
					->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
					->leftJoin('parts_status', 'order_items.status_id', '=', 'parts_status.id')
					->get();

		$output = 'Order#,Customer Name,Address,Postcode,Phone,Mobile,Email,Part#,Part,Status'."\n";

		if($orders->count()){
			foreach($orders as $row){
				$output .=  implode(",",$row->toArray());
				$output .= "\n";
			}

		}

		return $output;
	}

}