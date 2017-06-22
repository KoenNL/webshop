<!DOCTYPE html>
<?php
$user = $controller->getValue('user');
$systemTranslation = $controller->getValue('systemTranslation');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Duncan&Brown | <?php echo ucfirst($pageTitle); ?></title>

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

    <link rel="stylesheet" href="../style.css">
    <script src="../functions.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-12">
            <img width="100%" src="../images/logo.jpeg">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-12 text-center">
            <form>
                <h2>Inloggen</h2>
                <label for="email" class="sr-only"><?php echo ucfirst($systemTranslation->translate('email-address')); ?></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Emailadres" required
                       autofocus>
                <label for="password" class="sr-only"><?php echo ucfirst($systemTranslation->translate('password')); ?></label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Wachtwoord"
                       required>
                <input type="submit" class="btn btn-primary btn-lg btn-block" name="login" value="<?php echo ucfirst($systemTranslation->translate('login')); ?>">
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-12 text-center">
            <p><?php echo ucfirst($systemTranslation->translate('no-account')); ?><a href="../index.php?page=register" title="Registreer"><?php echo ucfirst($systemTranslation->translate('register')); ?></a></p>
        </div>
    </div>
</div>
</body>
</html>