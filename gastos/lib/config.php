<?php
require_once 'php-activerecord/ActiveRecord.php';

 ActiveRecord\Config::initialize(function($cfg)
 {
     $cfg->set_model_directory($_SERVER["DOCUMENT_ROOT"]."gastos/models");
     $cfg->set_connections(array(
         'development' => 'mysql://root:root@localhost/gastos_udec'));
 });
