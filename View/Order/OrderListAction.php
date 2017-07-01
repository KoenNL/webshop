<div class="row">
    <div class="col-sm-12">
        <div class="navbar navbar-default">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="page=orderList"><?php echo ucfirst($systemTranslation->translate('my-orders')); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="/Order/Orderlist" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><?php echo ucfirst($systemTranslation->translate('my-data')); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="/user/change"><?php echo ucfirst($systemTranslation->translate('change-data')); ?></a></li>
                            <li><a href="?page=password"><?php echo ucfirst($systemTranslation->translate('change-password')); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Datum<span class="caret"></span></th>
                <th>Bedrag</th>
                <th>Status</th>
                <th>Inzien</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>12-05-2017 14:44</td>
                <td>&euro; 286,75</td>
                <td>Betaald</td>
                <td>
                    <a class="btn btn-default btn-sm" href="?page=order" title="<?php echo ucfirst($systemTranslation->translate('view-order')); ?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>10-05-2017 20:34</td>
                <td>&euro; 178,98</td>
                <td>Besteld</td>
                <td>
                    <a class="btn btn-default btn-sm" href="?page=order" title="<?php echo ucfirst($systemTranslation->translate('view-order')); ?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>08-05-2017 12:13</td>
                <td>&euro; 76,54</td>
                <td>Verzonden</td>
                <td>
                    <a class="btn btn-default btn-sm" href="?page=order" title="<?php echo ucfirst($systemTranslation->translate('view-order')); ?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>04-05-2017 09:53</td>
                <td>&euro; 24,99</td>
                <td>Verzonden</td>
                <td>
                    <a class="btn btn-default btn-sm" href="?page=order" title="<?php echo ucfirst($systemTranslation->translate('view-order')); ?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>02-05-2017 11:34</td>
                <td>&euro; 87,98</td>
                <td>Verzonden</td>
                <td>
                    <a class="btn btn-default btn-sm" href="?page=order" title="<?php echo ucfirst($systemTranslation->translate('view-order')); ?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>