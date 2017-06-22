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
                        <a href="/user/orderlist"><?php echo ucfirst($systemTranslation->translate('my-orders')); ?></a>
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
                <label for="name" class="required"><?php echo ucfirst($systemTranslation->translate('name')); ?></label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo $user->getName(); ?>required>
            </div>
            <div class="form-group">
                <label for="email-address" class="required"><?php echo ucfirst($systemTranslation->translate('email-address')); ?></label>
                <input type="email" name="email-address" id="email-address" class="form-control" value="<?php echo $user->getEmailAddress(); ?> required>
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
                <label for="language" class="required"><?php echo ucfirst($systemTranslation->translate('language')); ?></label>
                <select name="language" id="language" class="selectpicker form-control" required>
                    <?php foreach ($controller->getValue('languages') as $language) : ?>
                        <option value="<?php echo $language['idLanguage']; ?>"><?php echo $language['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="address" class="required"><?php echo ucfirst($systemTranslation->translate('address')); ?></label>
                <input type="text" name="address" id="address" class="form-control" value="<?php echo $user->getAddress(); ?>required>
            </div>
            <div class="form-group">
                <label for="postal-code" class="required"><?php echo ucfirst($systemTranslation->translate('postal-code')); ?>Postcode</label>
                <input type="text" name="postal-code" id="postal-code" class="form-control" max-length="6" value="<?php echo $user->getpostalCode(); ?> required>
            </div>
            <div class="form-group">
                <label for="city" class="required"><?php echo ucfirst($systemTranslation->translate('city')); ?></label>
                <input type="text" name="city" id="city" class="form-control" value="<?php echo $user->getCity(); ?> required>
            </div>
            <div class="form-group">
                <label for="phonenumber"><?php echo ucfirst($systemTranslation->translate('phone-number')); ?></label>
                <input type="text" name="phonenumber" id="phonenumber" class="form-control" value="<?php echo $user->getPhoneNumber(); ?>>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="register" value="<?php echo ucfirst($systemTranslation->translate('register')); ?>">
            </div>
        </form>
    </div>
</div>