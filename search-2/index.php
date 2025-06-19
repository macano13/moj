<?php
require_once('../config.php');

include_once("../code/template/header.php");
$user = getUserFromSession();

	if ($user->expire_date == null) {
		echo "<script>window.location.href ='../payment.php';</script>";
	}else{
		$extendExpiredDate = date("Y-m-d", strtotime($user->expire_date ." +10 days") );
		$todayDate = Date('Y-m-d');
		if ($todayDate > $extendExpiredDate) {
			echo "<script>window.location.href ='../payment.php';</script>";
		}
	}

	
	if ($user->is_active == 2 || $user->is_active == 0) {
		echo "<script>window.location.href ='../payment.php';</script>";
	}
?>
<html>
<title>Search Subtitles</title>
<link rel="icon" href="../favicon.png" type="image/ico" sizes="32x32">
    <head>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>

        <!-- libs -->
            <!--Angular -->
                <script type="text/javascript" src="./libs/angularjs/angular.min.js"></script>

            <!--Bootstrap-->
            
            <!--<script src="./libs/bootstrap/v4.1.1/bootstrap.min.js"></script>-->

            <!--Awesome Search Box-->
            <link rel="stylesheet" href="./libs/awesomesearchbox/search.css">
            <link rel="stylesheet" href="./libs/font-awesome/v4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="./libs/css/style.css">
            <!--Subtitles -->
            <script type="text/javascript" src="./libs/subtitles/subtitles-angularjs.js"></script>
       


    </head>

    <body ng-app="subtitles" ng-controller="global" >
     <section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header" style="overflow-x:auto;">

          <div class="d-flex justify-content-center">
            <div class="searchbar">
              <input ng-model="searchQuery" class="search_input" type="text" name="" placeholder="Search...">
              <a href="" class="search_icon nounderline" ng-click="searchSubmit()"><i class="fa fa-search"></i></a>
            </div>
        </div>
       
        <table class="table table-hover">
            <tr>
                <th>Name</th>
                <th>Language</th>
                <th class="down">Download</th>
            </tr>
            <tr ng-repeat="subtitles in results.data">
                <td>{{subtitles.attributes.feature_details.movie_name}}</td>
                <td>{{subtitles.attributes.language}}</td>
                <td>
                    <ul>
                        <li ng-repeat="file in subtitles.attributes.files">
                            <a href="" ng-click="download( file.file_id, file.file_name )">{{file.file_name}}</a>
                            <a id="download" download="{{file.file_name}}"></a>
                        </li>
                    </ul>
                </td>
            </tr>
        </table>
        		</div>
		</div>
     </div>
	</div>
</section>
    </body>
</html>
<?php
include_once("../code/template/footer.php");
?>
