/**
 * Created by Oussamak on 14/10/14.
 * name Oussamak
 * email oussamak@bilog.fr
 */
'use strict';

/* Controllers */
angular.module('scorefileau.controllers', [])
    .controller('scoreFilEau', ['$scope', '$http', '$timeout', 'Scores', function ($scope, $http, $timeout, Scores) {


        $scope.today = function() {
            $scope.dt = new Date();
        };
        // $scope.today();

        $scope.clear = function () {
            $scope.dt = null;
        };

        // Disable weekend selection
        $scope.disabled = function(date, mode) {
            return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
        };

        $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
        };
        // $scope.toggleMin();

        $scope.opened = [];
        $scope.open = function($event, $index) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.opened[$index] = true;
        };

        $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
        };

        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate', 'dd/MM/yyyy'];
        $scope.format = $scope.formats[4];


        $scope.upScore = function ($index, val) {
            $scope.scoresData[$index].valeur = parseInt(val) + 1;
        };

        $scope.downScore = function ($index, val) {
            if(val > 0) {
                $scope.scoresData[$index].valeur = parseInt(val) - 1;
            } else {
                $scope.scoresData[$index].valeur = 0;
            }
        };

        $scope.name = 'Superhero';

        $scope.visible = true;
        // Inititate the promise tracker to track form submissions.
        $scope.scoresData = [];
        $scope.ishidden = [];

        $scope.addRow = function(score) {
            $scope.visible = false;
            $scope.scoresData.push({});
            // TODO : solution lourde!
            var hiddenLength = $scope.ishidden.length;
            $scope.ishidden[ hiddenLength - 1 ] = false;
            $scope.ishidden[ hiddenLength ] = true;
        };

        /*Scores.query({indicId: $scope.indicId})
            .$promise.then(function (res) {
                $scope.scoresData = res.data;
                if(res.data.length === 0) {
                    $scope.scoresData.push({});
                }
            }, function (reason) {
            });*/
        $scope.callData = function () {
            Scores.query({indicId: $scope.indicId}, function(res){
                $scope.scoresData = res.data;
                $scope.ishidden[res.data.length - 1] = true;
                if(res.data.length === 0) {
                    $scope.scoresData.push({});
                    $scope.ishidden[0] = true;
                }
            });
        };
        $scope.callData();

        $scope.submitForm = function (form) {

            // check to make sure the form is completely valid
            if (form.$valid) {

                var xsrf = $.param({id: $scope.indicId, scores: $scope.scoresData});
                var responsePromise = $http.post('../score-save', xsrf, {})
                    .success(function(dataFromServer, status, headers, config) {
                        $scope.messages = 'Vos scores sont enregistrés!';
                    })
                    .error(function(data, status, headers, config) {
                        $scope.messages = 'There was a network error. Try again later.';
                        alert("Submitting form failed!");
                    })
                    .finally(function() {
                        // Hide status messages after three seconds.
                        $timeout(function() {
                            $scope.messages = null;
                        }, 3000);
                    });
            }

        };

    }]);
