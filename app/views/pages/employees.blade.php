@section( 'head_wrapper' )
    <html lang="en" ng-app="bjsApp">
@stop

@section( 'navigator' )
    @include( 'includes.navigator' )
@stop

@section('content')
    <div class="main-container container-fluid">
        <div class="page-container">
            @include( 'includes.sidebar', array('fieldActive'=>'Employees', 'subfield'=>'list') )

            <div class="page-content">
                @include( 'includes.breadcrumbs', array('crumbs'=>'Employees', 'subcrumbs'=>'List of Employees') )

                <div class="page-body" ng-controller="employeesController" data-ng-init="init()">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row no-margin ">
                                <notification-container toaster-options="{'time-out': 3000}"></notification-container>
                                @if( Auth::User()->getAcl() === 'Admin' )
                                    <div class="buttons-preview pull-right">
                                        <div class="btn btn-blue shiny border-white animate bounceIn" ng-click="showContent( '/bjsAssets/partials/addEmployee.html' )" btn-hide="closeTemplate">Add Employee</div>
                                    </div>
                                @endif
                                <div show-template reg-template="@{{template}}" ng-hide='closeTemplate'></div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="widget">
                                        <div class="widget-header bordered-bottom bordered-themesecondary">
                                            <i class="widget-icon typcn typcn-contacts themesecondary"></i>
                                            <span class="widget-caption themesecondary">List of Employees</span>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main no-padding">
                                                <div class="widget-workspace">
                                                    <ul class="widget-list">
                                                        <li class="widget-item hidden-xs hidden-sm">
                                                            <div class="row widget-list-title">
                                                                <div class="col-lg-1 col-sm-12 text-center">
                                                                    <span>Id</span>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <span>Employee</span>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <span class="time">Home Address</span>
                                                                </div>
                                                                <div class="col-lg-1 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <span class="time">Gender</span>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <i class="fa fa-calendar"></i>
                                                                    <span class="time">Birth Date</span>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-6 col-xs-12 text-center">
                                                                    <span class="divider hidden-xs"></span>
                                                                    <i class="fa fa-calendar"></i>
                                                                    <span class="type">Hired Date</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="widget-item" ng-repeat="employee in employees">
                                                            <div class="row" ng-show="isLoading">Loading...</div>
                                                            <div class="row" ng-hide="isLoading">
                                                                <div class="col-lg-1 col-sm-12 text-center">
                                                                    <span>@{{employee.id}}</span>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <span>@{{employee.firstname + ' ' + employee.lastname}}</span>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <span>@{{employee.home_address}}</span>
                                                                </div>
                                                                <div class="col-lg-1 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <span>@{{employee.gender}}</span>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-6 col-xs-12 text-center">
                                                                    <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                                                    <span>@{{employee.birth_date | dateFormat }}</span>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-6 col-xs-12 text-center">
                                                                    <span class="divider hidden-xs"></span>
                                                                    <span class="time">@{{employee.hired_date | dateFormat }}</span>
                                                                </div>
                                                                @if( Auth::User()->getAcl() === 'Admin' )
                                                                    <div class="widget-action bg-darkorange">
                                                                        <i class="fa fa-trash" ng-hide="@{{employee.deleted_at.length}}" ng-click="removeEmployee( employee )"></i>
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
