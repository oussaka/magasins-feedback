'use strict';

/* Directives */
angular.module('attribUsers.directives', []).
    directive('tableUsers', [ 'UsersByIndic', 'IndicsUsers', '$filter', '$location', function (UsersByIndic, IndicsUsers, $filter, $location) {
        return {
            restrict: 'AE',
            replace: false,
            scope: {
                data: "=",
                indicid: "="
            },
            require: '^tableBox',
            templateUrl: '../../js/partials/tableUsers.html',
            controller: function($scope, $location) {
                // TODO : refactoring code.
//                console.log($location.url());
//                console.log($location.path());
//                console.log($location.absUrl());
//                console.log($location.hash());
//                console.log($location.search());
                /*$scope.filter = function(filtered){
                    console.log("dans click");
                    $scope.UsersIndic = $filter('filter')($scope.UsersIndic,
                                                        function(value, index){

                                                            if(!filtered)
                                                                return true;
                                                            else {
                                                                console.log(value.indic);
                                                                return  index < 10;
                                                            }

                                                        });
                }; */
            },
            link: function(scope, elem, attrs, ctrl) {

/*
                scope.filter = function(filtered){
                    console.log("dans click");
                    $filter('filter')(scope.UsersIndic,
                        function(value, index){

                            if(!filtered)
                                return false;
                            else {
                                console.log(index);
                                return  index < 10;
                            }

                        });
                }
*/
                var indicateurId = scope.indicid;

                var Users = UsersByIndic.query({indicId: indicateurId}, function() {
                    scope.UsersIndic = $filter('orderBy')(Users, 'userCodePk', false);
                    // ctrl.getData(scope.UsersIndic);
                });

                var _indic = new IndicsUsers();
                scope.toggleActif = function(user) {

                    if(user.indic === null || user.indic.id === null|| angular.isUndefined(user.indic.id) ) {

                        user.indic = {};
                        user.indic.actif = true;
                        _indic.indicateur = indicateurId;
                        _indic.user = user.userCodePk;
                        _indic.pui  = user.puiCodePk;
                        _indic.actif = true;
                        _indic.$save();
                    } else {

                        _indic.actif = user.indic.actif = !user.indic.actif;
                        _indic._id = user.indic.id;
                        // _indic.$enable();
                        _indic.$update(function() {
                            //updated in the backend
                            console.log("indic " + _indic._id + " is updated");
                        });
                    }
                }

                elem.bind('click', function() {
                    elem.css('background-color', 'white');
                    scope.$apply(function() {
                        scope.color = "white";
                    });
                });
                /* elem.bind('mouseover', function() {
                    elem.css('cursor', 'pointer');
                }); */
            }
        };
    }]);