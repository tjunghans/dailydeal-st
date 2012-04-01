// Terrific INTERNET Bootstrap
Tc.Config = Tc.$.extend(Tc.Config, {
    dependencyPath: {
        library: '/javascripts/libraries/dynamic/',
        plugin: '/javascripts/plugins/dynamic/',
        util: '/javascripts/utils/dynamic/'
    }
});

(function($) {
    $(document).ready(function() {
        var $page = $('body');
        var application = new Tc.Application($page);
        application.registerModules();
        application.start();
    });
})(Tc.$);