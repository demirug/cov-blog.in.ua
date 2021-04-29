<!DOCTYPE html>
<html>

<head>

    <title> <?php echo $title; ?> </title>

    <link rel="stylesheet" href="/public/styles/Blog/blog.css">

    <script type="text/javascript" src="/public/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="/public/js/modalMessage.js"></script>

    <?php foreach($js as $path): ?>
        <script type="text/javascript" src=<?php echo $path; ?>></script>
    <?php endforeach; ?>
</head>

<body>

<!-- The Modal -->
<div class="modal" id = "modal">
    <div class="modal-content">

        <span class="close">×</span>

        <div class="modal-header">
            <h2>TITLE</h2>
        </div>

        <div class="modal-body">
        </div>

        <div class="modal-footer">
            <button class="but">ok</button>
        </div>

    </div>
</div>
<!-- Modal end -->

<center><h1>Hello world it's blog layout</h1></center>
<hr>
<br>

<?php echo $content; ?>

</body>

</html>