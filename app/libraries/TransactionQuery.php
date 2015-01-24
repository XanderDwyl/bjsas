<?php
class TransactionQuery {

	public static function getUserAcl() {

		$access = false;
		if( Auth::check() ) {
			$access = Auth::User()->getAcl() == 'Admin' ? true : false;
		}

		return $access;
	}

	public static function addEmployee() {
		$validator = Validator::make(Input::all(), Employee::$rules);

		$flashMessage = array(
			'type'    => 'error',
			'message' => 'Invalid input!',
			'errors'  => $validator->errors()
		);

		if ( !$validator->passes() ) {
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

		// if( isset( Input::get('amount') ) )
			$salaryrate         = new SalaryRate;
			$isDeleted          = $salaryrate->updateSalaryRate( $id );
			$salaryrate->amount = Input::get('amount');
			$salaryrate->employees()->associate($employee)->save();


		$flashMessage = array(
			'type'    => 'success',
			'message' => 'Employee is successfully added.'
		);

		return $flashMessage;
	}

	public static function removeEmployee( $id ) {

		$logInEmployeeId = Auth::User()->getEmployeeId();
		$employee        = Employee::find( $id );

		$deleteMessage = array(
			'type'    => 'success',
			'message' => 'Record #: '  . $employee->id . ' is successfully deleted. '
		);

		if( $logInEmployeeId === $employee->id ) {
			$deleteMessage = array(
				'type'    => 'error',
				'message' => 'You can\'t delete your own profile. Please contact your administrator.'
			);
		} else {
			$employee->delete();
		}

		return $deleteMessage;
	}

	public static function addSalary( $id ) {
		$validator = Validator::make(Input::all(), SalaryRate::$rules);

		$deleteMessage = array(
			'type'    => 'error',
			'message' => 'Invalid input!',
			'errors'  => $validator->errors()
		);

		if ( $validator->passes() ) {

			$deleteMessage = array(
				'type'    => 'success',
				'message' => 'Salary for Employee #: '  . $id . ' is successfully updated. '
			);

			$salaryrate = new SalaryRate;
			$isDeleted  = $salaryrate->updateSalaryRate( $id );				// update status of the current salary rate

			$salaryrate->amount = Input::get('amount');
			$salaryrate->emp_id = $id;
			$salaryrate->save();
		}

		return $deleteMessage;
	}

	public static function removeSalary( $id ) {

		$deleteMessage = array(
			'type'    => 'error',
			'message' => 'Invalid input!',
			'errors'  => array( "emp_id" => [ "The id is required." ] )
		);

		if( $id !== null ) {
			$deleteMessage = array(
				'type'    => 'success',
				'message' => 'Salary for Employee #: '  . $id . ' is successfully deleted. '
			);
			$salaryrate = new SalaryRate;
			$isDeleted =$salaryrate->updateSalaryRate( $id );				// update status of the current salary rate
		}

		return $deleteMessage;

	}

	public static function getEmployee( $emp_id ) {

		if ( isset($emp_id ) && $emp_id > 0 ) {
			$salaryQuery = Employee::find($emp_id)->first();
		} else {
			$salaryQuery = Employee::get();
		}
		return $salaryQuery;
	}

	public static function getEmployeeCurrentSalary( $emp_id ) {

		$salaryQuery = Employee::with('salary_rates')->has('salary_rates');

		if ( isset($emp_id ) && $emp_id > 0 ) {
			$salaryQuery = $salaryQuery->where('id', '=', $emp_id)->first();
		} else {
			$salaryQuery = $salaryQuery->get();
		}

		return $salaryQuery;
	}

	public static function getCashAdvances() {
		return CashAdvance::leftJoin('employees', 'cash_advances.emp_id', '=', 'employees.id')
							->select('cash_advances.emp_id', 'employees.firstname', 'employees.lastname', 'cash_advances.amount', 'cash_advances.created_at')
							->orderBy( 'cash_advances.created_at', 'asc' )
							->get();
	}

	public static function getTotalCashAdvances() {
		return self::getCashAdvances()->sum('amount');
	}

	public static function getTotalCAPayments() {
		$queryAllCAPayment  = CashAdvance::leftJoin('employees', 'cash_advances.emp_id', '=', 'employees.id')
											->leftJoin('creditdeductions', 'cash_advances.emp_id', '=', 'creditdeductions.emp_id')
											->select('cash_advances.emp_id', 'employees.firstname', 'employees.lastname', 'cash_advances.amount')
											->get();

		$totalAllCAPayment = $queryAllCAPayment->sum('amount');

		return $totalAllCAPayment;
	}

	public static function getTotalCACollectables() {
		return self::getTotalCashAdvances();
	}

	public static function checkDBEntry() {
		if( Schema::hasTable('users') )
			return User::get()->count();
		else
			return 0;
	}


}
