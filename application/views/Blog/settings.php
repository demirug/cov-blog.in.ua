<center>

    <div style="margin: 20px 20px 20px 20px; background-color: darkgray">
        <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">

            <h5>Edit blog <?php echo $blogName; ?></h5>
            Your title:
            <input maxlength="180" type="text" style="padding: 12px 20px; margin: 8px 0" name="title" placeholder="Enter title" value="<?php echo $blogName; ?>" required>
            <br>
            Your Description:
            <br>
            <textarea maxlength="1200" name="description" cols="40" rows="3" placeholder="Enter description" required><?php echo $blogDescription; ?></textarea>
            <br>
            Your region
            <select name="region">
                <?php foreach (application\models\Blog_Model::regionList() as $value):?>
                    <option value="<?php echo $value . "\""; if($value === $blogRegion) {echo " selected";} ?>><?php echo $value;?></option>
                <?php endforeach;?>
            </select>
            <br>
            <input type="submit" style="padding: 12px 20px; margin: 8px 0" name="submit" value="Submit">

        </form>
    </div>

</center>