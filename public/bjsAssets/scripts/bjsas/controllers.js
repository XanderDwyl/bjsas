'use strict';

angular.module('controllers', [ 'angularMoment' ])
	.controller('employeesController', function($scope, $element, $timeout, $attrs, $http, Api, DaysWorked, toaster) {
		$scope.totalDeduction      = 0;
		$scope.daysofworked        = 0;
		$scope.label               = [];
		$scope.requestOff          = true;
		$scope.requestResult       = false;
		$scope.closeTemplate       = true;
		$scope.employees           = [];
		$scope.employeesWithSalary = [];
		$scope.fieldValue          = false;

		$scope.hiredMonth = [];



		$scope.init = function () {
			$scope.getCurrentDate();
			$scope.getEmployees();
			$scope.getEmployeesWithSalary();
		};

		$scope.setLoading = function(loading) {
			$scope.isLoading = loading;
		};

		$scope.fetchDone = function() {
			$scope.setLoading(false);
		};

		$scope.getCurrentDate = function () {

			var today = new Date();
			var yr    = today.getFullYear() - 18;
			var dt    = today.getDate();
			var mt    = today.getMonth() + 1;

			var formatTwo = function ( ) {
				return ( arguments[ 0 ] < 10 ) ? '0' + arguments[0] : arguments[0];
			};

			$scope.legalAgeDate = formatTwo( mt ) + '/' + formatTwo( dt ) + '/' + yr;
			$scope.toDate       = formatTwo( mt ) + '/' + formatTwo( dt ) + '/' + today.getFullYear();
		};

		$scope.getEmployees = function( ) {
			Api.get( 'All', 'employee').then( function( response, status) {
				$scope.employees = response.data;
				var collection   = $scope.employees;

				collection.forEach( function ( model ) {
					$scope.hiredMonth.push( model['hired_date'] );
				});
			} );
		};
		$scope.getEmployeesWithSalary = function( ) {
			$scope.setLoading(true);
			Api.get( 'All', 'salary').then( function( response, status) {
				$scope.setLoading(false);
				$scope.employeesWithSalary = response.data;
			} );
		};
		$scope.getEmployeeRecord = function( query ) {
			Api.get( query, 'salary' )
				.then( function( response, status) {

					$scope.salaryperhr  = '';
					$scope.salaryRate   = 0;
					$scope.isSalaryRate = 0;

					if( response.data.salary_rates && response.data.salary_rates.length > 0 ) {
						$scope.salaryRate = response.data.salary_rates[ 0 ].amount;
						$scope.salaryperhr = ($scope.salaryRate || 0) / 8;
					} else {
						$scope.isSalaryRate = 1;
					}

					if ( !$scope.daysofworked ) {
						$scope.setDaysOfWorked( null );
					} else {
						$scope.computeSalary();
					}
				} );
		};

		$scope.createEmployee = function( data ) {
			data = data || {};
			Api.create( data, 'employee' )
				.then( function( response, status ) {
					response.data.icon = 'fa-check';
					if( response.data.type==='error' ) {
						response.data.message = 'Sorry, I can\'t proceed with errors! This useful information is highly needed.';
					} else {
						$scope.getEmployees();
						$scope.hideContent();
					}
					$scope.requestResult = response.data;
					toaster.pop(response.data.type, response.data.message);
				});
		};
		$scope.removeEmployee = function( data ) {
			Api.delete( data.id, 'employee' )
				.then( function( response ) {
					if( response.data.type === 'success' ) {
						$scope.employees.splice( $scope.employees.indexOf(data), 1 );
					}
					toaster.pop(response.data.type, response.data.message);
				});
		};
		$scope.addSalary = function( data ) {
			data = data || {};
			Api.create( data, 'salary' )
				.then( function( response, status ) {
					response.data.icon = 'fa-check';
					if( response.data.type==='error' ) {
						response.data.message = 'Sorry, I can\'t proceed with errors! This useful information is highly needed.';
					} else {
						$scope.getEmployeesWithSalary();
						$scope.hideContent();
					}
					$scope.requestResult = response.data;
					toaster.pop(response.data.type, response.data.message);
				});
		};
		$scope.removeSalary = function( data ) {
			Api.delete( data.id, 'salary' )
				.then( function( response ) {
					if( response.data.type === 'success' ) {
						$scope.employeesWithSalary.splice( $scope.employeesWithSalary.indexOf(data), 1 );
					}
					toaster.pop(response.data.type, response.data.message);
				});
		};

		$scope.leaveLabel = function ( deduction ) {
			$scope.updateLabel( 'leave', deduction );
		};

		$scope.updateLabel = function ( attr, options ) {
			$scope.label[attr] = options.leave > 1 && 's' || '';
		};

		$scope.computeDeduction = function ( deduction ) {
			var leaveDeduction = parseFloat( deduction.leave || 0 ) * parseFloat( $scope.salaryperhr || 0 );

			$scope.leaveLabel( deduction );
			$scope.totalDeduction = parseFloat( deduction.sss || 0 ) +
									parseFloat( deduction.pagibig || 0) +
									parseFloat( deduction.philhealth || 0) +
									parseFloat( deduction.capayment || 0) +
									parseFloat( leaveDeduction );

			$scope.computeSalary();
		};

		$scope.setDaysOfWorked = function ( dateWorked ) {
			dateWorked = dateWorked || 0;
			$scope.daysofworked = DaysWorked.count( dateWorked );
			$scope.computeSalary();
		};

		$scope.computeSalary = function () {
			$scope.workedinhr = parseInt($scope.daysofworked, 10) * 8;
			$scope.subtotal   = $scope.workedinhr * $scope.salaryperhr;
			console.log($scope.subtotal);
			$scope.netincome  = $scope.subtotal - $scope.totalDeduction;
		};
		$scope.showContent = function ( template ) {
			$scope.closeTemplate = false;
			$scope.template      = template;
		};
		$scope.hideContent = function ( ) {
			$scope.closeTemplate = true;
			$scope.template      = '';
		};
		$scope.resetContent = function ( ) {
			$scope.requestResult = false;
		};

		$scope.stopTimer = function (toast) {
			if (toast.timeout) {
				$timeout.cancel(toast.timeout);
				toast.timeout = null;
			}
		};

		$scope.restartTimer = function (toast) {
			if (!toast.timeout)
				$scope.configureTimer(toast);
		};

		$scope.removeToast = function (id) {
			var i = 0;
			for (i; i < $scope.toasters.length; i++) {
				if ($scope.toasters[i].id === id)
					break;
			}
			$scope.toasters.splice(i, 1);
		};

		$scope.remove = function (id) {
			if ($scope.config.tap === true) {
				$scope.removeToast(id);
			}
		};
		$scope.click = function (toaster, isCloseButton) {
            if ($scope.config.tap === true) {
                var removeToast = true;
                if (toaster.clickHandler) {
                    if (angular.isFunction(toaster.clickHandler)) {
                        removeToast = toaster.clickHandler(toaster, isCloseButton);
                    }
                    else if (angular.isFunction($scope.$parent.$eval(toaster.clickHandler))) {
                        removeToast = $scope.$parent.$eval(toaster.clickHandler)(toaster, isCloseButton);
                    }
                    else {
                        console.log("TOAST-NOTE: Your click handler is not inside a parent scope of toaster-container.");
                    }
                }
                if (removeToast) {
                    $scope.removeToast(toaster.id);
                }
            }
        };
	} );
