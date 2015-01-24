<?php

class EmployeeController extends Controller {
	public function index()
	{
		return 'Hello, to Employee - BJS API!';
	}
	public function show( $id = null ) {
		return Response::json(TransactionQuery::getEmployee( $id ));
	}
	public function store( ) {

		$validateEmployee     = Validator::make(Input::all(), Employee::$rules);
		$validateSSSId        = Validator::make(array('id'=>Input::get('SSS')), Agency::$rules);
		$validatePagIbigId    = Validator::make(array('id'=>Input::get('PagIbig')), Agency::$rules);
		$validatePhilHealthId = Validator::make(array('id'=>Input::get('PhilHealth')), Agency::$rules);
		$validateDuplicateId  = array('fails'=>false,'message'=>null);

		$flashMessage         = array(
			'type'    => 'error',
			'message' => 'Invalid input!'
		);

		$AgencyId = array_filter(array(Input::get('SSS'),Input::get('PagIbig'),Input::get('PhilHealth')));

		if (count(array_unique($AgencyId)) != count($AgencyId)) {
			$validateDuplicateId = array('fails'=>true,
				'message'=>'Id\'s contains duplicate');
		}

		if ( $validateEmployee->fails() || $validateSSSId->fails() || $validatePagIbigId->fails() || $validatePhilHealthId->fails() || array_get($validateDuplicateId,'fails') ) {

			$validatorMessages = array_merge_recursive($validateEmployee->messages()->toArray(),
				array('sss'=>array_get($validateSSSId->messages()->toArray(), 'id')),
				array('pagibig'=>array_get($validatePagIbigId->messages()->toArray(), 'id')),
				array('philhealth'=>array_get($validatePhilHealthId->messages()->toArray(), 'id')),
				array('duplicate'=>array_get($validateDuplicateId,'message')) );

			$flashMessage = array_add( $flashMessage, 'errors', $validatorMessages );

			return $flashMessage;
		}

		$employee               = new Employee;
		$employee->firstname    = Input::get('firstName');
		$employee->lastname     = Input::get('lastName');
		$employee->birth_date   = date("Y-m-d", strtotime(Input::get('birthDate')));
		$employee->gender       = Input::get('gender');
		$employee->home_address = Input::get('homeAddress');
		$employee->hired_date   = date("Y-m-d H:i:s", strtotime(Input::get('hiredDate')));
		$employee->save();

		// add salary rate and update current salary rate
		$salaryrate         = new SalaryRate;
		$isDeleted          = $salaryrate->updateSalaryRate( $employee->id );
		$salaryrate->amount = Input::get('amount');
		$salaryrate->employees()->associate($employee)->save();

		// add SSS id's
		if ( Input::has('SSS') ) {
			$agency         = new Agency;
			$agency->id     = Input::get('SSS');
			$agency->agency = 'SSS';
			$agency->employees()->associate($employee)->save();
		}

		// add PagIbig id's
		if ( Input::has('PagIbig') ) {
			$agency         = new Agency;
			$agency->id     = Input::get('PagIbig');
			$agency->agency = 'PagIbig';
			$agency->employees()->associate($employee)->save();
		}

		// add PhilHealth id's
		if ( Input::has('PhilHealth') ) {
			$agency         = new Agency;
			$agency->id     = Input::get('PhilHealth');
			$agency->agency = 'PhilHealth';
			$agency->employees()->associate($employee)->save();
		}

		$flashMessage = array(
			'type'    => 'success',
			'message' => 'Employee is successfully added.'
		);

		return Response::json($flashMessage);
	}
	public function destroy( $employee ) {
		return Response::json(TransactionQuery::removeEmployee( $employee ));
	}
}
