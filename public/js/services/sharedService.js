/**
 * Created by Oussama K on 12/09/14.
 */

'use strict';


appIndic.factory('sharedService', function($rootScope) {
        var sharedService = {};
        sharedService.data = {};

        sharedService.prepForBroadcast = function(data) {
            this.data = data;
            this.broadcastItem();
        };

        sharedService.broadcastItem = function() {
            $rootScope.$broadcast('handleBroadcast');
        };

        return sharedService;
    });