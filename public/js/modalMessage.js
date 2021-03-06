
var redirect = null;
$(document).ready(function () {

    $('.modal').click(function (e) {
        if(e.target.id === 'modal') {
            closeModal();
        }
    });

    $('.modal-content > .close').click(function () {
        closeModal();
    });

    $('.modal-footer > button').click(function () {
       closeModal();
    });

});

function closeModal() {
    $('.modal').css('display', 'none');
    $('.modal-body > p').remove();
    if(redirect != null) {
        window.location.href = redirect;
        redirect = null;
    }
}

/*
* Codes
* 1 - INFO
* 2 - WARN
* 3 - ERROR
*/

function showMessage(title, message, messageCode = 1, closeModalTimerMS = -1, redirectOnClose = null) {

    redirect = redirectOnClose;

    if(closeModalTimerMS !== -1) {
        setTimeout(closeModal, closeModalTimerMS);
    }

    if(Array.isArray(message)) {
        for (let element of message.values()) {
            $('.modal-body').append("<p>" + element + "</p>")
        }
    } else {
        $('.modal-body').append("<p>" + message + "</p>");
    }

    $('.modal-header > h2').text(title);
    $('.modal-header').css('background-color', (messageCode === 1 ? '#01d8ff' : (messageCode === 2 ? '#ffa500' : messageCode === 3 ? '#ff0000' : '#01d8ff')));
    $('.modal').css('display', 'block');
    $('.modal-footer > button').focus();
}