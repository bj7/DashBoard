/**
 * Created by joshuabernitt on 12/18/13.
 *
 * Global Controllers file
 */

var controllers = angular.module('app.controllers', []);
    // main control routine for the app
controllers.controller ('AppCntrl', function ($scope, $location, $routeParams, updateDateService, $timeout, filterWOService) {
    $scope.pathToImage = pathToPackage_frontend+'/assets/calendar.png';

    // creating functions for the scope of the controller so parts of the app can call them
    $scope.update = function () {
        var path = $location.path();
        $location.path(path);
    };

    $scope.changeView = function (path) {
        if ((path === undefined) || (path == '')) {
            $location.path('/');
            return;
        }
        console.log(path);
        $location.path('/'+path);
    };

    // function to get parameters for the current route. Used in day directive
    $scope.getParams = function () {
        return $routeParams.name;
    };

    /*
        Classes for the model
    */
    // creating data store class for the model
    var DataStore = (function(){
        var json = '';
        $.ajax({url:pathToPackage_backend+"/calCntl.php",
            type:'POST',
            data:{update:true},
            dataType:'json',
            async: false})
            .done(function(data){
                json = data;
                //console.log(data);
            })
            .always(function(data){
                console.log({"completed operation to retrieve data":data});
            });

        return {getData: function(){
            if(json){
                return json;
            }
            else{
                return false;
            }
        }};
    });
    // defining new class for data model
    Model.prototype = new DataStore(); // giving model a prototype of DataStore; i.e. inheritance
    function Model(){
        // class update routine
        this.update = function(){
            //update the model in the view
            var model = this.getData();
            if((model === false) || (model.length === undefined)){
                return false;
            }
            if (model.work_orders === undefined) {
                model.work_orders = true;
            }
            if (model.employee_issues === undefined) {
                model.employee_issues = true;
            }
            if (model.customer_issues === undefined) {
                model.customer_issues = true;
            }
            if (model.myschedule === undefined) {
                model.myschedule = true;
            }
            console.log(model.myschedule);

            var workOrder = model.work_orders;
            console.log(workOrder);
            var empIssues = model.employee_issues;
            console.log(empIssues);
            var customerIssues = model.customer_issues;
            console.log(customerIssues);
            var myschedule = model.myschedule;
            console.log(myschedule);

            $scope.customerissues = model.customer_issues.length;
            $scope.emp_issues = model.employee_issues.length; // how many are there?
            $scope.work_order = model.work_orders.length; // how many?

            $scope.model = model;
            updateDateService($scope);
        };
        this.getCalData = function() {
            var calData = this.getData();
            //filtering
            return filterWOService(calData.work_orders);
        };
    }
    var myModel = new Model(); // instantiating new object
    //console.log(myModel);
    //check if model is valid
    if(myModel.update() === false){
        console.log({'myModel.update()':myModel.update()});
        $scope.updateStatus = 'Error in data retrieval!';
        return false;
    }
    //console.log(myModel);
    myModel.update();

    // creating local data store for information
    $scope.dataStore = myModel.getCalData();
    console.log('dataStore',{'dataStore':$scope.dataStore});
    console.log($scope.dataStore);

    // creating the timer poll operation to update the data every 1000's of milliseconds
    var timer = function () {
        //updateDateService($scope); // indicate initial update
        $timeout(function () {
            $scope.$apply(myModel.update());
            timer();
        }, 300000) // indicate how long to wait on timer pops (in milliseconds)
    };
    timer(); // call the function

});

