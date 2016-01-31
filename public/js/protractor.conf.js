exports.config = {
  seleniumAddress: 'http://localhost:4444/wd/hub',
  specs: ['test/e2e/**/*-spec.js'],
    jasmineNodeOpts: {
        showColors: true,
        defaultTimeoutInterval: 30000
    }
    /**
     * This should point to your running app instance, for relative path resolution in tests.
     */
    // baseUrl: 'http://localhost:9000'
};