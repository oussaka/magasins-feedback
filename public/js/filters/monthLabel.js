/**
 * Created by Oussamak on 08/10/14.
 * name Oussamak
 * email oussamak@bilog.fr
 */
'use strict';

angular.module('scoremensuel.filters.monthLabel', []).
   filter('monthLabel', function ($filter, $rootScope) {
        // TODO : performance : il boucle sur les mois deux fois !!! voir console.log
        return function (num) {
            return $rootScope.translateVariable.lang.months[num-1];
            // return $filter('date')(new Date(2014, num-1), 'MMMM');
        };
   });