$(document).ready(function() {
    $('form').submit(function(event) {
        var json;
        event.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                try {
                    json = jQuery.parseJSON(result);
                    if (json.url) {
                        window.location.href = json.url;
                    } else {
                        if(json.code && json.message && json.title) {
                            showMessage(json.title, json.message, json.code);
                        }
                    }
                } catch (e) {}
            },
        });
    });
});