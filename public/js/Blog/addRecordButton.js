$(document).ready(function() {

    var editor_active = false;


    $('.circle').click(function(event) {

        if(editor_active) {
            $("html, body").animate({ scrollTop: document.body.scrollHeight }, "slow");
            return;
        }

        $("<article>" +
            "<form>" + //Getting blog name from url
            "<center><b><i>Creating new blog record</i></b></center>" +
            "<input maxlength='180' size='90' type='text' style='padding: 12px 20px; margin: 8px 0; font-weight: bold;' name='title' value='' placeholder='Enter title' required>" +
            "<textarea style='display: none' id = 'create_editor' maxlength='500' name='text' cols='40' rows='3' placeholder='Enter text' required></textarea>" +
            "<br>" +
            "<input type='submit' value='Save'>" +
            "<button type='button' style='margin-left: 10px'>Cancel</button>" +
          "</article>").insertBefore(this);

        CKEDITOR.replace('create_editor');
        CKEDITOR.instances['create_editor'].setData("<h2>Hello!</h2> It's my new blog record!");
        editor_active = true;
        $("html, body").animate({ scrollTop: document.body.scrollHeight }, "slow");


        //If cancel button clicked
        $('form > button[type=button]').click(function (e) {
            CKEDITOR.instances['create_editor'].destroy();
            $(this).parent().parent().remove();
            editor_active = false;
        });

        $('form').submit(function (e) {
            e.preventDefault();
            CKEDITOR.instances['create_editor'].updateElement();

            var title = $(this).children('input[type=text]').val();
            var text = CKEDITOR.instances['create_editor'].getData();

            var errors = [];

            if(title.replaceAll(' ', '').length < 5) {
                errors.push("Too short title. Required at least 5 chars");
            }

            if(title.length > 180) {
                errors.push("Too big title. Max 180 symbols");
            }

            if(jQuery(text).text().replaceAll(' ', '').length < 5) {
                errors.push("Too short record. Required at least 5 chars");
            }

            if(text > 5000) {
                errors.push("Too big record");
            }

            if(errors.length > 0) {
                showMessage('Error', errors, 3);
                return;
            }

            $.ajax({
                type: 'post',
                url: '/blog/add/' + window.location.pathname.split('/')[3],
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
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
                }
            });

        });

    });
});