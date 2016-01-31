/**
 * Created by Oussama K on 12/09/14.
 */
'use strict';

angular.module('attributeIndic.controllers', []).
controller('listIndic', [
            '$scope',
            '$rootScope',
            '$location',
            '$log',
            '$filter',
            'filterChapitre',
            'sharedService',
            'IndicsUsers',
    function(   $scope,
                $rootScope,
                $location,
                $log,
                $filter,
                filterChapitre,
                sharedService,
                IndicsUsers) {

        $scope.chapitres = [];
        $scope.indics    = [];
        $scope.message    = sharedService;

        function getIndicateur(userId) {
            $scope.myData = {};
            // var responsePromise = $http.get("../indics-users-restful/"+userId);
            // var responsePromise = IndicsUsers.get({userId:1});
            $scope.indicsArr = IndicsUsers.get({userId:userId}, function(result) {
                // $log.debug(result.data);
                sharedService.prepForBroadcast(result.data);
                $scope.$emit('listIndLoaded', {});
            });
        }
        getIndicateur($scope.userId);

        $scope.$on('handleBroadcast', function() {
            if( $scope.chapitres.length == 0 ) {
                $scope.chapitres = $filter('orderBy')(filterChapitre.getChapFilter(sharedService.data), 'id', false);
            }
            $scope.indics = sharedService.data;
            $rootScope.indics = sharedService.data;
            // console.log(sharedService.data);
        });

        $scope.chapSelected = function(chap) {
        }

        $scope.$on('listIndLoaded', function(event, args) {
            // console.log("func called");
        });

        $scope.customFilter = function( criteria ) {
            return function( item ) {
                return item.indicateur.chapitre.code === $scope.chapitre;
            };
        };

        var _indic = new IndicsUsers();
        $scope.toggleActif = function(indic, nindex) {

            if(angular.isUndefined(indic.id) || indic.id === null ) {

                _indic.indicateur = indic.indicateur.id;
                _indic.user = $scope.userId;
                indic.actif = _indic.actif = true;
                _indic.$save();
            } else {

                indic.actif = _indic.actif = !indic.actif;
                _indic._id = indic.id;
                // _indic.$enable();
                _indic.$update(function() {
                    //updated in the backend
                    console.log("indic " + indic.id + " is updated");
                });
            }

        }

}]);

