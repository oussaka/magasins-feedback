'use strict';

/* jasmine specs for controllers go here */

describe('Controller: scoreFilEau', function() {
    var scope, controller, $httpBackend, scoreService, $location, timeout;
    var $rootScope, $scope, $controller;

    beforeEach(module('scorefileau.controllers'));

    beforeEach(function() {
        var mockScoreService = {};
        var mockScoreService = {
            notes: {data: ['note1', 'note2']}, //just two elements initially
            query: function() {
                return this.notes;
            },
            put: function(content) {
                this.notes.push(content);
            }
        };
        module('Scores.services', function($provide) {
            $provide.value('scoreService', mockScoreService);
        });

        /*inject(function($q) {
            mockScoreService.data = [
                {
                    id: 0,
                    name: 'Angular'
                },
                {
                    id: 1,
                    name: 'Ember'
                },
                {
                    id: 2,
                    name: 'Backbone'
                },
                {
                    id: 3,
                    name: 'React'
                }
            ];

            mockScoreService.query = function() {
                var defer = $q.defer();

                defer.resolve(this.data);

                return defer.promise;
            };

            mockScoreService.save = function(name) {
                var defer = $q.defer();

                var id = this.data.length;

                var item = {
                    id: id,
                    name: name
                };

                this.data.push(item);
                defer.resolve(item);

                return defer.promise;
            };
        });*/
    });

    beforeEach(inject(function($controller, $rootScope, _$httpBackend_, _scoreService_) {
        scope = $rootScope.$new();
        $httpBackend = _$httpBackend_;
        timeout = {};
        scoreService = _scoreService_;

        controller = $controller('scoreFilEau', {
            '$scope': scope,
            '$http': $httpBackend,
            '$timeout': timeout,
            'Scores': scoreService
        });

        scope.$digest();
    }));

    /*it('should assign data to scope', function () {
        spyOn(scoreService, 'query').andCallThrough();
        deferred.resolve([{},{},{}]);
        scope.$digest();
        expect(scoreService.query).toHaveBeenCalled();
        expect(scope.data).toBe(data);
    });*/



    /* it('should 1 equal only 1', inject(function() {
        expect(true).toEqual(true);
        // expect(scope).isDefined;
    })); */

       /* it('sets the name', function () {
//            expect(scope.name).toBe('Superhero');
            expect(1).toEqual(1);
        });*/

        /*it('watches the name and updates the counter', function () {
            expect(scope.counter).toBe(0);
            scope.name = 'Batman';
            scope.$digest();
            expect(scope.counter).toBe(1);
        });*/


    /* it('should contain all scores user at startup', function() {

        scoreService.query();
        console.log(scoreService);
        console.log(scope.scoresData);
        expect(scope.scoresData).toEqual([
            {
                id: 0,
                name: 'Angular'
            },
            {
                id: 1,
                name: 'Ember'
            },
            {
                id: 2,
                name: 'Backbone'
            },
            {
                id: 3,
                name: 'React'
            }
        ]);
    });

    it('should create new libraries and append it to the list', function() {
        // We simulate we entered a new library name
        scope.newItemName = "Durandal";

        // And that we clicked a button or something
        scope.create();

        var lastLibrary = scope.libraries[scope.libraries.length - 1];

        expect(lastLibrary).toEqual({
            id: 4,
            name: 'Durandal'
        });
    });

    it('should redirect us to a library details page', function() {
        spyOn($location, 'path');

        var aLibrary = scope.libraries[0];

        // We simulate we clicked a library on the page
        scope.goToDetails(aLibrary);

        expect($location.path).toHaveBeenCalledWith('/libraries/0/details');
    }); */

    it('name should be "superhero" at startUp', function(){
        expect(scope.name).toBe('Superhero');
    });

});
