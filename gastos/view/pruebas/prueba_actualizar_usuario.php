<?php
include_once "../../models/Usuario.php";

$cedula = "1234";

try{
    $u = Usuario::find($cedula);
    echo "DATOS ACTUALES DEL USUARIO<br>";
    echo "-------------------------_<br>";
    echo "<b>CEDULA:</b> $u->cedula<br>";
    echo "<b>CLAVE:</b> $u->clave<br>";
    echo "<b>NOMBRE:</b> $u->nombre<br>";
    echo "<b>EMAIL:</b> $u->email<br>";
    echo "<br>";

    echo "CAMBIANDO LA CLAVE Y EL EMAIL....<br>";

    $u->clave = "**123**";
    $u->email = "correozyx@gmail.com";
    $u->save();

    echo "<br>";
    echo "DATOS CAMBIADOS DEL USUARIO ACTUAL<br>";
    echo "-------------------------_<br>";
    echo "<b>CEDULA:</b> $u->cedula<br>";
    echo "<b>CLAVE:</b> $u->clave<br>";
    echo "<b>NOMBRE:</b> $u->nombre<br>";
    echo "<b>EMAIL:</b> $u->email<br>";
}

catch(Exception $error){
    echo $error->getMessage();
}