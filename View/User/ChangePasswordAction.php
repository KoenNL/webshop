<?php
$user = $controller->getValue('user');
$systemTranslation = $controller->getValue('systemTranslation');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="navbar navbar-default">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/user/orderlist"><?php echo ucfirst($systemTranslation->translate('my orders')); ?></a>
                    </li>
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><?php echo ucfirst($systemTranslation->translate('my-data')); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="/user/user"><?php echo ucfirst($systemTranslation->translate('change-data')); ?></a></li>
                            <li><a href="/user/password"><?php echo ucfirst($systemTranslation->translate('change-password')); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <form>
            <div class="form-group">
                <label for="current-password" class="required"><?php echo ucfirst($systemTranslation->translate('current-password')); ?></label>
                <input type="password" name="current-password" id="current-password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password" class="required"><?php echo ucfirst($systemTranslation->translate('password')); ?></label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password-repeat" class="required"><?php echo ucfirst($systemTranslation->translate('password-repeat')); ?></label>
                <input type="password" name="password-repeat" id="password-repeat" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="save" value="<?php echo ucfirst($systemTranslation->translate('edit')); ?>">
            </div>
        </form>
    </div>
</div>