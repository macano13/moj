//Define App
var app = angular.module('subtitles', []);


app.controller('global',['$scope','ajaxFactory', '$http' ,function( $scope, ajaxFactory, $http ) {
   //definitions
   $scope.config = [];

    //get config
    updateConfig( "./config.json" );
   
    $scope.searchSubmit = function () {
        console.log ( $scope.searchQuery );

        $http.get( "./main.php?query=" + $scope.searchQuery ).then ( function ( result ){
            $scope.results = result.data ;
        });

    }

    $scope.download = function ( file_id, name ) {

        $http.get( "./main.php?file_id=" + file_id + "&name=" + name ).then ( function (result) {
            let { link, localLink, filename } = result.data;
            console.log ( "file downloaded successfully - link: " + link );
            console.log ( "Local Link: " + localLink );

            var a = document.getElementById("download");
            a.href = localLink;
            a.download = filename;
            //a.target = "_blank";
            a.click();
        });
    }
   
     function updateConfig( url ) {
         ajaxFactory.updater( url )
           .then(function(data){ 
             $scope.config = data 
           });
     }

   }]);



//Factories
app.factory('ajaxFactory', function($http) {
    return {
        updater: function(url) {
            return $http.get(url).then(function(result) {
                return result.data;
            });
        }
    }
});