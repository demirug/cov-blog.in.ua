 <?php foreach (application\models\Blog_Model::regionList() as $value):?>
        <button onclick="window.location.href='/blogs/<?php echo $value;?>'"><?php echo ucfirst($value);?></button>
 <?php endforeach;?>