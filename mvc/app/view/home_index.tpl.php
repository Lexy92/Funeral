<?php @include APP_PATH . 'view/snippets/header.tpl.php'; ?>

<h2>

    <?php
    if (!isset($_SESSION['loggedin'])) { ?>
        Welcome!
        </br>
        <a href = "<?php echo APP_URL; ?>login/login"><font size="5">Log in </a>
    <?php
    }
    else {
    ?>  Welcome, <?php echo $_SESSION['user_name']; ?> !
        </br>
        <a href = "<?php echo APP_URL; ?>login/logout"><font size="5">Log Out</a>
        <a href = "<?php echo APP_URL; ?>order/myOrders"><font size="3">My orders |</a>
    <?php } ?>
    <?php if ($_SESSION['user_type'] == 1) { ?>
        <a href = "<?php echo APP_URL;?>admin/index"><font size="3">| Admin page |</a>
    <?php } ?>
    <a href = "<?php echo APP_URL; ?>product/searchProduct"><font size="3">Search a product |</a>
    <a href = "<?php echo APP_URL; ?>product/searchProduct2"><font size="3">Search a product2 |</a>
    <a href = "<?php echo APP_URL; ?>cart/view/"><font size="3"> View shooping cart </a>
</h2>
<p><a href = "<?php echo APP_URL; ?>category/list"> Categories list </a></p>
<p><a href = "<?php echo APP_URL; ?>about/view/"> About us </a></p>
<p><a href = "<?php echo APP_URL; ?>contact/view/"> Contact </a></p>

    <!--Facebook section!-->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="fb-like-box" data-href="http://www.facebook.com/FreshDeadInc" data-width="292" data-show-faces="true" data-stream="false" data-show-border="true" data-header="true"></div>
    <!--End Facebook section!-->

<?php @include APP_PATH . 'view/snippets/footer.tpl.php'; ?>