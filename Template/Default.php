<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Duncan&Brown | <?php echo $template->getTitle(); ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="/css/default.css">
    <script src="/js/functions.js"></script>
    <?php echo $template->getMeta(); ?>
    <style>
        <?php echo $template->getCSS(); ?>
    </style>
</head>
<body>
<?php
// This needs to replace the menu!
echo $template->getHeader();
?>
<header class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12">
        <div class="row">
            <div class="col-md-7" id="logo">
                <a href="/" title="Home"><img src="/images/logo.jpeg"></a>
            </div>
            <div class="col-md-3" id="search-box">
                <form action="/search/search" method="Post">
                <input type="text" name="search" placeholder="Zoeken...">
                <button type="submit" class="btn btn-sm btn-primary">Zoeken</button>
                </form>
            </div>
            <div class="col-md-2" id="cart-indicator">
                <div class="shoppingcart">
                    <a href="/order/cart" title="Winkelwagen">Winkelwagen</a><br>
                    <?php if (!empty($_SESSION['order']) && count($_SESSION['order']->getOrderLines()) > 0) : ?>
                        <a href="/order/cart" title="Winkelwagen" class="text-active bold">
                            <?php echo count($_SESSION['order']->getOrderLines()); ?> item<?php
                            echo (count($_SESSION['order']->getOrderLines()) > 2) ? 's' : '';
                            ?> &euro;
                            <?php echo number_format($_SESSION['order']->getPrice(), 2, ',', '.'); ?>
                        </a>
                    <?php else : ?>
                        <i>0 items</i>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-8">
            <?php if (!empty($_SESSION['user'])) : ?>
                <p class="text-right">Ingelogd als: <a href="/adminorder/orderlist"
                                                       class="text-active"><?php echo $_SESSION['user']->getName(); ?></a>
                    <a href="/user/logoff" title="Uitloggen">Uitloggen</a>
                </p>
            <?php else : ?>
                <p class="text-center"><a href="#" data-toggle="modal" data-target="#login-modal" class="text-active">Inloggen</a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</header>
<div class="container">
    <div class="row" id="menu">
        <div class="navbar navbar-default">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Herenmode</a>
                        <ul class="dropdown-menu">
                            <li><a href="/category/productlist/4">Jeans</a></li>
                            <li><a href="/category/productlist/5">Shirts</a></li>
                            <li><a href="/category/productlist/6">Schoenen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Damesmode</a>
                        <ul class="dropdown-menu">
                            <li><a href="/category/productlist/7">Rokken</a></li>
                            <li><a href="/category/productlist/8">Tops</a></li>
                            <li><a href="/category/productlist/9">Schoenen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Tienermode</a>
                        <ul class="dropdown-menu">
                            <li><a href="/category/productlist/10">Jeans</a></li>
                            <li><a href="/category/productlist/11">Shirts</a></li>
                            <li><a href="/category/productlist/12">Schoenen</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-right">
                    <li>
                        <?php if ($_SESSION['language'] === 'nl') : ?>
                            <a href="/page/changelanguage/en" title="English"><img src="/images/flag-english.svg" height="20px"></a>
                        <?php elseif ($_SESSION['language'] === 'en') : ?>
                            <a href="/page/changelanguage/nl" title="Nederlands"><img src="/images/flag-dutch.svg" height="20px"></a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php if ($template->getTitle() === 'Home') : ?>
    <div class="home-banner"></div>
    <div class="container" id="wrapper">
        <?php echo $template->getBody(); ?>
    </div>
<?php else: ?>
    <div class="banner">
        <h1><?php echo $template->getTitle(); ?></h1>
        <p class="breadcrumd">
            <?php
            $breadcrumbs = $template->getBreadcrumbs();
            for ($i = 0; $i < count($breadcrumbs); $i++) : ?>
                <a href="<?php echo (strpos($breadcrumbs[$i]['path'], 'http') !== false) ? $breadcrumbs[$i]['path'] : '/' . $breadcrumbs[$i]['path']; ?>">
                    <?php echo $breadcrumbs[$i]['title']; ?>
                </a>
                <?php if ($i + 1 < count($breadcrumbs)) : ?>
                    -&gt;
                <?php endif; ?>
            <?php endfor; ?>
        </p>
    </div>
    <div class="container" id="wrapper">
        <?php echo $template->getBody(); ?>
    </div>
<?php endif; ?>
<?php
// This needs to replace the footer.
echo $template->getFooter();
?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12 text-center">
                <p>Duncan&amp;Brown&copy; 2017</p>
            </div>
            <div class="col-md-4 col-sm-12 text-center">
                <p>Ontwikkeld door <a href="#" title="CompuSoft">CompuSoft</a></p>
            </div>
            <div class="col-md-4 col-sm-12 text-center">
                <p>
                    <a href="#">Contact</a> | <a href="#">Algemene voorwaarden</a> | <a href="#">Privacy beleid</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="login-modal-label">Inloggen</h4>
            </div>
            <form action="/user/login" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="login-email-address">Emailadres</label>
                        <input type="email" class="form-control" name="login-email-address" id="login-email-address"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Wachtwoord</label>
                        <input type="password" class="form-control" id="login-password" name="login-password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <a href="/user/user" class="btn btn-default">Registreren</a>
                        <input type="submit" class="btn btn-primary" name="login" value="Inloggen">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $template->getJavascript(); ?>
</body>
</html>
