<div class="row">
    <div class="col-sm-4">
        <input type="text" class="form-control" placeholder="<?php echo ucfirst($systemTranslation->translate('search')); ?>...">
    </div>
    <div class="col-sm-4">
        <button type="button" class="btn btn-primary btn-sm"><?php echo ucfirst($systemTranslation->translate('search')); ?></button>
    </div>
    <div class="col-sm-4">
        <a href="/user/newuser" title="Nieuwe gebruiker" class="btn btn-primary btn-sm"><?php echo ucfirst($systemTranslation->translate('new-user')); ?></a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th><?php echo ucfirst($systemTranslation->translate('name')); ?></th>
                <th><?php echo ucfirst($systemTranslation->translate('email-address')); ?></th>
                <th><?php echo ucfirst($systemTranslation->translate('type')); ?></th>
                <th><?php echo ucfirst($systemTranslation->translate('actions')); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Jan Jansen</td>
                <td>jan@domain.domain</td>
                <td>Gebruiker</td>
                <td>
                    <a href="/user/newuser" title="<?php echo ucfirst($systemTranslation->translate('edit')); ?>" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" title="<?php echo ucfirst($systemTranslation->translate('delete')); ?>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Debby van Woensel</td>
                <td>debby@domain.domain</td>
                <td>Gebruiker</td>
                <td>
                    <a href="/user/newuser" title="<?php echo ucfirst($systemTranslation->translate('edit')); ?>" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" title="<?php echo ucfirst($systemTranslation->translate('delete')); ?>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Nadine Beekmans</td>
                <td>nadine@domain.domain</td>
                <td>Gebruiker</td>
                <td>
                    <a href="/user/newuser" title="<?php echo ucfirst($systemTranslation->translate('edit')); ?>" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" title="<?php echo ucfirst($systemTranslation->translate('delete')); ?>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Sjaak de Bruijn</td>
                <td>sjaak@domain.domain</td>
                <td>Beheerder</td>
                <td>
                    <a href="/user/newuser" title="<?php echo ucfirst($systemTranslation->translate('edit')); ?>" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" title="<?php echo ucfirst($systemTranslation->translate('delete')); ?>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Henk de Vries</td>
                <td>henk@domain.domain</td>
                <td>Gebruiker</td>
                <td>
                    <a href="/user/newuser" title="<?php echo ucfirst($systemTranslation->translate('edit')); ?>" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" title="<?php echo ucfirst($systemTranslation->translate('delete')); ?>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>