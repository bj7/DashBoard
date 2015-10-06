/**
 * Primary app file for webcal
 *
 * @author Created by Joshua Bernitt on 11/14/13. <jjbernitt@gmail.com>
 *
 * var pathToPackage_frontend is necessary and is provided immediately before this file in the html
 */
'use strict';
// creating the app
var app = angular.module ('app', ['app.controllers'], ['ngRoute']);

/**
 * Config
 */
app.config(function ($routeProvider) {
    $routeProvider.when('/',{
        templateUrl:"defaultTmpl.html"
        //controller: "AppCntrl"
    })
        .when('/day/:name', {
            templateUrl:"dayTmpl.html",
            controller:"dayViewCntrl"
        })
        .when('/week', {
            templateUrl:'weekTmpl.html',
            controller:"weekViewCntrl"
        })
        .when('/schedule/:name', {
            templateUrl:"schedTmpl.html",
            controller:"dayViewCntrl"
        })
        .when('/workorders', {
            templateUrl:"workordersTmpl.html"
        })
        .when('/empissues', {
            templateUrl:'empissuesTmpl.html'
        })
        .when('/customerissues', {
            templateUrl:'customerissuesTmpl.html'
        })
        .when('/myschedule', {
            templateUrl: 'myscheduleTmpl.html'
        })
        .otherwise({
            redirectTo:"/"
        });
});

/**
 * Factory Routines
 */

// basic service to calculate the time of latest update
app.factory ('updateDateService', ['updateDateService'], function () {
    return function (scope) {
        console.log("time updated");
        var d = new Date();
        var hour = ''; // default
        var AP = ''; // default
        if (d.getHours() > 12) {
            hour = d.getHours() - 12;
            AP = 'pm';
        } else if (d.getHours() == 12) {
            hour = d.getHours();
            AP = 'pm';
        } else {
            hour = d.getHours();
            AP = 'am';
        }

        if(d.getMinutes() < 10) {
            var minutes = '0' + d.getMinutes();
        } else {
            var minutes = d.getMinutes();
        }
        scope.updateStatus = "updated as of " + (d.getMonth() + 1) + "/" + d.getDate() + "/" +
            d.getFullYear() + " " + hour + ':' + minutes + ":" + d.getSeconds() + AP;

    };
});

app.factory('filterWOService', ['filterWOService'], function(){
   return function(array){
       // setting up the date object
       var today = new Date();
       var dayNum = today.getDay();
       var d = today.getDate();

       //get the date of the first day
       today.setDate(d - dayNum + 0);
       var day0 = today.getDate();
       if (day0 < 10) {
           day0 = '0'+day0;
       }
       var month0 = (today.getMonth()+1);
       if (month0 < 10) {
           month0 = '0'+month0;
       }
       var year0 = today.getFullYear();
       var date0 = year0+'-'+month0+'-'+day0;

       //get the day of the last day
       today = new Date();
       var day6 = today.getDate() + 6;
       //test if we jump to new month
       var newmonth = 0;
       if(day6 > 31){
           day6 -= 30;
           newmonth = 1;
       }
       if (day6 < 10) {
           day6 = '0' + day6;
       }
       var month6 = (today.getMonth()+1);
       //test if we have a new year
       month6 += newmonth;
       var newyear = 0;
       if(month6 > 12){
           month6 -= 12;
           newyear = 1;
       }
       if (month6 < 10) {
           month6 = '0'+month6;
       }
       //ensure we take into account a potential jump in the year
       var year6 = today.getFullYear() + newyear;
       var date6 = year6+'-'+month6+'-'+day6;

       //setting up used variables in loop
       var count = 0;
       var d1 = Date.parse(date0);
       var d2 = Date.parse(date6);
       var filtered = [];
       //filter the work orders in the array based on their date
       for(var i = 0; i < array.length; i++){
           var date = Date.parse(array[i].date);
           console.log('Inside filterWOService',{'date0':date0, 'date6':date6, 'd1':d1,'d2':d2, 'date':date},array);
           if((date >= d1) && (date <= d2)){
               filtered[count] = array[i];
               count++;
           }
       }
       console.log('filtered',{'filtered':filtered});
       return filtered;
   };
});

/**
 * Control Routines
 */
app.controller('weekViewCntrl', function ($scope) {
    // setting up the date object
    var today = new Date();
    var dayNum = today.getDay();
    var d = today.getDate();

    // placing the correct date into each header element for the calendar
    today.setDate(d - dayNum + 0);
    $scope.date0 = (today.getMonth()+1) + '-' + today.getDate();

    today = new Date();
    today.setDate(d - dayNum + 1);
    $scope.date1 = (today.getMonth()+1) + '-' + today.getDate();

    today = new Date();
    today.setDate(d - dayNum + 2);
    $scope.date2 = (today.getMonth()+1) + '-' + today.getDate();

    today = new Date();
    today.setDate(d - dayNum + 3);
    $scope.date3 = (today.getMonth()+1) + '-' + today.getDate();

    today = new Date();
    today.setDate(d - dayNum + 4);
    $scope.date4 = (today.getMonth()+1) + '-' + today.getDate();

    today = new Date();
    today.setDate(d - dayNum + 5);
    $scope.date5 = (today.getMonth()+1) + '-' + today.getDate();

    today = new Date();
    today.setDate(d - dayNum + 6);
    $scope.date6 = (today.getMonth()+1) + '-' + today.getDate();
});

// specific to day detail view. loads the day into the model based on the current route params
app.controller('dayViewCntrl', function ($scope, $routeParams) {
    $scope.dayName = $routeParams.name;
    $scope.selectTime = function(invitee, time){
        console.log(invitee + "@" + time);
    };
});

/**
 * Directives
 */

//default directive that simply shows the header of the calendar since that is always needed
app.directive ('default', function () {
    var linkFn = function () {
        var d = new Date();
        // gather the current day of the week and mark it
        var weekDay = [];
        weekDay[0] = 'Sun';
        weekDay[1] = 'Mon';
        weekDay[2] = 'Tues';
        weekDay[3] = 'Wed';
        weekDay[4] = 'Thurs';
        weekDay[5] = 'Fri';
        weekDay[6] = 'Sat';
        $("#"+weekDay[d.getDay()]).addClass('cur-day');
    };
    return {
        restrict: 'A',
        link: linkFn
    }
});

// directive to highlight the hours occupied during the week overview
app.directive('markTime', function () {
    var linkFn = function (scope) {
        var data = scope.dataStore;
        for (var i = 0; i < data.length; i++) {
            if (data[i].start == data[i].end) { //if the start and stop times are the same just mark that hour
                j = data[i].start;
                $("#"+data[i].day+j).addClass("webcal-colored");
            } else{
                for (var j = data[i].start; j < data[i].end; j++)
                    $("#"+data[i].day+j).addClass("webcal-colored");
            }
        }
    };
    return {
        restrict: 'A',
        link: linkFn
    }
});

// add the event and highlights the hours in a day detail view
app.directive('dayDetails', function () {
    var linkFn = function (scope) {
        var data = scope.dataStore;
        function markHours (details) {
            var mark = "";
            for (var j = 8; /* default calendar start time */ j <= 18; /* default calendar end */ j++) {
                if ((details.start <= j) && (j < details.end)){
                    mark += "<td class='webcal-colored'></td>";
                } else {
                    mark += "<td></td>";
                }
            }
            return mark;
        }
        for (var i =0; i < data.length; i++) {
            if (data[i].day == scope.getParams()) {
                $("#dayInsertionPoint").append(
                    "<tr>" +
                        "<td>" + data[i].eventName + "</td>" +
                        markHours(data[i]) +
                        "</tr>"
                );
            }
        }
        scope.dayName = scope.getParams();
    };
    return {
        restrict:'A',
        link: linkFn
    }
});

app.directive('schedDetails', function($compile){
    return {
        link: function (scope) {
            var data = scope.dataStore;
            function markHours (details, invitee) {
                var mark = "";
                for (var j = 8; /* default calendar start time */ j <= 18; /* default calendar end */ j++) {
                    if ((details.start <= j) && (j < details.end)){
                        mark += "<td class='webcal-colored'></td>";
                    } else {
                        mark += "<td ng-click=\"selectTime('"+ invitee + "', "+ j +")\"></td>";
                    }
                }
                return mark;
            }

            for (var i =0; i < data.length; i++) {
                if (data[i].day == scope.getParams()) {
                    for (var j = 0; j < data[i].invites.length; j++) {
                        $("#dayInsertionPoint").append($compile(
                            "<tr>" +
                                "<td>" + data[i].invites[j] + "</td>" +
                                markHours(data[i], data[i].invites[j]) +
                                "</tr>"
                        )(scope));
                    }
                }
            }
            scope.dayName = scope.getParams();
        }
    };
});