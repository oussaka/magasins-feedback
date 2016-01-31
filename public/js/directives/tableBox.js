/**
 * Created by Oussamak on 22/09/14.
 * name oussamak@bilog.fr
 */
'use strict';
// see  http://jsfiddle.net/evaneus/z9rge/
// see  http://jsfiddle.net/askbjoernhansen/YjMMD/
/* Directives */
app.directive('tableBox', [ '$filter', function ($filter) {
        return {
            restrict: 'AE',
            transclude: true,
            replace: false,
            scope: true,
            templateUrl: '../../js/partials/tableBox.html',
            controller: function($scope) {

                // console.log("parent mydata : ", $scope);

                /* $scope.$observe('data', function() {
                    console.log("observe contoller");
                }); */

                $scope.filtertab = function() {
                    console.log($scope.data);
                }
                $scope.erasedata = function() {
                    $scope.data = null;
                    $scope.UsersIndic = null;
                    // $scope.$apply();
                }
                this.getData = function(data) {
                    $scope.data = data;
                }
                /*var panes = $scope.panes = [];

                $scope.select = function(pane) {
                    angular.forEach(panes, function(pane) {
                        pane.selected = false;
                    });
                    pane.selected = true;
                };

                this.addPane = function(pane) {
                    if (panes.length === 0) {
                        $scope.select(pane);
                    }
                    panes.push(pane);
                };*/
            },
            link: function(scope, elem, attrs) {
                scope.$watch('data', function() {
//                    console.log("observe link");
                });
            }
        };
    }]);