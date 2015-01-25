@section( 'head_wrapper' )
	<html lang="en" ng-app="bjsApp">
@stop

@section( 'navigator' )
	@include( 'includes.navigator' )
@stop

@section('content')
	<div class="main-container container-fluid">
		<div class="page-container">
			@include( 'includes.sidebar', array('fieldActive'=>'Employees', 'subfield'=>'salary') )

			<div class="page-content">
				@include( 'includes.breadcrumbs', array('crumbs'=>'Employee', 'subcrumbs'=>'Salary Rates') )

				<div class="page-body" ng-controller="employeesController" data-ng-init="init()">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row no-margin ">
								<notification-container toaster-options="{'time-out': 3000}"></notification-container>
								@if( Auth::User()->getAcl() === 'Admin' )
									<div class="buttons-preview pull-right">
										<div class="btn btn-blue shiny border-white animate bounceIn" ng-click="showContent( '/bjsAssets/partials/addSalary.html' )" btn-hide="closeTemplate">Add Salary</div>
									</div>
								@endif
								<div class="index-1" show-template reg-template="@{{template}}" ng-hide='closeTemplate'></div>
							</div>

							<div class="row">
								<div class="col-xs-12">
									<div class="widget">
										<div class="widget-header bordered-bottom bordered-themesecondary">
											<i class="widget-icon typcn typcn-contacts themesecondary"></i>
											<span class="widget-caption themesecondary">List of Salary</span>
										</div>
										<div class="widget-body">
											<div class="widget-main no-padding">
												<div class="widget-workspace">
													<ul class="widget-list">
														<li class="widget-item hidden-xs hidden-sm">
															<div class="row widget-list-title">
																<div class="col-lg-4 col-sm-6 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<span>Employee</span>
																</div>
																<div class="col-lg-3 col-sm-6 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<span>Description</span>
																</div>
																<div class="col-lg-2 col-sm-2 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<i class="fa fa-calendar type"></i>
																	<span> Hire Date</span>
																</div>
																<div class="col-lg-2 col-sm-2 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<i class="fa fa-money"></i>
																	<span class="type"> Amount</span>
																</div>
															</div>
														</li>
														<li class="widget-item" ng-hide="employeesWithSalary.length">
															<div class="row">
																<div class="col-xs-12 text-center">
																	No employees found!
																</div>
															</div>
														</li>
														<li class="widget-item" ng-repeat="employee in employeesWithSalary" repeat-done="fetchDone()" show-employee>
															<div class="row" ng-show="isLoading">Loading...</div>
															<div class="row" ng-hide="isLoading">
																<div class="col-lg-4 col-sm-6 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<span>@{{employee.firstname + ' ' + employee.lastname}}</span>
																</div>
																<div class="col-lg-3 col-sm-6 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<span>@{{employee.firstname + ' ' + employee.lastname}}</span>
																</div>
																<div class="col-lg-2 col-sm-2 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<span>@{{employee.hired_date | dateFormat }}</span>
																</div>
																<div class="col-lg-2 col-sm-2 col-xs-12 text-center">
																	<span class="divider hidden-xs"></span>
																	<span>@{{ employee.salary_rates[0].amount | currency : 'Php '}}</span>
																</div>
																@if( Auth::User()->getAcl() === 'Admin' )
																	<div class="widget-action bg-darkorange">
																		<i class="fa fa-trash" ng-hide="@{{employee.deleted_at.length}}" ng-click="removeSalary( employee )"></i>
																	</div>
																@endif
															</div>
														</li>

													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
