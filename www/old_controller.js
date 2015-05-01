var app = angular.module('SankaraEye', ['ionic'])

.run(function() {

})


//For Drop Down Practice
app.value('env',[
                 { proc: "Proc-1", board: "Alloc" },
                 { proc: "Proc-1", board: "Manager" },
                 { proc: "Proc-1", board: "Ops" },
                 { proc: "Proc-2", board: "Alloc" },
                 { proc: "Proc-2", board: "Manager" },
                 { proc: "Proc-3", board: "Alloc" },
                 { proc: "Proc-3", board: "Manager" }
                 ])

.directive('d1',['env', '$location', function(env, $location){
                 return {
                 link: function($scope) {
                 $scope.env = env;
                 console.log("setting here first", $scope.env)
                 },
                 scope:{
                 usersel:'='
                 },
                 templateUrl: 'd1menu.html',
                 controller:function($scope){
                 $scope.new_sel = {};
                 console.log("checking first", $scope.env)
                 for ( var x in env ) {
                 //console.log(x)
                 if ( angular.equals(env[x], $scope.usersel) ) {
                 $scope.new_sel = env[x];
                 break;
                 }
                 }
                 //angular.copy($scope.usersel, $scope.new_sel);
                 $scope.onSel = function(){
                 angular.extend($scope.usersel, $scope.new_sel);
                 console.log("onSel new value of usersel=", $scope.usersel);
                 $location.path("/dashboard");
            }
        }
    };
}])



.directive('resetField', ['$compile', '$timeout', function($compile, $timeout) {
    return {
    require: 'ngModel',
    scope: {},
    link: function(scope, el, attrs, ctrl) {
	// limit to input element of specific types
	var inputTypes = /text|search|tel|url|email|password/i;
        if (el[0].nodeName === "INPUT") {
            if (!inputTypes.test(attrs.type)) {
                throw new Error("Invalid input type for resetField: " + attrs.type);
            }
        } else if (el[0].nodeName !== "TEXTAREA") {
            throw new Error("resetField is limited to input and textarea elements");
        }


	var template = $compile('<i ng-show="enabled" ng-click="reset()" class="icon ion-android-close reset-field-icon"></i>')(scope);
        el.addClass("reset-field");
        el.after(template);

        scope.reset = function() {
            ctrl.$setViewValue(null);
            ctrl.$render();
            $timeout(function() {
                el[0].focus();
            }, 0, false);
            scope.enabled = false;
        };

        el.bind('input', function() {
            scope.enabled = !ctrl.$isEmpty(el.val());
        })
        .bind('focus', function() {
            $timeout(function() { //Timeout just in case someone else is listening to focus and alters model
                scope.enabled = !ctrl.$isEmpty(el.val());
                scope.$apply();
            }, 0, false);
        })
       .bind('blur', function() {
            $timeout(function() {
                scope.enabled = false;
                scope.$apply();
            }, 0, false);
        });
    }
    };
}]);


app.config(function($stateProvider, $urlRouterProvider) {

	$stateProvider
		.state('main', {
			url: '/main',
			templateUrl: 'templates/main.html'
		})
    		.state('signin', {
      			url: '/sign-in',
      			templateUrl: 'templates/sign-in.html'
    		})
           .state('create_account', {
                  url: '/createAccount',
                  templateUrl: 'templates/createAccount.html'
                  })
		.state('addSchoolProfile', {
      			url: '/addSchoolProfile',
	  		templateUrl: 'templates/addSchoolProfile.html'
    		})

		.state('home', {
			url: 'tab/home',
		        templateUrl: 'templates/home.html'
	         })
		.state('viewSchoolProfile', {
      		url: '/viewSchoolProfile',
      			templateUrl: 'templates/viewSchoolProfile.html'
    		})
		.state('addStudentProfile', {
      		url: '/addStudentProfile',
      			templateUrl: 'templates/addStudentProfile.html'
    		})
		.state('viewStudentProfile', {
      		url: '/viewStudentProfile',
      			templateUrl: 'templates/viewStudentProfile.html'
    		})
        .state('tabs', {
      		url: '/tab',
      			abstract: true,
      			templateUrl: 'templates/tabs.html'
    	})
    	.state('tabs.home', {
      		url: '/home',
               views: {
        			'home-tab': {
         				templateUrl: 'templates/home.html'
        		}
      		}
    	})
    	.state('tabs.about', {
      		url: '/about',
      			views: {
        			'about-tab': {
          				templateUrl: 'templates/about.html'
        			}
      			}	
    		})
		.state('tabs.search', {
      		url: '/search',
      			views: {
        			'search-tab': {
          				templateUrl: 'templates/search.html' 
        			}
      			}
    		})
		.state('search_students', {
      		url: '/search_students',
          		templateUrl: 'templates/search_students.html' 
    		})

   		$urlRouterProvider.otherwise('/main');
})

app.controller('MainCtrl', function($scope, $state, $http, $ionicPopup) {

	get_schools();

	function get_schools() {
		$http.get("db.php?action=get_schools").success(function(data)
		{
			$scope.schools = data;
		});
	}
  
  	$scope.pagedItems = [];
  	$scope.add_sch = true;
  
  	$scope.ENGLISH = function() {
        console.log('English');
        $state.go('signin');
  	}
    
    $scope.goSignIn = function() {
        console.log('Back to Sign In Page');
        $state.go('signin');
    }

  	$scope.signIn = function(data) {
    		console.log('Sign-In', data);
        	$http.post('db.php?action=sign_in', 
            	{
                	'username'     	: data.username,
                    'password'	: data.password
		}) 
        	.success(function (data, status, headers, config) {
			if (String(data).valueOf() == String("no").valueOf()) {
           			var alertPopup = $ionicPopup.alert({
					title: '<center> <b>Invalid Username or Password </b> </center>',
					template: '<center> <b> Please Try Again </b> </center>'
				});
				alertPopup.then(function(res) {
					console.log('Try Login Again');
				});
			} else if (String(data).valueOf() == String("empty").valueOf()) {
           			var alertPopup = $ionicPopup.alert({
					title: '<center> <b>Enter Username or Password </b> </center>',
					template: '<center> <b> Please Try Again </b> </center>'
				});
				alertPopup.then(function(res) {
					console.log('Try Login Again');
				});
			} else {
				console.log('data:', data);
				$state.go('tabs.home');
			}
        	})
        	.error(function(){
           		var alertPopup = $ionicPopup.alert({
				title: '<center> <b>Invalid Username or Password </b> </center>',
				template: '<center> <b> Please Try Again </b> </center>'
			});
			alertPopup.then(function(res) {
				console.log('Try Login Again');
			});
        	});
  	}
               
    $scope.createAccount = function() {
               console.log('Create New Account');
               $state.go('create_account');
    }
    $scope.createNewAccount = function(data) {
               console.log('Create New Account');
               if (!data.new_username || !data.new_password ) {
                    var alertPopup = $ionicPopup.alert({
                        title: '<center> <b> Please fill in missing fields </b> </center>',
                        template: '<center> <b> Try Again </b> </center>'
                    });
                    alertPopup.then(function(res) {
                        console.log('Try Login Again');
                    });
               } else {
                    var confirmPopup = $ionicPopup.confirm({
                        title: '<center> <b> Is the information correct? </b> </center>',
                        template: '<b> Username: </b>' + data.new_username + '<br> <b> Password: </b>' + data.new_password,
                    });
                    confirmPopup.then(function(res) {
                        if(res) {
                            console.log('Confirm');
                            $http.post('db.php?action=exists',
                            {
                                'username'     	: data.new_username,
                                'password'      : data.new_password
                            })
                            .success(function (data, status, headers, config) {
                                var alertPopup2 = $ionicPopup.alert({
                                    title: '<center> <b>' + data + '</b> </center>'
                                });
                                alertPopup2.then(function(res) {
                                });
                                $state.go('signin');
                            })
                            .error(function(data, status, headers, config){
                                             
                            });
                                               
                        } else {
                            console.log('Go Back');
                        }
                    });
               }
               
    }
  
  	$scope.language = function() {
    		console.log('Language');
    		$state.go('main');
  	}
  
    	$scope.search = function() {
    		console.log('Search');
    		$state.go('tabs.search');
	}

    	$scope.search_students = function() {
    		console.log('Searching Students');
    		$state.go('search_students');
	}
	
    	$scope.cancel = function() {
		console.log('Cancel');
		$state.go('tabs.search');
	}
	
    	$scope.school_cancel = function() {
		console.log('Cancel');
		$state.go('tabs.home');
	}

	$scope.get_school = function() {
        	$http.post("db.php?action=get_school", 
		{
			'schoolname' : "Santa Clara University"
		})
		.success(function(data)
        	{
            		$scope.pagedItems = data;    
        	});
    	}

	$scope.get_schools = function() {
        	$http.get("db.php?action=get_schools").success(function(data)
        	{
            		//$scope.product_detail = data;   
            		$scope.pagedItems = data;    
        	});
    	}

	$scope.get_student = function() {
        	$http.get("db.php?action=get_student").success(function(data)
        	{
            		//$scope.product_detail = data;   
            		$scope.student_info = data;    
        	});
    	}

	$scope.get_students = function() {
        	$http.get("db.php?action=get_students").success(function(data)
        	{
            		//$scope.product_detail = data;   
            		$scope.pagedItems = data;    
        	});
    	}		
	
	var default_school_form = {
		schoolname 	: "",
		screening_date	: "",
		headmaster 	: "",
		address 	: "",
		phone		: "",
		cosponsor	: "",
		cosponsor_phone : "",
		person_in_charge_phone : ""
	}

	$scope.reset_school_form = function(data) {
		//$scope.add_school.$setPristine();
		$scope.data = angular.copy(default_school_form);
	}

    	$scope.school_submit = function(data) {
        	$http.post('db.php?action=add_school', 
            	{
                	'schoolname'     	: data.schoolname, 
                	'screening_date'     	: data.screening_date, 
                	'headmaster'    	: data.headmaster,
                	'address' 		: data.address,
			'phone' 		: data.phone,
			'cosponsor' 		: data.cosponsor,
			'cosponsor_phone' 	: data.cosponsor_phone,
            'person_in_charge' : data.person_in_charge,
			'person_in_charge_phone' : data.person_in_charge_phone
            	})
        	.success(function (data, status, headers, config) {
			$scope.reset_school_form(data);
			//$scope.add_school.$setPristine();
			$state.go('tabs.home');
          		//$scope.get_school();
        	})
        	.error(function(data, status, headers, config){
           
        	});
    	}

    	$scope.student_submit = function(data) {
        	$http.post('db.php?action=add_student', 
            	{
                	'firstname'     	: data.firstname, 
                	'lastname'     		: data.lastname,
                	'screening_site'     	: data.screening_site,
                	'gender'     		: data.gender, 
                	'birth_date'     	: data.birth_date,
                	'role_no'     		: data.role_no,
                	'class'     		: data.class,
                	'section'     		: data.section,
                	'teacher'     		: data.teacher, 
                	'school'     		: data.school,
                	'parent_name'     	: data.parent_name,
                	'screen_date'     	: data.screen_date, 
                	'screened_by'     	: data.screened_by,
                	'diagnosis'     	: data.diagnosis,
                	'secondary_date'     	: data.secondary_date,
                	'depth_perception'     	: data.depth_perception,
                	'muscle_imbalance'     	: data.muscle_imbalance, 
                	'colour_vision'     	: data.colour_vision,
                	'squint'     		: data.squint,
                	'va_r'     		: data.va_r,
                	'as_r'     		: data.as_r,
                	'om_r'     		: data.om_r,
                	'fundux_r'     		: data.fundux_r, 
                	'iop_r'     		: data.iop_r,
                	'duct_r'     		: data.duct_r,
                	'amblyopia_r'     	: data.amblyopia_r,
                	'va_l'     		: data.va_l,
                	'as_l'     		: data.as_l,
                	'om_l'     		: data.om_l,
                	'fundux_l'     		: data.fundux_l, 
                	'iop_l'     		: data.iop_l,
                	'duct_l'     		: data.duct_l,
                	'amblyopia_l'     	: data.amblyopia_l,
			'notes'			: data.notes


            	})
        	.success(function (data, status, headers, config) {
			//$scope.reset_school_form(data);
			//$scope.add_school.$setPristine();
			$state.go('search_students');
          		//$scope.get_school();
        	})
        	.error(function(data, status, headers, config){
           
        	});
    	}

    	$scope.cancel = function() {
		console.log('Cancel');
		$state.go('search_students');
	}

    	$scope.addSchoolProfile = function() {
		console.log('Add School Profile');
		$state.go('addSchoolProfile');
	}

	$scope.addStudentProfile = function() {
		console.log('Add Student Profile');
		$state.go('addStudentProfile');
	}


	$scope.home = function() {
		console.log('Home');
		$state.go('tabs.home');
	}

	$scope.school = [];

	$scope.viewSchoolProfileTest = function(school_name) {
/*
        	$http.get("db.php?action=get_school&school_name=Santa Clara University").success(function(data)
        	{
            		//$scope.product_detail = data;   
            		$scope.school = data;    
        	});
*/
		console.log('view School Profile');
		//$scope.schoolname = schoolname;
		$state.go('viewSchoolProfile');
	}

	$scope.viewSchoolProfile = function() {
		console.log('view School Profile');
		//$scope.schoolname = schoolname;
		$state.go('viewSchoolProfile');
	}

	$scope.viewStudentProfile = function() {
		console.log('view Student Profile');
		$state.go('viewStudentProfile');
	}
  	/*
   	* if given group is the selected group, deselect it
   	* else, select the given group
   	*/
  	$scope.toggleGroup = function(group) {
    		if ($scope.isGroupShown(group)) {
      			$scope.shownGroup = null;
    		} else {
      			$scope.shownGroup = group;
    		}
  	}
  	$scope.isGroupShown = function(group) {
    		return $scope.shownGroup === group;
  	}

//For slider
	$scope.myTitle = 'Template';
	
	$scope.data = { 'volume' : '5' };
	
	var timeoutId = null;
	
	$scope.$watch('data.volume', function() {
	    
	    
	    console.log('Has changed');
	    
	    if(timeoutId !== null) {
		console.log('Ignoring this movement');
		return;
	    }
	    
	    console.log('Not going to ignore this one');
	    timeoutId = $timeout( function() {
		
		console.log('It changed recently!');
		
		$timeout.cancel(timeoutId);
		timeoutId = null;
		
		// Now load data from server 
	    }, 1000); 
	    
	    
	});


  
});
