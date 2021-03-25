$(document).ready(function () {

    $('.modal').click(function (e) {
        if(e.target.id === 'modal') {
            $(this).css('display', 'none');
            $('.modal-body > p').remove();
        }
    });

    $('.modal-content > .close').click(function () {
        $('.modal').css('display', 'none');
        $('.modal-body > p').remove();
    });

    $('.modal-footer > button').click(function () {
        $('.modal').css('display', 'none');
        $('.modal-body > p').remove();
    });

});

/*
* Codes
* 1 - INFO
* 2 - WARN
* 3 - ERROR
*/
function showMessage(title, message, messageCode = 1) {

    if(Array.isArray(message)) {
        for (let element of message.values()) {
            $('.modal-body').append("<p>" + element + "</p>")
        }
    } else {
        $('.modal-body').append("<p>" + message + "</p>");
    }

    $('.modal-header > h2').text(title);
    $('.modal-header').css('background-color', (messageCode === 1 ? '#01d8ff' : (messageCode === 2 ? '#ffa500' : messageCode === 3 ? '#FF0000' : '#01d8ff')));
    $('.modal').css('display', 'block');
}