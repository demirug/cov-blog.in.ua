$(document).ready(function() {

    $('.circle').click(function(event) {
        $.post("/blog/create", {buttonHandle: true}, function (result) {
            try {
                json = jQuery.parseJSON(result);

                if(json.message) {
                    showMessage(json.title, json.message, json.code, json.modalTimer, json.redirect);
                }

                if(json.url) {
                    window.location.href = json.url;
                }

            } catch (e) {
                showMessage('Error', "Error while parsing JSON -> " + e.toString(), 3);
            }
        });
    });
});