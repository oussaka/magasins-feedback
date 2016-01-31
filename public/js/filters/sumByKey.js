/**
 * Created by Oussamak on 08/10/14.
 * name oussamak@bilog.fr
 */
'use strict';

angular.module('scoremensuel.filters.sumByKey', []).
    filter('sumByKey', function () {
        return function (data, key) {
            if (typeof (data) === 'undefined' || typeof (key) === 'undefined') {
                return 0;
            }
            var sum = 0;
            angular.forEach(data, function (val) {
                if (val[key] != null) {
                    sum += parseInt(val[key]);
                }
            });
            /*for (var i = data.length - 1; i >= 0; i--) {
             sum += parseInt(data[i][key]);
             }*/

            return sum;
        };
    });
