'use strict';

/* jasmine specs for filters go here */

describe('tester avec Karma', function() {

  // beforeEach(module('myApp.filters'));

  it('True, should be equal to True Or 1', function(){
    expect(true).toBe(true);
    // expect(true).toBe(1);
  });

  /*describe('interpolate', function() {
    beforeEach(module(function($provide) {
      $provide.value('version', 'TEST_VER');
    }));


    it('should replace VERSION', inject(function(interpolateFilter) {
      expect(interpolateFilter('before %VERSION% after')).toEqual('before TEST_VER after');
    }));
  });*/
});
