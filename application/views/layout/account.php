<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen and (color)" href="/public/styles/account.css">

    <title> <?php echo $title; ?> </title>

    <link rel="stylesheet" href="/public/styles/account.css">

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

<?php echo $content; ?>

</body>
</html>

