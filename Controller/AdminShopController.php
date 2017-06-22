<?php
/**
 * Created by PhpStorm.
 * User: steph
 * Date: 22-6-2017
 * Time: 14:54
 */

namespace Controller;


use Main\Controller;

class AdminShopController extends Controller
{
 public function settingsAction (){
        return $this->write(array());
 }
}