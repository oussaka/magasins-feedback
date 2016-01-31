/**
 * Created by Oussamak on 24/09/14.
 * name oussamak@bilog.fr
 */
'use strict';

/* Controllers */

appIndic.controller('allIndics', ['$scope', function ($scope) {
    $scope.status = true;
    $scope.value1 = true;
    $scope.dofilter = function(){
        $scope.value1 = !$scope.value1;
        $scope.status = $scope.value1;
        // console.log($scope.value1);
    };

}]);

