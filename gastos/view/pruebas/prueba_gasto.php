<?php
include_once "../../models/Usuario.php";
include_once "../../models/Gasto.php";

$g = new Gasto();
$g->valor = '2023-09-15';
$g->fecha = 25000;
$g->detalles = "Esto es un mensaje de prueba";
$g->usuario_id = "1234";
try{
    $g->save();
    $total = @Gasto::count();
    echo "Gasto guardado";
    echo "Total: $total";
}
catch(Exception $error){
    $msj = $error->getMessage();
    if(strstr($msj, "Duplicate")){
        echo "El gasto ya existe";
    }
}