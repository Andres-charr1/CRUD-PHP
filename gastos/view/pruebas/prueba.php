<?php
include_once  "../../models/Usuario.php";

$u = new Usuario ();
$u->cedula = "321";
$u->nombre = "EL PROFE CACHON RECARGADO";
$u->email = "elcachonfelizV2@gmail.com";
try{
    $u->save();
    $total = @Usuario::count();
    echo "Usuarios guardado";
    echo "Total: $total";
}
catch(Exception $error){
    $msj = $error->getMessage();
    if(strstr($msj, "Duplicate")){
        echo  "El usuario ya existe";
    }
}