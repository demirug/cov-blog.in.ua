<?php if($isRegion === true): ?>

        <div class="wraper">

        <?php for($i = 0; $i < count($blogs); $i++): ?>
            <div class="blog-card <?php if($i % 2 === 0) echo "alt"?>">
                <div class="meta">
                    <div class="photo" style="background-image: url('/public/images/blog/defaultImage.jpg')"></div>
                    <ul class="details">
                        <li class="author"><a href="/blogs/<?php echo $blogs[$i]['username']; ?>"><?php echo $blogs[$i]['username']; ?></a></li>
                        <li class="date"><?php echo $blogs[$i]['createDate']; ?></li>
                    </ul>
                </div>
                <div class="description">
                    <h1><?php echo $blogs[$i]['title']; ?></h1>
                    <p><?php echo $blogs[$i]['description']; ?></p>
                    <p class="read-more">
                        <a href="<?php echo "/view/" .  $blogs[$i]['username'] . '/' . str_replace(' ', '-',  $blogs[$i]['title'])?>">Read More</a>
                    </p>
                </div>
            </div>
        <?php  endfor; ?>
        </div>

<?php else:?>

    <div class="wraper">

        <?php for($i = 0; $i < count($blogs); $i++): ?>
            <div class="blog-card <?php if($i % 2 === 0) echo "alt"?>">
                <div class="meta">
                    <div class="photo" style="background-image: url('/public/images/blog/defaultImage.jpg')"></div>
                    <ul class="details">

                        <li class="date"><?php echo $blogs[$i]['createDate']; ?></li>
                    </ul>
                </div>
                <div class="description">
                    <h1><?php echo $blogs[$i]['title']; ?></h1>
                    <p><?php echo $blogs[$i]['description']; ?></p>
                    <p class="read-more">
                        <a href="<?php echo "/view/" .  $userName . '/' . str_replace(' ', '-',  $blogs[$i]['title'])?>">Read More</a>
                    </p>
                </div>
            </div>
        <?php  endfor; ?>
    </div>

<?php endif;?>