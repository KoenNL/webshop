<?php
$pages = array(
    'home' => array(
        'page' => 'home',
        'title' => 'Home',
        'breadcrumbs' => array()
    ),
    'category' => array(
        'page' => 'category',
        'title' => 'Categorie&euml;n',
        'breadcrumbs' => array(
            'category'
        )
    ),
    'product' => array(
        'page' => 'product',
        'title' => 'Noize Top',
        'breadcrumbs' => array(
            'category', 'product'
        )
    ),
    'cart' => array(
        'page' => 'cart',
        'title' => 'Winkelwagen',
        'breadcrumbs' => array(
            'cart'
        )
    ),
    'register' => array(
        'page' => 'register',
        'title' => 'Inloggen/Registreren',
        'breadcrumbs' => array(
            'cart', 'register'
        )
    ),
    'summary' => array(
        'page' => 'summary',
        'title' => 'Overzicht',
        'breadcrumbs' => array(
            'cart', 'register', 'summary'
        )
    ),
    'payment' => array(
        'page' => 'payment',
        'title' => 'Bestelling afgerond',
        'breadcrumbs' => array(
            'cart', 'register', 'summary', 'payment'
        )
    ),
    'orderList' => array(
        'page' => 'orderList',
        'title' => 'Mijn bestellingen',
        'breadcrumbs' => array(
            'orderList'
        )
    ),
    'order' => array(
        'page' => 'order',
        'title' => 'Bestelling',
        'breadcrumbs' => array(
            'orderList', 'order'
        )
    ),
    'user' => array(
        'page' => 'user',
        'title' => 'Mijn gegevens',
        'breadcrumbs' => array(
            'user'
        )
    ),
    'password' => array(
        'page' => 'password',
        'title' => 'Wachtwoord wijzigen',
        'breadcrumbs' => array(
            'password'
        )
    ),
);

// Get the page
$page = empty($_GET['page']) || empty($pages[$_GET['page']]) ? 'home' : $_GET['page'];
$file = $page . '.html';

$pageTitle = $pages[$page]['title'];
$breadcrumbs = array();

foreach ($pages[$page]['breadcrumbs'] as $breadcrumb) {
    $breadcrumbs[] = $pages[$breadcrumb];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Duncan&Brown | <?php echo $pageTitle; ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="functions.js"></script>
</head>
<body>
<header class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12">
        <div class="row">
            <div class="col-md-7" id="logo">
                <a href="?page=home" title="Home"><img src="images/logo.jpeg"></a>
            </div>
            <div class="col-md-3" id="search-box">
                <input type="text" placeholder="Zoeken...">
                <button type="button" class="btn btn-sm btn-primary">Zoeken</button>
            </div>
            <div class="col-md-2" id="cart-indicator">
                <div class="shoppingcart">
                    <a href="?page=cart" title="Winkelwagen">Winkelwagen</a><br>
                    <a href="?page=cart" title="Winkelwagen" class="text-active bold">2 items &euro; 68,95</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-8">
            <p class="text-right">Ingelogd als: <a href="?page=orderList" class="text-active">Arie Schouten</a>
                <a href="/" title="Uitloggen">Uitloggen</a>
            </p>
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
                            <li><a href="?page=category">Jeans</a></li>
                            <li><a href="?page=category">Shirts</a></li>
                            <li><a href="?page=category">Schoenen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Damesmode</a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=category">Rokken</a></li>
                            <li><a href="?page=category">Tops</a></li>
                            <li><a href="?page=category">Schoenen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Tienermode</a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=category">Jeans</a></li>
                            <li><a href="?page=category">Shirts</a></li>
                            <li><a href="?page=category">Schoenen</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-right">
                    <li>
                        <a href="#" title="Nederlands"><img src="images/flag-english.svg" height="20px"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php if ($page !== 'home') : ?>
    <div class="banner banner-<?php echo strtolower($page); ?>">
        <h1><?php echo $pageTitle; ?></h1>
        <p class="breadcrumd">
            <?php for ($i = 0; $i < count($breadcrumbs); $i++) : ?>
                <a href="?page=<?php echo $breadcrumbs[$i]['page']; ?>"><?php echo $breadcrumbs[$i]['title']; ?></a>
                <?php if ($i + 1 < count($breadcrumbs)) : ?>
                    -&gt;
                <?php endif; ?>
            <?php endfor; ?>
        </p>
    </div>
<div class="container" id="wrapper">
    <?php endif; ?>
    <?php
    // Include the page HTML
    if (file_exists($file)) {
        include($file);
    } else {
        include('home.html');
    }
    ?>
    <?php if ($page !== 'home') : ?>
</div>
<?php endif; ?>
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
</body>
</html>