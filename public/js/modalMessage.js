$(document).ready(function (func) {

    $('.modal-content > .close').click(function () {
        $('.modal').css('display', 'none');
    });

});

function showMessage(message) {
    $('.modal-content > p').text(message);
    $('.modal').css('display', 'block');
}