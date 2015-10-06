<?php
/**
 * User: joshuabernitt
 * Date: 12/4/13
 * Time: 4:40 PM
 */

/**
 * Main view file
 *
 * @author <jjbernitt@gmail.com> Josh Bernitt
 *
 * File displays the web calendar app. Returns true if all data passed in is successful otherwise false to indicate
 * an error.
 */
 
 //echo("<h1>Hello World</h1>"); exit;

$frontend = $root_path.'front_end/';
$backend  = $root_path.'php_backend/controller/';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Web Cal Main View</title>
    <link href='<? echo $frontend."assets/bootstrap/css/bootstrap.min.css"?>' rel="stylesheet" type="text/css"/>
    <link href='<? echo $frontend."assets/bootstrap/css/bootstrap-responsive.min.css"?>' rel="stylesheet" type="text/css"/>
    <link href=<? echo $frontend."assets/webcal.css" ?> rel="stylesheet" type="text/css" />
</head>
<body>
<br>
<!-- outter wrapper for the app in the html page -->

<div ng-app="app" class="webcal">

    <div ng-controller="AppCntrl" id="header">
        <div class="webcal-menu-bar">
            <button class="webcal-button" ng-click="changeView()">Dash Board</button>
            <button class="webcal-button" ng-click="changeView('week')">Week Overview</button>
            <!--<button class="webcal-button" ng-click="changeView('day')">Day Details</button>-->
            <!--<button class="webcal-button" ng-click="changeView('schedule')">Schedule View</button>-->
            <!-- <button class="webcal-button" ng-click="update();">Refresh</button> -->
            <label>{{updateStatus}}</label>
        </div>
        <div ng-view id="body" class="webcal-body-container"></div>
    </div>
    <!-- Templates Section! Do Not Remove! -->
    <script type="text/ng-template" id="defaultTmpl.html">
        <div class="webcal-container">
            <div-1>
                <h1><a href="#/empissues">Employee Alerts: {{emp_issues}}</a></h1>
                <br/>
                <h1><a href="#/customerissues">Customer Visit Requests: {{customerissues}}</a></h1>
            </div-1>
            <div-2>
                <h1><a href="#/workorders">Work Orders In Progress: {{work_order}}</a></h1>
                <br/>
                <h1><a href="#/myschedule">My Day</a></h1>
            </div-2>
            <div-3>
                <!--<a href="#/week"> -->
                <a href="../functions/adminRoutines/LogonEvents.php">
                    <img src={{pathToImage}} width="100px" height="100px" alt=""/>
                </a>
            </div-3>
        </div>
    </script>
    <script type="text/ng-template" id="myscheduleTmpl.html">
        <table class=webcal-table-generic>
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Start Time</th>
                    <th>Projected End Time</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Description of Work to be Performed</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-model="model.myschedule" ng-repeat="i in model.myschedule">
                    <td>{{model.myschedule[$index].projName}}</td>
                    <td>{{model.myschedule[$index].start}}</td>
                    <td>{{model.myschedule[$index].end}}</td>
                    <td>{{model.myschedule[$index].customerName}}</td>
                    <td>{{model.myschedule[$index].location}}</td>
                    <td>{{model.myschedule[$index].description}}</td>
                </tr>
            </tbody>
        </table>
    </script>
    <script type="text/ng-template" id="customerissuesTmpl.html">
        <table id="tableHeader" class="webcal-table-generic">
            <thead>
            <tr>
                <th>Customer Name</th>
                <th>Company Name</th>
                <th>Issue</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-model="model.customer_issues" ng-repeat="i in model.customer_issues">
                <td>{{model.customer_issues[$index].name}}</td>
                <td>{{model.customer_issues[$index].company_name}}</td>
                <td>{{model.customer_issues[$index].issue}}</td>
            </tr>
            </tbody>
        </table>
    </script>
    <script type="text/ng-template" id="workordersTmpl.html">
        <table id="tableHeader" class="webcal-table-generic">
            <thead>
            <tr>
                <th>Start Date</th>
                <th>Work Order #</th>
                <th>Customer Name</th>
                <th>Employees Assigned</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-model="model.work_orders" ng-repeat="i in model.work_orders">
                <td>{{model.work_orders[$index].date}}</td>
                <td>
                    <a data-ng-href="<? echo $_SESSION['QUERIES']; ?>IN4C_WorkOrderDetailQuery.php?WOfromCalender={{model.work_orders[$index].eventName}}">
                        {{model.work_orders[$index].eventName}}
                    </a>
                </td>
                <td>{{model.work_orders[$index].customerName}}</td>
                <td>{{model.work_orders[$index].invites}}</td>
            </tr>
            </tbody>
        </table>
    </script>
    <script type="text/ng-template" id="empissuesTmpl.html">
        <table id="tableHeader" class="webcal-table-generic">
            <thead>
            <tr>
                <th>Name</th>
                <th>Issue</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-model="model.employee_issues" ng-repeat="i in model.employee_issues">
                <td>{{model.employee_issues[$index].name}}</td>
                <td>{{model.employee_issues[$index].problem}}</td>
            </tr>
            </tbody>
        </table>
    </script>
    <script type="text/ng-template" id="weekTmpl.html">
        <table id="tableHeader" class="webcal-table" default>
            <thead>
            <tr>
                <th id="tableHeaderFirst">GMT</th>
                <th ng-click="changeView('day/Sun')" id="Sun">SUN, {{date0}}</th>
                <th ng-click="changeView('day/Mon')" id="Mon">MON, {{date1}}</th>
                <th ng-click="changeView('day/Tues')" id="Tues">TUE, {{date2}}</th>
                <th ng-click="changeView('day/Wed')" id="Wed">WED, {{date3}}</th>
                <th ng-click="changeView('day/Thurs')" id="Thurs">THU, {{date4}}</th>
                <th ng-click="changeView('day/Fri')" id="Fri">FRI, {{date5}}</th>
                <th ng-click="changeView('day/Sat')" id="Sat">SAT, {{date6}}</th>
            </tr>
            </thead>
        </table>
        <div class="dynamic-container">
            <table class="webcal-table" mark-time>
                <tbody>
                <tr>
                    <td>8am</td>
                    <td id="Sun8"></td>
                    <td id="Mon8"></td>
                    <td id="Tues8"></td>
                    <td id="Wed8"></td>
                    <td id="Thurs8"></td>
                    <td id="Fri8"></td>
                    <td id="Sat8"></td>
                </tr>
                <tr>
                    <td>9am</td>
                    <td id="Sun9"></td>
                    <td id="Mon9"></td>
                    <td id="Tues9"></td>
                    <td id="Wed9"></td>
                    <td id="Thurs9"></td>
                    <td id="Fri9"></td>
                    <td id="Sat9"></td>
                </tr>
                <tr>
                    <td>10am</td>
                    <td id="Sun10"></td>
                    <td id="Mon10"></td>
                    <td id="Tues10"></td>
                    <td id="Wed10"></td>
                    <td id="Thurs10"></td>
                    <td id="Fri10"></td>
                    <td id="Sat10"></td>
                </tr>
                <tr>
                    <td>11am</td>
                    <td id="Sun11"></td>
                    <td id="Mon11"></td>
                    <td id="Tues11"></td>
                    <td id="Wed11"></td>
                    <td id="Thurs11"></td>
                    <td id="Fri11"></td>
                    <td id="Sat11"></td>
                </tr>
                <tr>
                    <td>12pm</td>
                    <td id="Sun12"></td>
                    <td id="Mon12"></td>
                    <td id="Tues12"></td>
                    <td id="Wed12"></td>
                    <td id="Thurs12"></td>
                    <td id="Fri12"></td>
                    <td id="Sat12"></td>
                </tr>
                <tr>
                    <td>1pm</td>
                    <td id="Sun13"></td>
                    <td id="Mon13"></td>
                    <td id="Tues13"></td>
                    <td id="Wed13"></td>
                    <td id="Thurs13"></td>
                    <td id="Fri13"></td>
                    <td id="Sat13"></td>
                </tr>
                <tr>
                    <td>2pm</td>
                    <td id="Sun14"></td>
                    <td id="Mon14"></td>
                    <td id="Tues14"></td>
                    <td id="Wed14"></td>
                    <td id="Thurs14"></td>
                    <td id="Fri14"></td>
                    <td id="Sat14"></td>
                </tr>
                <tr>
                    <td>3pm</td>
                    <td id="Sun15"></td>
                    <td id="Mon15"></td>
                    <td id="Tues15"></td>
                    <td id="Wed15"></td>
                    <td id="Thurs15"></td>
                    <td id="Fri15"></td>
                    <td id="Sat15"></td>
                </tr>
                <tr>
                    <td>4pm</td>
                    <td id="Sun16"></td>
                    <td id="Mon16"></td>
                    <td id="Tues16"></td>
                    <td id="Wed16"></td>
                    <td id="Thurs16"></td>
                    <td id="Fri16"></td>
                    <td id="Sat16"></td>
                </tr>
                <tr>
                    <td>5pm</td>
                    <td id="Sun17"></td>
                    <td id="Mon17"></td>
                    <td id="Tues17"></td>
                    <td id="Wed17"></td>
                    <td id="Thurs17"></td>
                    <td id="Fri17"></td>
                    <td id="Sat17"></td>
                </tr>
                <tr>
                    <td>6pm</td>
                    <td id="Sun18"></td>
                    <td id="Mon18"></td>
                    <td id="Tues18"></td>
                    <td id="Wed18"></td>
                    <td id="Thurs18"></td>
                    <td id="Fri18"></td>
                    <td id="Sat18"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </script>
    <script type="text/ng-template" id="dayTmpl.html">
        <div class="webcal-menu-bar">
            <button type="button" class="webcal-button" ng-click="changeView('schedule/' + dayName)">Schedule View</button>
        </div>
        <table id="tableHeader" class="webcal-table-day">
            <thead>
            <tr>
                <th style="width: 100px" ng-click="changeView('schedule/' + dayName)" id="tableHeaderFirst">{{dayName}}</th>
                <th style="width: 100px" id="8">8am</th>
                <th style="width: 100px" id="9">9am</th>
                <th style="width: 100px" id="10">10am</th>
                <th style="width: 100px" id="11">11am</th>
                <th style="width: 100px" id="12">12pm</th>
                <th style="width: 100px" id="1">1pm</th>
                <th style="width: 100px" id="2">2pm</th>
                <th style="width: 100px" id="3">3pm</th>
                <th style="width: 100px" id="4">4pm</th>
                <th style="width: 100px" id="5">5pm</th>
                <th style="width: 100px" id="6">6pm</th>
            </tr>
            </thead>
        </table>
        <div class="dynamic-container">
            <table class="webcal-table-day" day-details>
                <tbody id="dayInsertionPoint">
                </tbody>
            </table>
        </div>
    </script>
    <script type="text/ng-template" id="schedTmpl.html">
        <table id="tableHeader" class="webcal-table-day">
            <thead>
            <tr>
                <th style="width: 100px">{{dayName}}</th>
                <th style="width: 100px" id="8">8am</th>
                <th style="width: 100px" id="9">9am</th>
                <th style="width: 100px" id="10">10am</th>
                <th style="width: 100px" id="11">11am</th>
                <th style="width: 100px" id="12">12pm</th>
                <th style="width: 100px" id="1">1pm</th>
                <th style="width: 100px" id="2">2pm</th>
                <th style="width: 100px" id="3">3pm</th>
                <th style="width: 100px" id="4">4pm</th>
                <th style="width: 100px" id="5">5pm</th>
                <th style="width: 100px" id="6">6pm</th>
            </tr>
            </thead>
        </table>
        <div class="dynamic-container">
            <table class="webcal-table-day" sched-details>
                <tbody id="dayInsertionPoint">
                </tbody>
            </table>
        </div>
    </script>
    <!-- End Templates Section -->
</div>
<!-- Placing the javascript down here allows for quicker load time -->
<script type="text/javascript" src=<? echo $frontend."assets/angular.js" ?>></script>
<script type="text/javascript" src=<? echo $frontend."assets/angular-route.js" ?>></script>
<script type="text/javascript">
    // global variable for included script below
    var pathToPackage_frontend = '<? echo ($frontend) ?>';
    var pathToPackage_backend = '<? echo ($backend) ?>';
</script>
<script type="text/javascript" src=<? echo $frontend."script/controllers.js" ?>></script>
<script type="text/javascript" src=<? echo $frontend."script/script.js" ?>></script>

</body>
</html>

