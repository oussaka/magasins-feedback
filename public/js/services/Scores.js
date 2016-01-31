/**
 * Created by Oussamak on 08/10/14.
 * name Oussamak
 * email oussamak@bilog.fr
 */
'use strict';

angular.module('Scores.services', []).
    // TODO : modifier en RESTful
    factory('Scores', ['$resource',
        function($resource){
            return $resource('../score-get/:indicId', { indicId: '@_id' }, {
                query: {method:'GET', params:{}, isArray:false},
                save: {method:'POST', url: '../score-save/:indicId'}
            });
    }]);