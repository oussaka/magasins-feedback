describe("Indicateur: Testing Modules", function() {
    describe("scorefileau Module:", function() {

        var module;
        beforeEach(function() {
            module = angular.module("scorefileau");
        });

        it("should be registered", function() {
            var a= null;
            var foo = "foo";

            expect(null).toBeNull();
            expect(a).toBeNull();
            expect(foo).not.toBeNull();
            expect(module).not.toBeNull();
        });

        describe("Dependencies:", function() {

            var deps;
            var hasModule = function(m) {
                return deps.indexOf(m) >= 0;
            };
            beforeEach(function() {
                deps = module.value('appName').requires;
            });

            //you can also test the module's dependencies
            it("should have ng-resource as a dependency", function() {
                expect(hasModule('ngResource')).toBeTruthy(true);
            });

            it("should have scorefileau.controllers as a dependency", function() {
                expect(hasModule('scorefileau.controllers')).toBeTruthy();
            });

            it("should have Scores.services as a dependency", function() {
                expect(hasModule('Scores.services')).toBe(true);
            });

            it("should have ngAnimate as a dependency", function() {
                expect(hasModule('ngAnimate')).toBe(true);
            });

            it("should have ui.bootstrap as a dependency", function() {
                expect(hasModule('ui.bootstrap')).toBeTruthy();
            });
        });
    });
});