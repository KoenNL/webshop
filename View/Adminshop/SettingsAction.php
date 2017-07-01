<div class="row">
    <div class="col-sm-6">
        <form>
            <div class="form-group">
                <label for="name" class="required"><?php echo ucfirst($systemTranslation->translate('name')); ?></label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="shipping-costs" class="required"><?php echo ucfirst($systemTranslation->translate('shipping-costs')); ?></label>
                <input type="text" class="form-control" name="shipping-costs" id="shipping-costs" required>
            </div>
            <div class="form-group">
                <label for="shipping-costs-threshold" class="required"><?php echo ucfirst($systemTranslation->translate('shipping-costs-threshold')); ?></label>
                <input type="text" class="form-control" name="shipping-costs-threshold" id="shipping-costs-threshold" required>
            </div>
            <div class="form-group">
                <label for="default-combination-discount" class="required"><?php echo ucfirst($systemTranslation->translate('default-combination-discount')); ?></label>
                <input type="text" class="form-control" name="default-combination-discount" id="default-combination-discount" required>
            </div>
            <div class="form-group">
                <label for="default-tax" class="required"><?php echo ucfirst($systemTranslation->translate('default-tax')); ?></label>
                <input type="text" class="form-control" name="default-tax" id="default-tax" required>
            </div>
            <div class="form-group">
                <label for="language" class="required"><?php echo ucfirst($systemTranslation->translate('default-language')); ?></label>
                <select name="language" id="language" class="selectpicker form-control">
                    <option>Nederlands</option>
                    <option>Engels</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="save" value="<?php echo ucfirst($systemTranslation->translate('save')); ?>">
            </div>
        </form>
    </div>
</div>