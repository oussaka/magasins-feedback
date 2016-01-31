/**
 * Created by Oussamak on 12/11/14.
 * name Oussamak
 * email oussamak@bilog.fr
 */
'use strict';

angular.module('services.HttpInterceptor', []).
    factory('myHttpInterceptor', function ($q, $window) {
    return function (promise) {
        return promise.then(function (response) {
            $("#spinner").hide();
            return response;
        }, function (response) {
            $("#spinner").hide();
            return $q.reject(response);
        });
    };
});