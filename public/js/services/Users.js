/**
 * Created by Oussama K on 12/09/14.
 */

'use strict';

app.factory('Users', ['$resource',
        function($resource){
            return $resource('../users-rest/:userId', {}, {
                query: {method:'GET', params:{userId:null}, isArray:true}
            });
    }]);
