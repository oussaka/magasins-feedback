describe('E2E: main page', function() {

    /*
    describe('Authentication capabilities', function() {
        var loginURL;
        var email = element(by.name('loginutilisateur'));
        var password = element(by.name('passwordutilisateur'));
        var loginButton = element(by.xpath('//form[1]/input[@type="submit"]'));
        var error = element(by.model('loginError'));

        it('should redirect to the login page if trying to load protected page while not authenticated', function() {
            browser.get('http://localhost/indicateur/public/utilisateur/utilisateur/login');
            loginURL = browser.getCurrentUrl();

            element(by.name('loginutilisateur')).sendKeys('test');
            browser.driver.sleep(1500);
        });

        it('should warn on missing/malformed credentials', function() {
            email.clear();
            password.clear();

            password.sendKeys('test');
            loginButton.click();
            expect(error.getText()).toMatch('missing email');

            email.sendKeys('test');
            loginButton.click();
            expect(error.getText()).toMatch('invalid email');

            email.sendKeys('@example.com');
            password.clear();
            loginButton.click();
            expect(error.getText()).toMatch('missing password');
        });

        it('should accept a valid email address and password', function() {
            email.clear();
            password.clear();

            email.sendKeys('test@example.com');
            password.sendKeys('test');
            loginButton.click();
            expect(browser.getCurrentUrl()).not.toEqual(loginURL);
        });

        it('should return to the login page after logout', function() {
            var logoutButton = $('a.logout');
            logoutButton.click();
            expect(browser.getCurrentUrl()).toEqual(loginURL);
        });
    }); */

    /*describe('Indicateur : page saisie au fil de l\'eau', function(){
        beforeEach(function() {
            // before function
            // browser.get('http://127.0.0.1:9000/');
        });

        it('should find title element', function() {
            browser.get('app/index.html');
            browser.debugger();
            element(by.binding('user.name'));
        });

        it('should have a title', function() {
            browser.get('http://localhost/indicateur/public/saisie-score/80');
            expect(browser.getTitle()).toContain('Saisie de score');
            expect(browser.getTitle()).toContain('Indicateur');
        });
    });*/

    describe('angularjs homepage todo list', function() {
      it('should add a todo', function() {
        browser.get('http://www.angularjs.org');

        element(by.model('todoText')).sendKeys('write a protractor test');
        element(by.css('[value="add"]')).click();

        var todoList = element.all(by.repeater('todo in todos'));
        expect(todoList.count()).toEqual(3);
        expect(todoList.get(2).getText()).toEqual('write a protractor test');
      });
    });

});