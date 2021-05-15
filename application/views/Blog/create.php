<div id="container">
    <h1> Create new blog</h1>
    <div class="underline">
    </div>
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
        <div class="telephone">
            <label for="name"></label>
            <input maxlength="180" type="text" style="padding: 12px 20px; margin: 8px 0" name="title" regex="[A-Za-zА-Яа-я0-9 ]" minlength="5" placeholder="Enter title" required>
        </div>
        <div class="subject">
            <label for="subject"></label>
            <select name="region" required>
                <option selected disabled value="">Your region</option>
                <?php foreach (application\models\Blog_Model::regionList() as $value):?>
                    <option value="<?php echo $value;?>"><?php echo $value;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="message">
            <label for="message"></label>
            <textarea maxlength="1200" name="description" cols="40" rows="3" placeholder="Enter description" required></textarea>
        </div>
        <div class="submit">
            <div><button type="button" class="btn"><i class="fa fa-image"></i></button></div>
            <div class="right"><button id="form_button">Submit</button></div>
        </div>
    </form><!-- // End form -->
</div><!-- // End #container -->