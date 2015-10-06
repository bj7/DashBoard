/**
 * Created by joshuabernitt on 12/18/13.
 *
 * Global services file.
 * currently used for data model
 */

var services = angular.module('app.services', []);

services.service('Model', function($scope){
    // creating data store class for the model
    var DataStore = (function(){
        var json = null;
        $.ajax({url:pathToPackage_backend+"/calCntl.php",
            type:'POST',
            data:{update:true},
            dataType:'json',
            async: false})
            .done(function(data){
                json = data;
            })
            .always(function(){
                console.log("completed operation to retrieve data");
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
            console.log(model);

            var workOrder = model.work_orders;
            console.log(workOrder);
            var empIssues = model.employee_issues;
            console.log(empIssues);

            $scope.emp_issues = model.employee_issues.length; // how many are there?
            $scope.work_order = model.work_orders.length; // how many?

            $scope.model = model;
            updateDateService($scope);
        };
        this.getCalData = function() {
            var calData = this.getData();
            return calData.work_orders;
        };
    }
    var myModel = new Model(); // instantiating new object
    return myModel;
});
