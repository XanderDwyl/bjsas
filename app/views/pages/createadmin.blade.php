@section( 'head_wrapper' )
    <html lang="en" ng-app="bjsApp">
@stop
@section('content')

    <div class="page-body animated fadeInDown" ng-controller="employeesController">
        <div class="well col-xs-12 col-sm-7 align-center">
            <span class="notification">
                Welcome to BJS MotoShop. Before getting started, we need some information on the database.
            </span>
        </div>

        <div class="col-xs-12 col-sm-4 align-center">
            <div class="widget">
                <div class="widget-body">
                    <div class="widget-workspace">
                        {{ Form::open(array('url' => 'api/v1/config','class' => 'form-group row')) }}
                            <div class="col-xs-12 no-padding">
                                <div class="col-xs-12 form-group">
                                    <label for="inputEmail3" class="hidden-xs hidden-sm field">
                                        <span>First Name</span>
                                    </label>
                                    <span class="input-icon icon-right field" data-toggle="tooltip" data-placement="top-right" data-original-title="" field='firstName' tooltip-show>
                                        <input type="text" class="form-control" placeholder="First Name" name="firstName" ng-model="employee.firstName">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="inputEmail3" class="hidden-xs hidden-sm field">
                                        <span>Last Name</span>
                                    </label>
                                    <span class="input-icon icon-right field" data-toggle="tooltip" data-placement="top-right" data-original-title="" field='lastName' tooltip-show>
                                        <input type="text" class="form-control" placeholder="Last Name" name="lastName" ng-model="employee.lastName">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="inputEmail3" class="hidden-xs hidden-sm field">
                                        <span>Email Address</span>
                                    </label>
                                    <span class="input-icon icon-right field" data-toggle="tooltip" data-placement="top-right" data-original-title="" field='emailAddress' tooltip-show>
                                        <input type="text" class="form-control" placeholder="username@domain.com" name="emailAddress" ng-model="employee.emailAddress">
                                        <i class="fa fa-at"></i>
                                    </span>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="inputEmail3" class="hidden-xs hidden-sm field">
                                        <span>Password</span>
                                    </label>
                                    <span class="input-icon icon-right field" data-toggle="tooltip" data-placement="top-right" data-original-title="" field='password' tooltip-show>
                                        <input type="password" class="form-control" name="password" ng-model="employee.password">
                                        <i class="fa fa-key"></i>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <span class="button">
                                        <button class="btn btn-default shiny border-white btn-default-width" ng-click="resetContent( )">Reset</button>
                                        <button type="submit" class="btn btn-blue shiny border-white btn-default-width">Save</button>
                                    </span>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
