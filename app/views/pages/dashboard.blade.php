@section( 'head_wrapper' )
    <html lang="en" ng-app="bjsApp">
@stop

@section( 'navigator' )
    @include( 'includes.navigator')
@stop

@section('content')
    <div class="main-container container-fluid">
        <div class="page-container">
            @include( 'includes.sidebar', array('fieldActive'=>'Dashboard', 'subfield'=>'') )

            <div class="page-content">
                @include( 'includes.breadcrumbs', array('crumbs'=>'Dashboard', 'subcrumbs'=>'') )

                <div class="page-body" ng-controller="employeesController" data-ng-init="init()">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row" ng-show="isLoading">Loading...</div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="databox databox-lg databox-inverted radius-bordered databox-shadowed databox-graded databox-vertical">
                                        <div class="databox-top bg-primary no-padding">
                                            <div id="visitors-chart" class="chart"></div>
                                        </div>
                                        <div class="databox-bottom no-padding">
                                            <div class="databox-row">
                                                <div class="databox-cell cell-6 text-left">
                                                    <span class="databox-text">Total No. of Employees</span>
                                                    <span class="databox-number">@{{employees.length}}</span>
                                                </div>
                                                <div class="databox-cell cell-6 text-right">
                                                    <span class="databox-text">@{{currentDate | date : 'yyyy'}}</span>
                                                    <span class="databox-number font-70">@{{(currentDate | date : 'yyyy').length}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="databox databox-lg databox-inverted radius-bordered databox-shadowed databox-graded databox-vertical">
                                        <div class="databox-top bg-primary no-padding">
                                            <div class="chart chart-xs"
                                                current-day="@{{ currentDate | date : 'dd' }}, @{{ currentDate | date : 'EEE' }}"
                                                current-month="@{{ currentDate | date : 'MM' }}, @{{ currentDate | date : 'MMMM' }}"
                                                current-year="@{{ currentDate | date : 'yyyy' }}"
                                                expense=""
                                                sales="1:12,1:10,1:2"
                                                bar-chart></div>
                                        </div>
                                        <div class="databox-bottom no-padding">
                                            <div class="databox-row">
                                                <div class="databox-cell cell-6 text-left">
                                                    <span class="databox-text">Total Expenses</span>
                                                    <span class="databox-number">76,109</span>
                                                </div>
                                                <div class="databox-cell cell-6 text-right">
                                                    <span class="databox-text">Total Sales</span>
                                                    <span class="databox-number font-70">7,540</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="databox databox-lg databox-inverted radius-bordered databox-shadowed databox-graded databox-vertical">
                                        <div class="databox-top bg-primary no-padding">
                                            <div id="horizonal-chart" class="chart chart"></div>
                                        </div>
                                        <div class="databox-bottom no-padding">
                                            <div class="databox-row">
                                                <div class="databox-cell cell-6 text-left">
                                                    <span class="databox-text">Cash On Hand</span>
                                                    <span class="databox-number">76,109</span>
                                                </div>
                                                <div class="databox-cell cell-6 text-right">
                                                    <span class="databox-text">@{{currentDate | date : 'MM/dd/yyyy'}}</span>
                                                    <span class="databox-number font-70">7,540</span>
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
@section('footer_scripts')
    <script type="text/javascript">
        $(function () {
            InitiateVisitorChart.init();
            InitiateHorizonalChart.init();
        });
    </script>
@stop
