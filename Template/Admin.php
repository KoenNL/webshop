<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Duncan&Brown | <?php echo ucfirst($template->getTitle()); ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

    <link rel="stylesheet" href="/css/default.css">
    <script src="/js/functions.js"></script>
</head>
<body>
<header class="row">
    <div class="col-sm-12">
        <div class="col-md-3" id="logo">
            <img src="/images/logo.jpeg">
        </div>
        <div class="col-md-3">
            <h4>Beheerdersgedeelte</h4>
        </div>
        <div class="col-md-3 col-md-offset-3">
            <p class="text-right">Ingelogd als: <span class="text-active">Arie Schouten</span>
                <a href="/user/login" title="Uitloggen">Uitloggen</a>
            </p>
        </div>
    </div>
</header>
<div class="row" id="menu">
    <div class="navbar navbar-default">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown <?php echo $page === 'orderList' ? 'active' : ''; ?>">
                    <a href="?page=orderList">Bestellingen</a>
                </li>
                <li class="dropdown <?php echo $page === 'productList' || $page === 'newProduct' || $page === 'importProducts' || $page === 'categoryList' ? 'active' : ''; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Producten <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class=" <?php echo $page === 'productList' ? 'active' : ''; ?>">
                            <a href="?page=productList">Overzicht</a>
                        </li>
                        <li class=" <?php echo $page === 'newProduct' ? 'active' : ''; ?>">
                            <a href="?page=newProduct">Aanmaken</a>
                        </li>
                        <li class=" <?php echo $page === 'importProducts' ? 'active' : ''; ?>">
                            <a href="?page=importProducts">Importeren</a>
                        </li>
                        <li class=" <?php echo $page === 'categoryList' ? 'active' : ''; ?>">
                            <a href="?page=categoryList">Categorie&euml;n</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown <?php echo $page === 'userList' || $page === 'newUser' || $page === 'searchList' || $page === 'searchResults' ? 'active' : ''; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Gebruikers <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class=" <?php echo $page === 'userList' ? 'active' : ''; ?>">
                            <a href="?page=userList">Overzicht</a>
                        </li>
                        <li class=" <?php echo $page === 'newUser' ? 'active' : ''; ?>">
                            <a href="?page=newUser">Aanmaken</a>
                        </li>
                        <li class=" <?php echo $page === 'searchList' ? 'active' : ''; ?>">
                            <a href="?page=searchList">Zoekopdrachten</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown <?php echo $page === 'settings' ? 'active' : ''; ?>">
                    <a href="?page=settings">Instellingen</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="banner">
    <h1><?php echo $template->getTitle(); ?></h1>
    <p class="breadcrumd">
        <?php
        $breadcrumbs = $template->getBreadcrumbs();
        for ($i = 0; $i < count($breadcrumbs); $i++) : ?>
            <a href="?page=<?php echo $breadcrumbs[$i]['page']; ?>"><?php echo $breadcrumbs[$i]['title']; ?></a>
            <?php if ($i + 1 < count($breadcrumbs)) : ?>
                -&gt;
            <?php endif; ?>
        <?php endfor; ?>
    </p>
</div>
<div class="container">
    <?php
    echo $template->getHeader();
    echo $template->getBody();
    echo $template->getFooter();
    ?>
</div>
</body>
</html>