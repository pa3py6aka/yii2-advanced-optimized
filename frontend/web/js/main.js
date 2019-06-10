var MyApp = MyApp || {};
MyApp = (function () {
    function listen() {
        $('.modal').on('show.bs.modal', function (event) {
            $('.modal').modal('hide');
        });
    }

    function init() {
        listen();
    }

    return {
        init: init
    };
})();

$(document).ready(function() {
    MyApp.init();
});

