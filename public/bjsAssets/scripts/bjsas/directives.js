'use strict';

angular.module('directives', [])
	.directive('selectPicker', ['$timeout',
		function($timeout) {
			return {
				restrict: 'A',

				link: function(scope, elem, attr) {
					$timeout(function() {
						elem.selectpicker({
							howSubtext: true
						});
					}, 10);

					scope.$watch(attr.selectPicker, function(newValue, oldValue) {
						if (newValue === oldValue) {
							return;
						}

						$timeout(function() {
							elem.selectpicker('refresh');
						}, 100);
					} );
				}
			};
		}
	] )
	.directive('datePicker', function( ) {
		return {
			link : function( scope, element, attr ) {

				var toDate = scope.toDate;

				if( attr.id === 'legalDP' ) {
					toDate = scope.legalAgeDate;
				}

				if( attr.id === 'payperiod' ) {
					toDate = '';
				}

				$(element).datepicker( {
					todayHighlight : true,
					todayBtn       : true,
					orientation    : 'top left',
					format         : 'mm/dd/yyyy',
					value          : toDate
				});
			}
		};
	} )
	.directive( 'showTemplate', function ( CSRF_TOKEN ) {
		return {
			scope    : true,
			template : '<div ng-include="contentUrl" class="row animated fadeInDown ng-scope"></div>',

			link : function(scope, element, attrs) {
				attrs.$observe( 'regTemplate', function( template ){
					scope.contentUrl = '';
					scope.csrf_token = '';
					if( angular.isDefined( template ) ) {
						scope.contentUrl = template;
						scope.csrf_token = CSRF_TOKEN;
					}
				} );
			},
		};
	} )
	.directive('repeatDone', function() {
		return function(scope, element, attrs) {
			if (scope.$last) { // all are rendered
				scope.$eval(attrs.repeatDone);
			}
		}
	})
	.directive( 'btnHide', function ( ) {
		return {
			restrict: 'A',

			link    : function(scope, element, attrs) {

				var expression   = attrs.btnHide;
				var durationUp   = ( parseInt( attrs.showDuration ) || "fast" )
				var durationDown = ( parseInt( attrs.showDuration ) || 100 )

				if( !scope.$eval( expression ) ) {
					element.hide();
				}

				scope.$watch( expression, function (newVal, oldVal) {
					if( newVal === oldVal ) {
						return;
					}

					if( newVal ) {
						element.stop( true, true ).slideDown( durationDown );
					} else {
						element.stop( true, true ).slideUp( durationUp );
					}

				} )
			},
		};
	} )
	.directive('tooltipShow', ['$timeout',
		function( $timeout ) {
			return {
				restrict: 'A',

				link: function(scope, element, attrs){
					scope.$watch('requestResult', function( data ) {
						$(element).removeClass( 'has-error' );

						if( data && data.type==='error' ) {
							if( data.errors[attrs['field']] || (attrs['name']==='agency' && data.errors['duplicate']) ) {
								$(element).addClass( 'has-error' );
								$(element).tooltip('show');
							}
							if( attrs['name']==='agency' && data.errors['duplicate'] && !element[0].firstElementChild.value ) {
								$(element).removeClass( 'has-error' );
								$(element).tooltip('hide');
								$(element).attr('data-original-title', '');
							}
						}

						if( !scope.requestResult ) {
							$(element).tooltip('hide');
						}
					});
				}
			};
		}
	] )
	.directive('leavePlurality', function () {
		return {
			template : 'Total no. of hour{{label.leave}} on leave'
		};
	} )
	.directive('barChart', ['expenseData', 'salesData', 'barOptions', function ( expenseData, salesData, barOptions ) {
		return {
			link: function( scope, elem, attrs ) {

				// get the number of days
				var month = attrs.currentMonth.split(', ');
				var daysInMonth = function( month, year ) {
					return new Date( year, month, 0 ).getDate();
				}( month[ 0 ], attrs.currentYear );

				var sales = attrs.sales.split(', ');

				// update expense data
				for(var day=1; day<=daysInMonth; day++) {
					salesData.data.push( [ day, Math.random() ] );
					expenseData.data.push( [ day, Math.random() ] );
				}

				barOptions.tooltipOpts.content = '<b>%x - ' + month[1] + '</b><br/><b>%s</b> : <span>%y</span>';

				var plot  = $.plot($(elem), [expenseData,salesData], barOptions);
			}
		};
	}] )
	.directive('notificationContainer', ['$compile', '$timeout', '$sce', 'toasterConfig', 'toaster',
		function ($compile, $timeout, $sce, toasterConfig, toaster) {
		return {
			replace: true,
			restrict: 'EA',
			link: function (scope, elm, attrs) {

				var id = 0;

				var mergedConfig = toasterConfig;
				if (attrs.toasterOptions) {
					angular.extend(mergedConfig, scope.$eval(attrs.toasterOptions));
				}

				scope.config = {
					position    : mergedConfig['position-class'],
					title       : mergedConfig['title-class'],
					message     : mergedConfig['message-class'],
					tap         : mergedConfig['tap-to-dismiss'],
					closeButton : mergedConfig['close-button'],
					animation   : mergedConfig['animation-class']
				};

				scope.configureTimer = function configureTimer(toast) {
					var timeout = typeof (toast.timeout) == "number" ? toast.timeout : mergedConfig['time-out'];
					if (timeout > 0)
						setTimeout(toast, timeout);
				};

				function addToast(toast) {
					toast.type = mergedConfig['icon-classes'][toast.type];
					if (!toast.type)
						toast.type = mergedConfig['icon-class'];

					id++;
					angular.extend(toast, { id: id });

					// Set the toast.bodyOutputType to the default if it isn't set
					toast.bodyOutputType = toast.bodyOutputType || mergedConfig['body-output-type']
					switch (toast.bodyOutputType) {
						case 'trustedHtml':
							toast.html = $sce.trustAsHtml(toast.body);
							break;
						case 'template':
							toast.bodyTemplate = toast.body || mergedConfig['body-template'];
							break;
					}

					scope.configureTimer(toast);

					if (mergedConfig['newest-on-top'] === true) {
						scope.toasters.unshift(toast);
						if (mergedConfig['limit'] > 0 && scope.toasters.length > mergedConfig['limit']) {
							scope.toasters.pop();
						}
					} else {
						scope.toasters.push(toast);
						if (mergedConfig['limit'] > 0 && scope.toasters.length > mergedConfig['limit']) {
							scope.toasters.shift();
						}
					}
				}

				function setTimeout(toast, time) {
					toast.timeout = $timeout(function () {
						scope.removeToast(toast.id);
					}, time);
				}

				scope.toasters = [];
				scope.$on('toaster-newToast', function () {
					addToast(toaster.toast);
				});

				scope.$on('toaster-clearToasts', function () {
					scope.toasters.splice(0, scope.toasters.length);
				});
			},
			templateUrl : '/bjsAssets/partials/notification.html'
		};
	}])
