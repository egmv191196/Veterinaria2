function addUser(){
    if($('#telefono').val()==""){
        telefono=0;
    }else{
        telefono=$('#telefono').val();
    }
    if($('#Correo').val()==""){
        correo=null;
    }else{
        correo=$('#telefono').val();
    }
    var datos = {
        "Operacion" : 'Insertar',
        Nombre : $('#nombreEmpleado').val(),
        Telefono : telefono,
        Correo : correo,
        Usuario : $('#Usuario').val(),
        Password : $('#password').val(),
        puesto : $('#Puesto').val(),
        estado : $('#Estado').val()
    };
    $.ajax({
        type: "POST",
        url: "./php/usuarios.php",
        data: datos,
    }).done(function(response){   
        if(response == 1 ){
            alert("Usuario agregado correctamente");
            location.reload();
        }else{
            alert("Error al agregar al usuario");
        }   
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
    return false;
}
function editUser(id){
    var datos = {
        "Operacion" : 'Buscar',
        id : $(id).parents("tr").find("td")[0].innerHTML
    };
    $.ajax({
        type: "POST",
        url: "./php/usuarios.php",
        data: datos,
    }).done(function(response){   
        if(response != 0 ){
            var user=JSON.parse(response);
            $('#editIDEmpleado').val(user.Id);
            $('#editnombreEmpleado').val(user.Nombre);
            $('#editPass').val(user.Pass);    
            $('#edittelefono').val(user.Telefono); 
            $('#editCorreo').val(user.Correo); 
            $('#editPuesto').val(user.Puesto); 
            $('#editEstado').val(user.Estado); 
            $("#editUsuario").val(user.Usuario);
            $("#editUser").modal();
        }else{
            alert("hubo un error");
        }   
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
    return false; 
}
function updateUser(){
    var datos = {
        "Operacion" : 'Actualizar',
        Id_User : $('#editIDEmpleado').val(),
        Nombre : $('#editnombreEmpleado').val(),
        Pass : $('#editPass').val(),
        Telefono : $('#edittelefono').val(),
        Correo : $('#editCorreo').val(),
        Usuario : $('#editUsuario').val(),
        puesto : $('#editPuesto').val(),
        estado : $('#editEstado').val()
    };
    $.ajax({
        type: "POST",
        url: "./php/usuarios.php",
        data: datos,
    }).done(function(response){  
        if(response == 1 ){
            alert("Usuario actualizado correctamente");
            location.reload();
        }else{
            alert("Error al actualizar el usuario");
        }   
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
    return false; 
}