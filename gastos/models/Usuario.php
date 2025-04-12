<?php
require_once $_SERVER["DOCUMENT_ROOT"]."gastos/lib/config.php";

class Usuario extends ActiveRecord\Model{
    public static $primary_key = "cedula";
    public static $has_many = array(array("gastos"));
}