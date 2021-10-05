$(document).ready(function() {
    $('#codigo').trigger('focus');
    $('#comprarProducto').on('shown.bs.modal', function () {
        $('#piezas_compradas').trigger('focus')
      })
});
function leerCodigo(){
    var datos = {
        "Operacion" : 'Consulta',
        id_Producto : document.getElementById("codigo").value
    };
    $.ajax({
        type: "POST",
        url: "./php/Compra.php",
        data: datos,
    }).done(function(response){       
        //alert(response);
        if(response==2){
            alert("No se puede vender ese articulo, ya no hay piezas en el sistema, favor de revisar el inventario");
            $('#codigo').val(""); 
            $('#codigo').trigger('focus');
        }else if(response==0){
            alert("Por favor verificar el codigo, no se encontro en producto");
            $('#codigo').val(""); 
            $('#codigo').trigger('focus');
        }else if(response!=0){
            var producto=JSON.parse(response);
            $('#id_Pro_Compra').val(producto.Id);
            $('#nom_Compra').val(producto.Nombre);
            $('#stock_Compra').val(producto.Cantidad);
            $('#pc_Anterior').val(parseFloat( producto.p_Compra).toFixed(2));
            $('#stock_Compra').val(producto.Cantidad);
            $('#piezas_compradas').val(""); 
            $('#precio_Compra').val(""); 
            $("#comprarProducto").modal();             
        }
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function agregarProducto(){
    var datos = {
        "Operacion" : 'Agregar',
        id_Producto : document.getElementById("id_Pro_Compra").value,
        Descripcion : document.getElementById("nom_Compra").value,
        Cantidad : document.getElementById("piezas_compradas").value,
        precio_Compra : document.getElementById("precio_Compra").value,
    };
    $.ajax({
        type: "POST",
        url: "./php/Compra.php",
        data: datos,
    }).done(function(response){ 
        //alert(response);
        if(response==0){
            alert("Hubo un error al agregar el producto, intentarlo de nuevo");
            $('#codigo').val(""); 
            $('#codigo').trigger('focus');
        }else if(response!=0){
            var producto=JSON.parse(response);
            var id=producto.iD;
            var cantidad=parseFloat(producto.Cantidad).toFixed(2);
            var p_Compra=parseFloat(producto.p_Compra).toFixed(2);
            var subtotal=parseFloat(producto.subtotal).toFixed(2);
            document.getElementById("Productos").insertRow(-1).innerHTML = '<td>'+id+'</td><td>'+producto.Nombre+'</td><td>'
            +cantidad+'</td><td>'+p_Compra+'</td><td>'+subtotal+'</td><td><button type="button" onclick="devolucionProducto(this);" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>';
            var total=parseFloat($('#Total').val());
            var subtotal=parseFloat(producto.subtotal); 
            total=(total+subtotal).toFixed(2);
            $('#Total').val(total);
            $('#codigo').val(""); 
            $('#codigo').trigger('focus');
        }
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
    $("#comprarProducto").modal('hide');
    $('#codigo').val(""); 
    $('#codigo').trigger('focus'); 
}
function devolucionProducto(id){
    var Subtotal=parseFloat($(id).parents("tr").find("td")[4].innerHTML);
    var total=parseFloat($('#Total').val());
    total=(total-Subtotal).toFixed(2);
    $('#Total').val(total);
    var datos = {
        "Operacion" : "Devolucion",
        id_Producto : $(id).parents("tr").find("td")[0].innerHTML,
        Cantidad : $(id).parents("tr").find("td")[2].innerHTML
    };
    $.ajax({
        type: "POST",
        url: "./php/Compra.php",
        data: datos,
    }).done(function(response){ 
        if(response==0){
            alert("Error al devolver el producto");
        }else if(response==1){
            $(id).closest('tr').remove();
        }
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });

}
function Compra(){
    if ($('#id_Proveedor').val().length == 0 ) {
        alert("Falta el proveedor ");
        $('#id_Proveedor').trigger('focus');
    }else if ( $('#num_Ticket').val().length == 0){
        alert("Falta numero de ticket");
        $('#num_Ticket').trigger('focus');
    }else{
        //alert("Procede pago")
        var producto=[];
        var list_Productos=[];
        var resume_table = document.getElementById("Productos");
        for (var i = 1, row; row = resume_table.rows[i]; i++) {
            id_Pro = row.cells[0];
            Nombre= row.cells[1];//Nombre
            Cant = row.cells[2];
            p_Unit = row.cells[3];
            p_total = row.cells[4];
            producto=[`${id_Pro.innerText}`,`${Nombre.innerText}`,`${p_Unit.innerText}`,`${Cant.innerText}`,`${p_total.innerText}`];
            list_Productos.push(producto);        
        }
        //alert(list_Productos);
        datos={
            "Operacion": 'Pago',
            Productos: list_Productos,
            Total : document.getElementById("Total").value,
            numTicket : document.getElementById("num_Ticket").value,
            Proveedor : document.getElementById("id_Proveedor").value
        };
        $.ajax({
            type: "POST",
            url: "./php/Compra.php",
            data: datos,
        }).done(function(response){
            //alert(response);
            if(response!=0){
                window.open('./php/ticketC.php?id_Compra='+response, '_blank');
                location.reload();
            }else{
                alert("Error"+response);
            }
            
        }).fail(function(response){
            console.log("error"+response);
        });
    }
        
}
function BusquedaNombre(){
    var datos = {
        "Operacion" : 'BuscarPornombre',
        texto : document.getElementById("Nombre").value
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
            datos[i][1]+'</td>  <td><button class="btn btn-success mb-2 ml-2 mr-2" onclick="selectArticulo(this);">Seleccionar</button> </td> <tr>';
        }
        $('#Nombre').val(''); 
        $("#listaBusqueda").modal(); 
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function selectArticulo(id){
    id_Producto = $(id).parents("tr").find("td")[0].innerHTML;
    $(codigo).val(id_Producto);
    $("#listaBusqueda").modal("hide");
    leerCodigo()
}
function recorrerTabla(){
    var resume_table = document.getElementById("rwd-table-id");
    for (var i = 1, row; row = resume_table.rows[i]; i++) {
    //alert(cell[i].innerText);
    for (var j = 0, col; col = row.cells[j]; j++) {
        //alert(col[j].innerText);
        console.log(`Txt: ${col.innerText} \tFila: ${i} \t Celda: ${j}`);
    }
    }
}