<div id="container">
    <h1> Profile settings</h1>
    <div class="underline">
    </div>

    <form action="/account/settings" method="post" id="contact_form">
        <input id="file-input" type="file", name="file-input" accept=".png, .jpg, .jpeg" style="display: none">
        <div align="center">
            <button type="button" id ="file-input-btn" class="rollover" align="center"></button>
        </div>

        <div class="password">
            <label for="name"></label>
            <input type="password" placeholder="Enter old password" name="old_password">
        </div>

        <div class="password">
            <label for="name"></label>
            <input type="password" placeholder="Enter new password" name="new_password">
        </div>

        <div class="password">
            <label for="name"></label>
            <input type="password" placeholder="Repeat new password" name="new_password_repeat">
        </div>

        <div class="submit">
            <div align="center"><button id="form_button">Save</button></div>
        </div> 
    </form><!-- // End form -->
</div>

<script>

    $('#file-input-btn').click(function () {
        $('#file-input').trigger('click').change(function () {
            var extension = this.files[0].name.split('.').pop().toLowerCase();
            if(extension != 'png' && extension != 'jpg') {
                showMessage("Warning", "Allowed formats only png and jpg", 3);
                this.type = "text";
                this.type = "file";

                <?php if(file_exists("public/images/userdata/avatars/" . $userID . ".png")):?>
                    document.documentElement.style.setProperty('--avatar', 'url("/public/images/userdata/avatars/<?php echo $userID . ".png?nocache=" . time(); ?>")');
                <?php else: ?>
                    document.documentElement.style.setProperty('--avatar', "url('/public/images/account/avatar.png')");
                <?php endif; ?>
                return;
            }

            if(this.files[0].size > 2097152) {
                showMessage("Warning", "Image size cant be bigger than 2mb", 3);
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {

                document.documentElement.style.setProperty('--avatar', "url('" + e.target.result  +  "')");
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

    <?php if(file_exists("public/images/userdata/avatars/" . $userID . ".png")):?>
        document.documentElement.style.setProperty('--avatar', 'url("/public/images/userdata/avatars/<?php echo $userID . ".png?nocache=" . time(); ?>")');
    <?php endif; ?>
</script>