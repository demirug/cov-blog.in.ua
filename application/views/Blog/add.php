<center>

    <div style="margin: 20px 20px 20px 20px; background-color: darkgray">
        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">

            <h5>Add new record to blog <?php echo $blogName; ?></h5>
            <input maxlength="180" size="200" type="text" style="padding: 12px 20px; margin: 8px 0; font-weight: bold;" name="title" placeholder="Enter title" required>
            <br>
            <textarea id = 'editor' maxlength="500" name="text" cols="40" rows="3" placeholder="Enter text" required></textarea>
            <br>
            <input type="submit" style="padding: 12px 20px; margin: 8px 0" name="submit" value="Submit">

        </form>
    </div>

</center>

<script src="/public/js/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
    CKEDITOR.instances['editor'].setData("<h2>Hello!</h2> It's my new blog record!");
</script>