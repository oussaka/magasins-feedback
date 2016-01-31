/**
 * Created by Oussama K on 12/09/14.
 */
'use strict';

angular.module('services.IndicsUsers', []).
factory('IndicsUsers', ['$resource',
    function($resource){
        return $resource('../../indics-users-restful/:userId', { userId: '@_id' }, {
            // query: {method:'GET', params:{userId:'userid'}, isArray:true},
            // post: {method:'POST'},
            // remove: {method:'DELETE'}
            update: {
                method: 'PUT' // this method issues a PUT request
                // isArray: true
            },
            enable: {
                method: 'PUT',
                // {userId: '@id'},
                params: { actif: true }
            }
        });
    }]);