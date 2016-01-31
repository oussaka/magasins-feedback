'use strict';

/* http://docs.angularjs.org/guide/dev_guide.e2e-testing */

describe('Application Indicateur E2E', function() {

    describe('module : saisie score au fil de l\'eau', function() {

        beforeEach(function() {
            browser().navigateTo('../../../saisie-score/80');
        });

        it('seulement trois boutons "add" sont sur la page', function() {
            expect(element('div.btn-toolbar').count()).toBe(3);
        });

        it('submit button doit avoir le text "enregister"', function(){
            expect(element('input[type="submit"]').text()).toBe("Enregistrer");
            expect(element('input[type="submit"]').text()).toMatch("Enregistrer");
        });

    });


    /*
     it('should jump to the /videos path when / is accessed', function() {
     browser().navigateTo('#/');
     expect(browser().location().path()).toBe("/videos");
     });
     it('should have a working /videos route', function() {
     browser().navigateTo('#/videos');
     expect(browser().location().path()).toBe("/videos");
     });
    */
  /*beforeEach(function() {
    browser().navigateTo('../../app/index.html');
  });


  it('should automatically redirect to /view1 when location hash/fragment is empty', function() {
    expect(browser().location().url()).toBe("/view1");
  });


  describe('view1', function() {

    beforeEach(function() {
      browser().navigateTo('#/view1');
    });


    it('should render view1 when user navigates to /view1', function() {
      expect(element('[ng-view] p:first').text()).
        toMatch(/partial for view 1/);
    });

  });


  describe('view2', function() {

    beforeEach(function() {
      browser().navigateTo('#/view2');
    });


    it('should render view2 when user navigates to /view2', function() {
      expect(element('[ng-view] p:first').text()).
        toMatch(/partial for view 2/);
    });

  });*/
});
