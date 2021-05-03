<center>

    <div style="margin: 20px 20px 20px 20px; background-color: darkgray">
        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">

            <h5>Create new blog</h5>
            <input maxlength="180" type="text" style="padding: 12px 20px; margin: 8px 0" name="title" regex="[A-Za-zА-Яа-я0-9 ]" minlength="5" placeholder="Enter title" required>
            <br>
            <textarea maxlength="1200" name="description" cols="40" rows="3" placeholder="Enter description" required></textarea>
            <br>
            Your region
            <select name="region">
                <?php foreach (application\models\Blog_Model::regionList() as $value):?>
                    <option value="<?php echo $value;?>"><?php echo $value;?></option>
                <?php endforeach;?>
            </select>
            <br>
            <input type="submit" style="padding: 12px 20px; margin: 8px 0" name="submit" value="Submit">

        </form>
    </div>

</center>