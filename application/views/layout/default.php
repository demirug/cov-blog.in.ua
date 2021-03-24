<!DOCTYPE html>
<html>

<head>

    <title> <?php echo $title; ?> </title>

    <?php foreach($js as $path): ?>
        <script type="text/javascript" src=<?php echo $path; ?>></script>
    <?php endforeach; ?>
</head>

<body>
<h1>Hello world it's default layout</h1>
<hr>
<br>

<?php echo $content; ?>

</body>

</html>