/**
 * Created by Oussama K on 12/09/14.
 */

'use strict';

/* Controllers */

angular.module('myApp.controllers', []).
controller('userstable', ['$scope', '$log', 'Users', 'IndicsUsers', 'sharedService', '$http',
    function ($scope, $log, Users, IndicsUsers, sharedService, $http) {

        $scope.users = Users.query();

        $scope.userselect = function() {
            $scope.userselected = this.user;
            console.log($scope.userselected);

            if(this.user.id != "") {
                getIndicateur(this.user.id);
            }
        }

}]);