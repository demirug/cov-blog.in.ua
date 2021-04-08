<center>
    <?php if($pageCount != 0): ?>

        <?php if($curPage != 1): ?>
            <a href="<?php echo $url . '/' . ($curPage - 1); ?>" class = "control" >Previous</a>
        <?php endif; ?>

        <?php  for ($i = 1; $i <= $pageCount; $i++): ?>
            <a href="<?php echo $url . '/' . $i; ?>" <?php if($i == $curPage) { echo "style='selected'"; } ?> ><?php echo $i; ?></a>
        <?php  endfor; ?>

        <?php if($curPage != $pageCount): ?>
            <a href="<?php echo $url . '/' . ($curPage + 1); ?>" class = "control" >Next</a>
        <?php endif; ?>

    <?php endif; ?>
</center>