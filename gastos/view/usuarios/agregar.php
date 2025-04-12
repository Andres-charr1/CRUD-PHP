<?php
    require_once "../validar_sesion.php";
    
    $msj = @$_REQUEST["msj"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF8">
    <title>document</title>

</head>

<body>
    <center>
        <h1>AGREGAR USUARIOS</h1>
        <hr>
        <!-- EL FORMULARIO HTML -->
        <form action="../../controllers/UsuarioController.php" method="POST">
            <table>
                <tr>
                    <th style="text-align: right">CEDULA:</th>
                    <td><input type="number" id="cc" name="cc" required placeholder="Digita la Cedula"></td>
                </tr>
                <tr>
                    <th style="text-align: right">CLAVE:</th>
                    <td><input type="password" id="pass" name="pass" placeholder="Digita la Clave"></td>
                </tr>
                <tr>
                    <th style="text-align: right">NOMBRE:</th>
                    <td><input type="text" id="nombre" name="nombre" required placeholder="Digita el Nombre"></td>
                </tr>
                <tr>
                    <th style="text-align: right">EMAIL:</th>
                    <td><input type="email" id="correo" name="correo" placeholder="Digita el Email"></td>
                </tr>
                <tr>
                    <td>&nbsp</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right">
                        <input type="reset" id="limpiar" value="Limpiar">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" id="accion" name="accion" value="Guardar">
                    </td>
                </tr>
            </table>
        </form>

        <span style="color: red;"><?= ($msj != NULL || isset($msj)) ?$msj : "" ?></span>
    </center>
</body>

</html>