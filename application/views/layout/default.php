<!DOCTYPE html>
<html>

<head>

    <title> <?php echo $title; ?> </title>

    <link rel="stylesheet" href="/public/styles/style.css">

    <script type="text/javascript" src="/public/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="/public/js/modalMessage.js"></script>

    <?php foreach($js as $path): ?>
        <script type="text/javascript" src=<?php echo $path; ?>></script>
    <?php endforeach; ?>
</head>

<body>

<!-- The Modal -->
<div class="modal">

    <div class="modal-content">
        <span class="close">×</span>
        <p>Message</p>
    </div>

</div>
<!-- Modal end -->

<h1>Hello world it's default layout</h1>
<hr>
<br>

<?php echo $content; ?>

</body>

</html>