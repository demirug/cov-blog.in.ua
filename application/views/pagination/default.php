<?php if($pageCount > 1): ?>

    <div class="pagination">
    <center>

            <?php

            if($curPage <= 1) {
                echo "<a role='button' class = 'control lock' >Previous</a>";
            } else {
                echo "<a href='$url/" . ($curPage - 1) . "' class = 'control'>Previous</a>";
            }

            ?>

            <?php  for ($i = 1; $i <= $pageCount; $i++): ?>
                <a href="<?php echo $url . '/' . $i; ?>" <?php if($i == $curPage) { echo "class='selected'"; } ?> ><?php echo $i; ?></a>
            <?php  endfor; ?>

            <?php

            if($curPage >= $pageCount) {
                echo "<a role='button' class = 'control lock' >Next</a>";
            } else {
                echo "<a href='$url/" . ($curPage + 1) . "' class = 'control'>Next</a>";
            }

            ?>
    </center>
    </div>

<?php endif; ?>
