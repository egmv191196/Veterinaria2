function signIn(){
    var datos=$('#formSignIn').serialize();
    $.ajax({
        type: "POST",
        url: "./php/login.php",
        data: datos,
    }).done(function(response){   
        if(response==1){
            location.href ="./menu.php";
        }else if(response==2){
            alert("La contraseña es incorrecta");
            $('#passwd').val("");
            $('#passwd').trigger('focus');
        }else if(response==3){
            alert("El usuario no existe en la base de datos");
            $('#user').val("");
            $('#passwd').val("");
            $('#user').trigger('focus');
        }else if (response==4) {
            alert("El usuario no esta activo para entrar al servidor");
            $('#user').val("");
            $('#passwd').val("");
            $('#user').trigger('focus');
        }    
    }).fail(function(response){
        //alert("Hubo un error en el server, reintentelo de nuevo");
        alert(response);
    });
}
function signIn1(){
    var datos=$('#formSignIn').serialize();
    $.ajax({
        type: "POST",
        url: "./php/Conexion.php",
        data: datos,
    }).done(function(response){   
        alert(response);   
    }).fail(function(response){
        alert(response);
    });
}
//--------Producto--------
function verificarCodigo(){
    var datos = {
        "Operacion" : 'Verificar',
        id_Producto : document.getElementById("id_Pro_reg").value
    };
    $.ajax({
        type: "POST",
        url: "./php/Producto.php",
        data: datos,
    }).done(function(response){ 
        if(response == 0 ){
            $('#nom_Reg').trigger('focus');
        }else{
            alert("Producto ya esta registrado, esta asignado al producto "+response);
            $('#id_Pro_reg').val(null);
        }  
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}

function addProducto(){
    var datos = {
        "Operacion" : 'Insertar',
        id_Producto : document.getElementById("id_Pro_reg").value,
        Nombre : document.getElementById("nom_Reg").value,
        p_Compra : document.getElementById("pc_Reg").value,
        p_Lista : document.getElementById("pl_Reg").value,
        p_VentaC : document.getElementById("pv_Reg").value,
        p_VentaM : document.getElementById("pvm_Reg").value,
        p_VentaMa : document.getElementById("pvma_Reg").value,
        stock : document.getElementById("stock_Reg").value
    };
    $.ajax({
        type: "POST",
        url: "./php/Producto.php",
        data: datos,
    }).done(function(response){   
        if(response == 1 ){
            alert("Producto agregado correctamente");
            location.href ="./productos.php";
        }else{
            alert("Error al agregar el producto");
        }   
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
    return false;

}
function delProducto(id){
    var datos = {
            "Operacion" : 'Eliminar',
            "id_Producto" : $(id).parents("tr").find("td")[0].innerHTML
        };
        $.ajax({
            type: "POST",
            url: "./php/Producto.php",
            data: datos,
        }).done(function(response){      
            alert("El producto fue eliminado correctamente");
            location.reload();
        }).fail(function(response){
            alert("Hubo un error en el server, reintentelo de nuevo");
        });
}
function updatePro(){
    var datos=$('#upPro').serialize();
    $.ajax({
        type: "POST",
        url: "./php/Producto.php",
        data: datos,
    }).done(function(response){ 
        alert(response);  
        if(response == 1 ){
            alert("Producto modificado correctamente");
            location.reload();
        }else{
            alert("Error al agregar el producto");
        }   
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });

}
function editProducto(id) {
    $('#id_Producto').val($(id).parents("tr").find("td")[0].innerHTML);  
    $('#Nombre').val($(id).parents("tr").find("td")[2].innerHTML); 
    $('#p_Compra').val($(id).parents("tr").find("td")[3].innerHTML);
    $('#p_Lista').val($(id).parents("tr").find("td")[4].innerHTML);  
    $('#p_VentaC').val($(id).parents("tr").find("td")[5].innerHTML); 
    $('#p_VentaM').val($(id).parents("tr").find("td")[6].innerHTML);  
    $('#p_VentaMa').val($(id).parents("tr").find("td")[7].innerHTML);
    $('#stock').val($(id).parents("tr").find("td")[8].innerHTML);
    $("#VenActualizar").modal();
}
function editProducto2(id) {
    id_Producto=$(id).parents("tr").find("td")[0].innerHTML;
    //alert(id_Producto);
    var datos = {
        "Operacion" : 'datosProducto',
        id : id_Producto
    };
    $.ajax({
        type: "POST",
        url: "./php/Producto.php",
        data: datos,
    }).done(function(response){
        //alert(response);
        var datos=JSON.parse(response);
        alert(datos[1])
        $('#id_Producto').val(datos[0]);  
        $('#Nombre').val(datos[1]);
        $('#stock').val(datos[2]); 
        $('#p_Compra').val(datos[3]);
        $('#p_Lista').val(datos[4]);  
        $('#p_VentaC').val(datos[5]); 
        $('#p_VentaM').val(datos[6]);  
        $('#p_VentaMa').val(datos[7]);
        $("#VenActualizar").modal(); 
        $("#listaBusqueda").hide(); 
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function editProductoBusqueda(){
    Nombre=$('#nombreBusqueda').val(); 
    //alert(Nombre);
    var datos = {
        "Operacion" : 'BuscarPornombreEdit',
        texto : Nombre
    };
    $.ajax({
        type: "POST",
        url: "./php/venta.php",
        data: datos,
    }).done(function(response){
        $("#cuerpo tr").remove(); 
        var datos=JSON.parse(response);
        for ( i = 0; i < datos.length; i++) {
            document.getElementById("cuerpo").insertRow(i).innerHTML = '<tr><td>'+datos[i][0]+'</td> <td>'+
            datos[i][1]+'</td><td>'+datos[i][2]+'</td><td><button class="btn btn-success mb-2 ml-2 mr-2" onclick="editProducto2(this);">Seleccionar</button> </td> <tr>';
        }
        $('#Nombre').val(''); 
        $("#listaBusqueda").modal(); 
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });

}
//-------Proveedor-------
function addProveedor(){
    var datos=$('#addProv').serialize();
    $.ajax({
        type: "POST",
        url: "./php/Proveedor.php",
        data: datos,
    }).done(function(response){   
        if(response == 1 ){
            alert("Proveedor agregado correctamente");
            location.reload();
        }else{
            alert("Error al agregar el proveedor");
        }  
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function delProveedor(id){
    var datos = {
            "Operacion" : 'Eliminar',
            "id_Proveedor" : $(id).parents("tr").find("td")[0].innerHTML
        };
        $.ajax({
            type: "POST",
            url: "./php/Proveedor.php",
            data: datos,
        }).done(function(response){      
            alert("El proveedor fue eliminado correctamente");
            location.reload();
        }).fail(function(response){
            alert("Hubo un error en el server, reintentelo de nuevo");
        });
}
function updateProveedor(){
    var datos=$('#upPro').serialize();
    $.ajax({
        type: "POST",
        url: "./php/Proveedor.php",
        data: datos,
    }).done(function(response){ 
        if(response == 1 ){
            alert("Proveedor modificado correctamente");
            location.href ="./Proveedor.php";
        }else{
            alert("Error al modificar el proveedor");
        }   
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });

}
function editProveedor(id) {
    $('#id_Proveedor').val($(id).parents("tr").find("td")[0].innerHTML);  
    $('#Nombre').val($(id).parents("tr").find("td")[1].innerHTML); 
    $('#Direccion').val($(id).parents("tr").find("td")[2].innerHTML); 
    $('#Telefono').val($(id).parents("tr").find("td")[3].innerHTML); 
    $('#Email').val($(id).parents("tr").find("td")[4].innerHTML);  
    $('#RFC').val($(id).parents("tr").find("td")[5].innerHTML);
    $("#VenActualizar").modal();
}
/*--------------Cliente---------------*/
function addCliente(){
    var datos=$('#addCliente').serialize();
    $.ajax({
        type: "POST",
        url: "./php/Cliente.php",
        data: datos,
    }).done(function(response){   
        if(response == 1 ){
            alert("Cliente agregado correctamente");
            location.href ="./Clientes.php";
        }else{
            alert("Error al agregar el proveedor");
        }  
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });

}
function delCliente(id){
    var datos = {
        "Operacion" : 'Eliminar',
        "id_Cliente" : $(id).parents("tr").find("td")[0].innerHTML
    };
    $.ajax({
        type: "POST",
        url: "./php/Cliente.php",
        data: datos,
    }).done(function(response){      
        alert("El Cliente fue eliminado correctamente");
        location.reload();
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}

function editCliente(id){
    var datos = {
        "Operacion" : 'c_Descuento',
        "id_Cliente" : $(id).parents("tr").find("td")[0].innerHTML
    };
    $.ajax({
        type: "POST",
        url: "./php/Cliente.php",
        data: datos,
    }).done(function(response){      
        if(response==0){
            $('#t_Cliente').val(0);
        }else if(response==1){
            $('#t_Cliente').val(1);
        }else if(response==2){;
            $('#t_Cliente').val(2);
        }
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
    $('#id_Cliente').val($(id).parents("tr").find("td")[0].innerHTML);  
    $('#Nombre').val($(id).parents("tr").find("td")[1].innerHTML); 
    $('#Direccion').val($(id).parents("tr").find("td")[2].innerHTML); 
    $('#Telefono').val($(id).parents("tr").find("td")[3].innerHTML); 
    $('#Email').val($(id).parents("tr").find("td")[4].innerHTML);  
    $('#RFC').val($(id).parents("tr").find("td")[5].innerHTML);
    $("#VenActualizar").modal();
}
function updateCliente(){
    var datos=$('#upCliente').serialize();
    $.ajax({
        type: "POST",
        url: "./php/Cliente.php",
        data: datos,
    }).done(function(response){  
        if(response == 1 ){
            alert("Cliente modificado correctamente");
            location.href ="./Clientes.php";
        }else{
            alert("Error al modificar el Cliente");
        }   
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });

}
//Reimprimir ticket
function reimprimirTicket(id){
    id_Ticket= $(id).parents("tr").find("td")[0].innerHTML;
    window.open('./php/ticketv.php?id_Venta='+id_Ticket, '_blank');
}
function imprimirTicket(){
    id_Ticket= $('#folio').val();
    window.open('./php/ticketv.php?id_Venta='+id_Ticket, '_blank');   
}

// Funciones con document ready
  $(document).ready(function() {
    $('#VenRegistrar').on('shown.bs.modal', function() {
      $('#id_Pro_reg').trigger('focus');
    });
    $('#user').trigger('focus');
  });