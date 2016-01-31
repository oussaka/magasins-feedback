/**
 * Created by Oussamak on 18/09/14.
 * name oussamak@bilog.fr
 */

'use strict';

angular.module('attribUsers.services', []).
factory('UsersByIndic', ['$resource',
    function($resource){
        return $resource('../../users-indic/:indicId', null, {
            // query: {method:'GET', params:{indicId:'indicId'}, isArray:true}
        });
    }]);