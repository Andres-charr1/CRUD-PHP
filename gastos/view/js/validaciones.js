// --------------------------------------------
 function habilitarBotone() {
   
    const botonEditar = document.getElementById("editar");
    const botonEliminar = document.getElementById("eliminar");
    const campoNombre = document.getElementById("nombre");
    const campoClave = document.getElementById("pass");
    const campoEmail = document.getElementById("correo");

    // Agregamos el evento de clic en el botón Editar
    campoNombre.addEventListener("input", () => {
    
        if (campoNombre.value === "") {
            // Deshabilita el botón
            botonEditar.disabled = true;
            botonEliminar.disabled = true;
        } else {
        
            botonEditar.disabled = false;
        }
    });

  
    if (campoNombre.value === "") {
        botonEditar.disabled = true;
        botonEliminar.disabled = true;
        campoNombre.setAttribute("readonly", true);
        campoClave.setAttribute("readonly", true);
        campoEmail.setAttribute("readonly", true);
    }
   
    else {
        botonEditar.disabled = false;
        botonEliminar.disabled = false;
        campoNombre.removeAttribute("readonly");
        campoClave.removeAttribute("readonly");
        campoEmail.removeAttribute("readonly");
    }
} 
function confirmarOperacion() {
    
    const botonEditar = document.getElementById("editar");
    const botonEliminar = document.getElementById("eliminar");

  
    botonEditar.addEventListener("click", (event) => {
        mensaje = "¿Desea Modificar los datos de este Usuario?";
        return confirmar(mensaje, event);
    });

    botonEliminar.addEventListener("click", (event) => {
        mensaje = "¿Desea Eliminar los datos de este Usuario?";
     
        confirmar(mensaje, event);
    });
}

// --------------------------------------------

// Función para validar el formulario de registro
function confirmar(mensaje, evento) {
   
    const respuesta = confirm(mensaje);
   
    if (!respuesta) {
      
        evento.preventDefault();
    }
}
