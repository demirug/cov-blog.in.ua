<div class="wraper">

    <?php if($page == 1): ?>

    <div id="cover" class="" align="center">
        <div class="cover-text">
            <h2><?php echo $title;?></h2>
            <h4><?php echo $description;?></h4>
        </div>
        <img src=<?php echo file_exists("public/images/userdata/blogs/" . $blogid . ".png") ? "/public/images/userdata/blogs/" . $blogid . ".png" : "/public/images/blog/defaultImage.jpg" ?> class="cover-image">
    </div>

    <?php endif; ?>

    <?php if(count($results) === 0): ?>

    <br>
    <center>
        <h1>Temporary posts not founded</h1>
    </center>
    <?php else: ?>

    <?php foreach ($results as $value): ?>

        <article recordID = "<?php echo $value['recordid'] ?>">
            <div id="by">
                <a href="/blogs/<?php echo $userName; ?>">
                    <img src="<?php echo file_exists("public/images/userdata/avatars/" . $userid . ".png") ? ("/public/images/userdata/avatars/" . $userid . ".png?nocache=" . time()) : "/public/images/account/avatar.png" ?>" alt="">
                </a>
                <p><?php echo $value['title'] ?></p>
            </div>
            <div class="content">
                <?php echo $value['text'] ?>
            </div>

            <footer>
                <?php if ($canEdit):?>
                    <button>Edit</button>
                <?php endif; ?>
                <div style="float: right"><?php echo $value['createDate'] ?><div>
            </footer>
        </article>

    <?php endforeach; ?>

    <?php endif; ?>

    <?php if ($canEdit):?>
        <button class="circle">+<span>Add blog record</span></button>
    <?php endif; ?>
</div>