
$(document).ready(function () {

    $("input").keypress(function (e) {

        var attr = $(this).attr('regex');

        if(attr === undefined || attr === false) return;

        var key = String.fromCharCode(e.which);
        var regEx = new RegExp(attr);

        if(!regEx.test(key)) e.preventDefault();

    });

});