/**
 * Created by Oussamak on 04/11/14.
 * name Oussamak
 * email oussamak@bilog.fr
 */

describe("Service : Scores", function(){
    var mockScoresResource, $httpBackend;

    beforeEach(module("Scores.services"));

    var service;

    beforeEach(function () {
        angular.mock.inject(function ($injector) {
            $httpBackend = $injector.get('$httpBackend');
            mockScoresResource = $injector.get('Scores');
        })
    });

    describe("getData", function(){
        it("should return an array of items", function(){
            // expect(mockScoresResource.getData()).toBeDefined();
            console.log(mockScoresResource);
        });
    });

    /* describe('getUser', function () {
        it('should call getUser with username', inject(function (User) {
            $httpBackend.expectGET('/api/index.php/users/test')
                .respond([{
                    username: 'test'
                }]);

            var result = mockScoresResource.getUser('test');

            $httpBackend.flush();

            expect(result[0].username).toEqual('test');
        }));

    });

    beforeEach(inject(function(Scores){
        service = Scores;
    }));

    describe("getData", function(){
        it("should return an array of items", function(){
            expect(service.getData()).toBeDefined();
        });
    }); */
});
