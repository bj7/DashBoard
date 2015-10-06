var myapp = angular.module('starter', []);

myapp.config(function($routeProvider, $locationProvider) {

	// Set up the initial routes that our app will respond to.
  	// These are then tied up to our nav router which animates and
  	// updates a navigation bar
	$routeProvider.when('/home', {
		templateUrl: 'templates/app.html',
		controller: 'AppCtrl'
	});

	$routeProvider.when('/pet/:petId', {
		templateUrl: 'templates/pet.html',
		controller: 'PetCtrl'
	});

	$routeProvider.otherwise({
		redirectTo: '/home'
	});

});

myapp.controller('HelloWorldCntrl', function ($scope) {
	$scope.message = 'Angular.JS';
});

