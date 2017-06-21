<?php
$user = $controller->getValue('user');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="navbar navbar-default">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="?page=orderList">Mijn Bestellingen</a>
                    </li>
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Mijn Gegevens</a>
                        <ul class="dropdown-menu">
                            <li><a href="?page=user">Gegevens wijzigen</a></li>
                            <li><a href="?page=password">Wachtwoord wijzigen</a></li>
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
                <label for="name" class="required">Naam</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email-address" class="required">Emailadres</label>
                <input type="email" name="email-address" id="email-address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password" class="required">Wachtwoord</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password-repeat" class="required">Herhaal wachtwoord</label>
                <input type="password" name="password-repeat" id="password-repeat" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="language" class="required">Taal</label>
                <select name="language" id="language" class="selectpicker form-control" required>
                    <option selected>Nederlands</option>
                    <option>Engels</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address" class="required">Adres</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="postal-code" class="required">Postcode</label>
                <input type="text" name="postal-code" id="postal-code" class="form-control" max-length="6" required>
            </div>
            <div class="form-group">
                <label for="city" class="required">Plaats</label>
                <input type="text" name="city" id="city" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phonenumber">Telefoonnummer</label>
                <input type="text" name="phonenumber" id="phonenumber" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="register" value="Registreer">
            </div>
        </form>
    </div>
</div>