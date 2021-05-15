$(document).ready(function() {



    $('article > footer > button').click(function(event) {

        var article = $(this).parent().parent();
        var recordID = article.attr('recordid');

        article.children().hide();

        article.append(
            "<form action='/blogs/edit' method='post'>" +
            "<center><b><i>Editing of blog record</i></b></center>" +
            "<input maxlength=\"180\" size=\"90\" type=\"text\" style=\"padding: 12px 20px; margin: 8px 0; font-weight: bold;\" name=\"title\" value=\"" + article.children("#by").children("p").text() +  "\" placeholder=\"Enter title\" required>" +
            "<textarea style=\"display: none\" id = 'editor_" +  recordID + "' maxlength=\"500\" name=\"text\" cols=\"40\" rows=\"3\" placeholder=\"Enter text\" required></textarea>" +
            "<input type='submit' value='Save'>" +
            "</form>");

        article.children('form').submit(function (event) {
            event.preventDefault();

            var title = article.children("form").children("input[type=text]").val();
            var data = CKEDITOR.instances['editor_' + recordID].getData();

            var errors = [];

            if(title.replaceAll(' ', '').length < 5) {
                errors.push("Too short title. Required at least 5 chars")
            }

            if(title.length > 180) {
                errors.push("Too big title. Max 180 symbols")
            }

            if(jQuery(data).text().replaceAll(' ', '').length < 5) {
                errors.push("Too short record. Required at least 5 symbols")
            }

            if(data > 5000) {
                errors.push("Too big record");
            }

            if(errors.length > 0) {
                showMessage('Error', errors, 3);
            } else {

                CKEDITOR.instances['editor_' + recordID].updateElement();

                var success = false;
                $.ajax({
                    type: 'post',
                    url: '/blog/edit/' +recordID,
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

                            if(json.status && json.status == "OK") {
                                article.children('.content').html(data);
                                article.children('#by').children('p').text(title);

                                CKEDITOR.instances['editor_' + recordID].destroy();
                                article.children("form").remove();

                                article.children().show();
                            }

                        } catch (e) {
                            showMessage('Error', "Error while parsing JSON -> " + e.toString(), 3);
                        }
                    }
                });
            }
        });

        CKEDITOR.replace('editor_' + recordID);
        CKEDITOR.instances['editor_' + recordID].setData(article.children('.content').html());
    });
});