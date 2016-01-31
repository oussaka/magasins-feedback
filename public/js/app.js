/**
 * Created by Oussama K on 12/09/14.
 */
'use strict';

var appIndic = angular.module('attributeIndic', [
        'ngResource',
        'ngRoute',
        'ngAnimate',
        'attributeIndic.filters',
        'services.IndicsUsers',
        'attributeIndic.controllers'
//         'growlNotifications'
    ]).
    config(['$routeProvider', function($routeProvider) {

    //    $routeProvider.when('/view1', {templateUrl: 'partials/partial1.html', controller: 'MyCtrl1'});
    //    $routeProvider.when('/view2', {templateUrl: 'partials/partial2.html', controller: 'MyCtrl2'});
    //    $routeProvider.otherwise({redirectTo: '/view1'});
    }]).
    run(function($rootScope) {
        $rootScope.indics = {};
    });

var app = angular.module('attribUsers', [
        'ngRoute',
        'ngResource',
//        'attribUsers.filters',
        'attribUsers.services',
        'services.IndicsUsers',
        'attribUsers.directives'
//        'attribUsers.controllers'
    ]).
    config(['$routeProvider', function($routeProvider) {
//        $routeProvider.when('/view1', {templateUrl: 'partials/partial1.html', controller: 'MyCtrl1'});
//        $routeProvider.when('/view2', {templateUrl: 'partials/partial2.html', controller: 'MyCtrl2'});
//        $routeProvider.otherwise({redirectTo: '/view1'});
    }]);


var scoremensuel = angular.module('scoremensuel', [
        'ngResource',
        'scoremensuel.controllers',
        'Scores.services',
        'services.HttpInterceptor',
        'scoremensuel.filters.monthLabel',
        'scoremensuel.filters.sumByKey'
    ])
    .config(function($httpProvider){
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';

        $httpProvider.responseInterceptors.push('myHttpInterceptor');
        var spinnerFunction = function spinnerFunction(data, headersGetter) {
            $("#spinner").show();
            return data;
        };
        $httpProvider.defaults.transformRequest.push(spinnerFunction);
    })
    .run(function ($rootScope) {
        $rootScope.translateVariable = {
            lang: {
                months: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
                    'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
                weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi',
                    'Jeudi', 'Vendredi', 'Samedi'],
                shortMonths: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil',
                    'Aout', 'Sept', 'Oct', 'Nov', 'Déc'],
                downloadPNG: 'Télécharger en image PNG',
                downloadJPEG: 'Télécharger en image JPEG',
                downloadPDF: 'Télécharger en document PDF',
                downloadSVG: 'Télécharger en document Vectoriel',
                exportButtonTitle: 'Export du graphique',
                loading: 'Chargement en cours...',
                printButtonTitle: 'Imprimer le graphique',
                resetZoom: 'Réinitialiser le zoom',
                resetZoomTitle: 'Réinitialiser le zoom au niveau 1:1',
                thousandsSep: ' ',
                decimalPoint: ','
            }
        }; //global variable
    })
    .constant("MyCONST", "Value");

var scorefileau = angular.module('scorefileau', [
        'ngResource',
        'scorefileau.controllers',
        'Scores.services',
        'ngAnimate',
        'ui.bootstrap'
    ])
    .run(function($http) {
        // $http.defaults.headers.common.Authorization = 'login YmVlcDpi' ;
        //or
        // $http.defaults.headers.common['Auth-Token'] = 'login YmVlcDpi';
    })
    .config(function($locationProvider,$httpProvider) {
        // $locationProvider.html5Mode(false);
        // $httpProvider.defaults.useXDomain = true;
        // delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
    });
