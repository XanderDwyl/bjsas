<?php
class AppController extends Controller {
	public function store( ) {
		$flashMessage = array(
			'type'    => 'error',
			'message' => 'Cannot create admin, User\'s table not found! ' . Schema::hasTable('users')
		);

		if( Schema::hasTable('users') ) {
			$employee            = new Employee;
			$employee->firstname = Input::get('firstName');
			$employee->lastname  = Input::get('lastName');
			$employee->save();

			$user                = new User;
			$user->email_address = Input::get('emailAddress');
			$user->password      = Hash::make(Input::get('password'));
			$user->rights        = 'Admin';
			$user->employees()->associate($employee)->save();

			return Redirect::to('login');

		}

		return Response::json($flashMessage);

	}
}
