<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/gastos/models/Usuario.php";

class UsuarioController{

    // -----------------------
    public static function ejecutarAccion(){
        // Recuperamos el campo accion enviado por el formulario
        $accion = @$_REQUEST["accion"];
        // Verificamos si el campo accion no es nulo
        switch($accion){
            case "Guardar":
                // Invocamos al metodo guardar
                UsuarioController::guardar();
                break;
            case "Buscar":
                // Invocamos al metodo buscar
                UsuarioController::buscar();
                break;
            case "Editar":
                // Invocamos al metodo editar
                UsuarioController::editar();
                break;
            case "Eliminar":
                // Invocamos al metodo eliminar
                UsuarioController::eliminar();
                break;
            case "todo":
                // Invocamos al metodo listar_todo
                UsuarioController::listar_todo();
                break;
            case "Login":
                // Invocamos el metodo login
                UsuarioController::login();
                break;

            default:
                // Si no se cumple ninguna de las anteriores, redireccionamos a la pagina error
                header("Location: ../view/error.php?msj=Accion no permitida");
                exit;
        }
    }

    // -----------------------
    public static function guardar(){
        // Recuperar los campos enviados por el formulario
        $cedula = @$_REQUEST["cc"];
        $clave = @$_REQUEST["clave"];
        $nombre = @$_REQUEST["nombre"];
        $email = @$_REQUEST["email"];

        // Crear una instancia (objeto) de tipo Usuario
        $u = new Usuario();
        // Ponerle los campos como valores de las propiedades
        $u->cedula = $cedula;
        $u->clave = $clave;
        $u->nombre = $nombre;
        $u->email = $email;

        // Intentar guardar el Usuario en la BD
        try{
            // Guardar el usuario
            $u->save();
            // Contar los Usuarios guardados
            $total = Usuario::count();
            $msj = "Usuario guardado, Total: $total";
            // Redireccionar a la pagina guardar enviandole un mensaje
            header("Location: ../view/usuarios/agregar.php?msj=$msj");
            exit;
        }
        // Capturar algun posible error o Excepcion
        catch(Exception $error){
            // Verificar si el error es de clave primaria Duplicada
            if(strstr($error->getMessage(), "Duplicate")){
                $msj = "El Usuario con Cedula: $cedula ya existe";
            }
            else{
                // Otro mensaje sino es error por usuario duplicado
                $msj = "Ocurrió un error al Guardar el Usuario";
            }
            // Redireccionamos a la pagina agregar con el mensaje de error
            header("Location: ../view/usuarios/agregar.php?msj=$msj");
            exit;
        }
    }

    // -----------------------
    public static function buscar(){
        // Recuperar los campos enviados por el formulario
        $cedula = @$_REQUEST["cc"];

        // Intentar buscar el Usuario en la BD
        try{
            // Buscamos el usuario
            $u = Usuario::find($cedula);

            // colocamos el usuario en la sesion
            $_SESSION["usuario.find"] = serialize($u);
            $msj = "Usuario encontrado";
            // Redireccionar a la pagina buscar enviandole un mensaje
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
        // Capturar algun posible error o Excepcion
        catch(Exception $error){
            // Verificar si el error es de clave primaria Duplicada
            if(strstr($error->getMessage(), $cedula)){
                $msj = "El Usuario con Cedula: $cedula no existe";
            }
            else{
                // Otro mensaje sino es error por usuario duplicado
                $msj = "Ocurrió un error al Buscar el Usuario";
            }

            // Redireccionamos a la pagina buscar con el mensaje de error
            $_SESSION["usuario.find"] = NULL;
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
    }

    public static function editar(){
        // Recuperar los campos enviados por el formulario
        $cedula = @$_REQUEST["cc"];
        // Obtenemos el usuario consultado anteriormente
        $u = $_SESSION["usuario.find"];
        // lo deserializamos y reconvertimos en objeto de tipo Usuario
        $u = unserialize($u);
        // Validamos que el usuario consultado sea el mismo que se desea editar
        if($u->cedula != $cedula){
            $msj = "La cédula no corresponde al usuario consultado";
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
    
        // Recuperamos los campos cambiados en el formulario
        $clave = @$_REQUEST["pass"];
        $nombre = @$_REQUEST["nombre"];
        $email = @$_REQUEST["correo"];
        // los colocamos en el Usuario consultado
        $u->clave = $clave;
        $u->nombre = $nombre;
        $u->email = $email;
        
        // Intentar guardar los cambios del Usuario en la BD
        try{
            // Guardar el usuario
            $u->save();
            // Volvemos a serializar el Usuario editado y lo guardamos en la sesión
            $_SESSION["usuario.find"] = serialize($u);
            $msj = "Usuario editado.";
            // Redireccionar a la pagina buscar enviandole un mensaje
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
        // Capturar algun posible error o Excepcion
        catch (Exception $error) {
            // Verificar si el error es de clave primaria Duplicada
            if (strstr($error->getMessage(), $cedula)) {
                $msj = "El Usuario con cédula: $cedula no existe";
            } else {
                // Otro mensaje sino es error por usuario duplicado
                $msj = "Ocurrió un error al Editar al Usuario";
            }
    
            // Redireccionamos la pagina agregar con el mensaje de error
            $_SESSION["usuario.find"] = NULL;
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
    }

    public static function eliminar(){
        // Recuperar los campos enviados por el formulario
        $cedula = @$_REQUEST["cc"];
        // Obtenemos el usuario consultado anteriormente
        $u = $_SESSION["usuario.find"];
        // Lo deserializamos y reconvertimos en objeto de tipo Usuario
        $u = unserialize($u);
        // Validamos que el usuario consultado sea el mismo que se desea eliminar
        if($u->cedula != $cedula){
            $msj = "La cédula no corresponde al usuario consultado";
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
    
        // Intentar Eliminar el Usuario en la BD
        try {
            // Eliminamos el usuario
            $u->delete();
            // Quitamos de la sesión el Usuario consultado
            $_SESSION["usuario.find"] = null;
            // Contamos los Usuarios en la BD
            $total = Usuario::count();
            $msj = "Usuario Eliminado, Total: $total";
            // Redireccionar a la pagina buscar enviándole un mensaje
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
        // Capturar algún posible error o Excepción
        catch (Exception $error) {
            // Verificar si el error es porque no existe esa cédula en la BD
            if (strstr($error->getMessage(), $cedula)) {
                $msj = "El Usuario con Cédula: $cedula no existe";
            } else {
                // Otro mensaje en caso de que sea otra la causa del error
                $msj = "Ocurrió un error al Eliminar el Usuario";
            }
    
            // Redireccionamos a la página buscar con el mensaje de error
            $_SESSION["usuario.find"] = NULL;
            header("Location: ../view/usuarios/buscar.php?msj=$msj");
            exit;
        }
    }
    
    public static function listar_todo(){
    try {
        // obtener todos los Usuarios
        $usuarios = Usuario::all();
        if ($usuarios == null) {
            $_SESSION["usuarios.all"] = null;
            $msj = "Total Usuarios: 0";
        } else {
            $total = count($usuarios);
            // Serializar (convertir en texto) la lista de usuarios
            $usuarios = serialize($usuarios);
            // Colocamos la lista de usuarios en sesión para poder
            // recuperarla en la página de reporte de usuarios
            $_SESSION["usuarios.all"] = $usuarios;
        }
        // redireccionamos hacia la página de reportes
        $msj = "Total Usuarios: $total";
        header("Location: ../view/usuarios/listar_todo.php?msj=$msj");
    } catch (Exception $error) {
        $_SESSION["usuarios.all"] = null;
        header("Location: ../view/usuarios/listar_todo.php?msj=Total Usuarios: 0");
        }
    }

    public static function login(){
    $cedula = @$_REQUEST["cc"];
    $clave  = @$_REQUEST["pass"];
    try {
        $u = Usuario::find($cedula);
        if ($u->clave == $clave) {
            $u = serialize($u);
            $_SESSION["usuario.login"] = $u;
            header("Location: ../view/usuarios/index.php");
            exit;
        } else {
            $_SESSION["usuario.login"] = null;
            header("Location: ../view/usuarios/login.php?msj=Password Incorrecto");
            exit;
        }
    }
    catch (Exception $error) {
        if (strstr($error->getMessage(), $cedula)) {
            $msj = "El Usuario con Cédula: $cedula no existe";
        } else {
            $msj = "Ocurrió un error al Iniciar Sesión";
        }
        $_SESSION["usuario.find"] = null;
        header("Location: ../view/usuarios/login.php?msj=$msj");
        exit;
        }
    }

}

// **Ejecutamos la acción después de definir la clase**
UsuarioController::ejecutarAccion();