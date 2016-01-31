/**
 * Created by Oussamak on 08/10/14.
 * name oussamak@bilog.fr
 */
'use strict';

/* Controllers */
angular.module('scoremensuel.controllers', [])
    .controller('scoreMensuel', ['$scope', '$http', 'Scores', function ($scope, $http, Scores) {

    var date = new Date();
    $scope.actualYear = date.getFullYear();
    $scope.currentYear = date.getFullYear();

    $scope.nextPage = function(evt) {
        if (!angular.element(evt.target).parent().hasClass("disabled")) {
            $scope.currentYear = $scope.currentYear + 1;
        }
        // event.preventDefault();
        // event.stopPropagation();
    };
    $scope.prevPage = function(){
        if( $scope.currentYear !== $scope.actualYear - 4) {
            $scope.currentYear = $scope.currentYear -1;
        }
    };

    $scope.submitForm = function(form) {
        // TODO :  pourquoi avec $resource ça foire pour poster des donnees en POST
        // check to make sure the form is completely valid
        if (form.$valid) {

            $scope.process = true;
            var xsrf = $.param({id: $scope.indicId, scores: $scope.dataScores});
            $http({
                method: 'POST',
                url: '../score-save',
                data: xsrf
                // headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (res) {
                $scope.process = false;
            });
            //var scores = new Scores;
            //                    scores.data = $scope.dataScores;
            //                    scores.$post();
            // scores.$save();
            /*null, function(res){
             console.log(res);
             });*/
        }
    };
}]);