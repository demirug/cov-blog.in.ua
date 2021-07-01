<!DOCTYPE html>
<html>

<head>

    <title> <?php echo $title; ?> </title>

    <link rel="stylesheet" href="/public/styles/modal.css">
    <link rel="stylesheet" href="/public/styles/navigation.css">
    <?php foreach($css as $path): ?>
        <link rel="stylesheet" href=<?php echo $path; ?>>
    <?php endforeach; ?>

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

<!-- Navigation -->
<div id="header">
    <div class="logo">
        <a href="/" ><img class="d-block mx-auto" src="https://res.cloudinary.com/doytulo2j/image/upload/v1621761692/%D0%BA%D0%BE%D1%80%D0%BE%D0%BD%D0%B0/cov_blog_da1wvc.png" width="230" draggable="false" alt="Logo"></a>
    </div>
    <nav>
        <ul>
            <li class="dropdown">
                <a> Blogs</a>
                <ul>
                    <li><a href="/blogs/vinnytsia">Vinnytsia</a></li>
                    <li><a href="/blogs/dnipro">Dnipro</a></li>
                    <li><a href="/blogs/donetsk">Donetsk</a></li>
                    <li><a href="/blogs/kharkiv">Kharkiv</a></li>
                    <li><a href="/blogs/kiev">Kiev</a></li>
                    <li><a href="/blogs/lutsk">Lutsk</a></li>
                    <li><a href="/blogs/lviv">Lviv</a></li>
                    <li><a href="/blogs/odesa">Odessa</a></li>
                    <li><a href="/blogs/simferopol">Simferopol</a></li>
                </ul>
            </li>
            <?php if(isset($_SESSION['userID'])): ?>
                <li>
                    <a  href="/account/settings"></i>Account</a>
                </li>
                <li>
                    <a  href="/logout"></i>Logout</a>
                </li>
            <?php else: ?>
                <li>
                    <a  href="/login"></i>Sign in</a>
                </li>
                <li>
                    <a  href="/register"></i>Sign up</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<br/>
<!-- Navigation end -->

<?php echo $content; ?>

</body>

</html>