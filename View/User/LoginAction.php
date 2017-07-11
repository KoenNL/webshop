<?php
$systemTranslation = $controller->getValue('systemTranslation');
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-12">
        <img width="100%" src="/images/logo.jpeg">
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-12 text-center">
        <form>
            <h2><?php echo ucfirst($systemTranslation->translate('login')); ?></h2>
            <label for="email" class="sr-only"><?php echo ucfirst($systemTranslation->translate('email-address')); ?></label>
            <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo ucfirst($systemTranslation->translate('email-address')); ?>" required
                   autofocus>
            <label for="password" class="sr-only"><?php echo ucfirst($systemTranslation->translate('password')); ?></label>
            <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo ucfirst($systemTranslation->translate('password')); ?>"
                   required>
            <input type="submit" class="btn btn-primary btn-lg btn-block" name="login" value="<?php echo ucfirst($systemTranslation->translate('login')); ?>">
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-12 text-center">
        <p><?php echo ucfirst($systemTranslation->translate('no-account')); ?>? <a href="/user/register" title="<?php echo ucfirst($systemTranslation->translate('register')); ?>">
                <?php echo ucfirst($systemTranslation->translate('register')); ?>
            </a></p>
    </div>
</div>