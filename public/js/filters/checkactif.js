/**
 * Created by Oussama K on 12/09/14.
 */
'use strict';

angular.module('attributeIndic.filters', []).
filter('checkactif', function() {
    return function(input) {
        return input ? '\u2713' : '\u2718';
    };
});