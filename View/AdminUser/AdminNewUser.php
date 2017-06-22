<?php
$user = $controller->getValue('user');
$systemTranslation = $controller->getValue('systemTranslation');
?>
<div class="row">
    <div class="col-sm-6">
        <form>
            <div class="form-group">
                <label for="name" class="required"><?php echo ucfirst($systemTranslation->translate('name')); ?></label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email-address" class="required"><?php echo ucfirst($systemTranslation->translate('email-address')); ?></label>
                <input type="email" name="email-address" id="email-address" class="form-control" required>
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
                <label for="type" class="required"><?php echo ucfirst($systemTranslation->translate('type')); ?></label>
                <select name="type" id="type" class="selectpicker form-control" required>
                    <option>Gebruiker</option>
                    <option>Beheerder</option>
                </select>
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
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="postal-code" class="required"><?php echo ucfirst($systemTranslation->translate('postal-code')); ?>Postcode</label>
                <input type="text" name="postal-code" id="postal-code" class="form-control" max-length="6" required>
            </div>
            <div class="form-group">
                <label for="city" class="required"><?php echo ucfirst($systemTranslation->translate('city')); ?></label>
                <input type="text" name="city" id="city" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phonenumber"><?php echo ucfirst($systemTranslation->translate('phone-number')); ?></label>
                <input type="text" name="phonenumber" id="phonenumber" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="save" value="<?php echo ucfirst($systemTranslation->translate('save')); ?>">
                <a href="/user/userlist" title="Terug naar overzicht" class="btn btn-default"><?php echo ucfirst($systemTranslation->translate('back-to-overview')); ?></a>
            </div>
        </form>
    </div>
</div>