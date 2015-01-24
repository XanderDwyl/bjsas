<?php
Route::get('/'			   , 'PageController@showIndex');
Route::get('/create/admin' , 'PageController@showLoginForm');
Route::get('/login'	       , 'PageController@showLoginForm');
Route::get('/dashboard'	   , 'PageController@showDashboard');
Route::get('/employee'	   , 'PageController@showEmployee');
Route::get('/salary'	   , 'PageController@showSalary');
Route::get('/payroll'	   , 'PageController@showPayrollForm');
Route::get('/cashadvance'  , 'PageController@showCashadvanceForm');
Route::get('/404'          , 'PageController@show404');
Route::post('/404'         , 'PageController@show404');
Route::delete('/404'       , 'PageController@show404');
Route::controller('auth'   , 'AuthController');

// consumable API routes
Route::group(array('prefix' => 'api/v1', 'before' => 'api.auth'), function()
{
	if( TransactionQuery::getUserAcl() ) {
		Route::resource('employee', 'EmployeeController');
		Route::resource('salary', 'SalaryController');
	} else if ( !TransactionQuery::checkDBEntry() ) {
		Route::resource('config', 'AppController', array('only' => array('store')));
	} else {
		Route::resource('employee', 'EmployeeController', array('only' => array('index','show')));
	}
});

// authentication for api
Route::filter('api.auth', function () {
	if ( !Auth::check() && TransactionQuery::checkDBEntry() ) {
		return Response::json(array('error' => 'You don\'t have access rights!'), 403);
	}
});

Route::get('routes', function() {
	$routeCollection = Route::getRoutes();

	echo "<table style='width:100%'>";
		echo "<tr>";
			echo "<td width='10%'><h4>HTTP Method</h4></td>";
			echo "<td width='10%'><h4>Route</h4></td>";
			echo "<td width='80%'><h4>Corresponding Action</h4></td>";
		echo "</tr>";
		foreach ($routeCollection as $value) {
			echo "<tr>";
				echo "<td>" . $value->getMethods()[0] . "</td>";
				echo "<td>" . $value->getPath() . "</td>";
				echo "<td>" . $value->getActionName() . "</td>";
			echo "</tr>";


		}
	echo "</table>";
});
