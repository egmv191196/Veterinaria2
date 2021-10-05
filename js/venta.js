$(document).ready(function() {
    $('#codigo').trigger('focus');
    $('#Pagar').on('shown.bs.modal', function () {
        $('#modal_Pago').trigger('focus')
    })
    $('#ticketPendiente').on('shown.bs.modal', function () {
    $('#nombre_tPendiente').trigger('focus')
    })
});
function leer(){
    var datos = {
        "Operacion" : 'Venta',
        id_Producto : document.getElementById("codigo").value,
        Cantidad : document.getElementById("cantidad").value,
        precio : document.getElementById("Descuento").value,
    };
    $.ajax({
        type: "POST",
        url: "./php/venta.php",
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
            var cantidad=parseFloat(producto.Cantidad).toFixed(2);
            var precioUnitario=parseFloat(producto.Precio).toFixed(2);
            var subtotal=parseFloat(producto.Subtotal).toFixed(2);
            //alert("El producto es "+producto.Nombre )
            document.getElementById("Productos").insertRow(-1).innerHTML = '<td>'+producto.Id+'</td><td>'+producto.Nombre+'</td><td>'
            +precioUnitario+'</td><td>'+cantidad+'</td><td>'+subtotal+'</td><td><button type="button" onclick="devolucionProducto(this);" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>';
            var total=parseFloat($('#Total').val());
            var subtotal=parseFloat(producto.Subtotal); 
            //var resume_table = document.getElementById("Productos");
            total=(total+subtotal).toFixed(2);
            /*for (var i = 1, row; row = resume_table.rows[i]; i++) {
                    col=row.cells[4];
                    precio=parseInt( col.innerText);
                    total=total+precio;
            }*/
            console.log(total);
            $('#Total').val(total);
            $('#codigo').val(""); 
            $('#codigo').trigger('focus');
        }
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function Descuento(){
    var datos = {
        "Operacion" : 'c_Descuento',
        id_Cliente : document.getElementById("id_cliente").value
    };
    $.ajax({
        type: "POST",
        url: "./php/Cliente.php",
        data: datos,
    }).done(function(response){ 
        //alert("El valor del hidden es "+ $('#Descuento').val());
        //alert(response);
        if(response==0){
            $('#Descuento').val(0);
        }else if(response==1){
            $('#Descuento').val(1);
        }else if(response==2){;
            $('#Descuento').val(2);
        }
        $('#codigo').trigger('focus');
        //alert("El nuevo valor del hidden es "+ $('#Descuento').val());
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function devolucionProducto(id){
    var Subtotal=parseFloat($(id).parents("tr").find("td")[4].innerHTML);
    var total=parseFloat($('#Total').val());
    total=(total-Subtotal).toFixed(2);
    $('#Total').val(total);
    var datos = {
        "Operacion" : "Devolucion",
        id_Producto : $(id).parents("tr").find("td")[0].innerHTML,
        Cantidad : $(id).parents("tr").find("td")[3].innerHTML
    };
    $.ajax({
        type: "POST",
        url: "./php/venta.php",
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
function pagar_modal(){
    $('#modal_Total').val($('#Total').val());   
    $('#modal_Cambio').val((0.00).toFixed(2)); 
    $("#Pagar").modal();       
}
function pagoEfectivo(){
    var producto=[];
    var list_Productos=[];
    var Total=document.getElementById("modal_Total").value;
    var Efectivo=document.getElementById("modal_Pago").value;
    var cambio=Efectivo-Total;
    if (cambio>=0) {
        //alert("se puede cobrar");
        var resume_table = document.getElementById("Productos");
        for (var i = 1, row; row = resume_table.rows[i]; i++) {
            id_Pro = row.cells[0];
            Nombre= row.cells[1];//Nombre
            p_Unit = row.cells[2];
            Cant = row.cells[3];
            p_total = row.cells[4];
            //producto=[`${id_Pro.innerText}`,`${p_Unit.innerText}`,`${Cant.innerText}`,`${p_total.innerText}`];
            producto=[`${id_Pro.innerText}`,`${Nombre.innerText}`,`${p_Unit.innerText}`,`${Cant.innerText}`,`${p_total.innerText}`];
            list_Productos.push(producto);        
        }
        //alert(list_Productos);
        datos={
            "Operacion": 'PagoEfectivo',
            Productos: list_Productos,
            Total : document.getElementById("modal_Total").value,
            Efectivo : document.getElementById("modal_Pago").value,
            Cambio : document.getElementById("modal_Cambio").value,
            Cliente : document.getElementById("id_cliente").value
        };
        $.ajax({
            type: "POST",
            url: "./php/venta.php",
            data: datos,
        }).done(function(response){
            //alert(response);
            if(response!=0){
                window.open('./php/ticketv.php?id_Venta='+response, '_blank');
                location.reload();
            }else{
                alert("Error"+response);
            }
            
        }).fail(function(response){
            console.log("error"+response);
        });
        console.log(list_Productos);
    }else{
        alert("Verifica el monto pagado");
    }
}
function pagoCredito(){
    if(document.getElementById("id_cliente").value!=1){
        var producto=[];
        var list_Productos=[];
        var resume_table = document.getElementById("Productos");
        for (var i = 1, row; row = resume_table.rows[i]; i++) {
            id_Pro = row.cells[0];
            Nombre= row.cells[1];
            p_Unit = row.cells[2];
            Cant = row.cells[3];
            p_total = row.cells[4];
            producto=[`${id_Pro.innerText}`,`${Nombre.innerText}`,`${p_Unit.innerText}`,`${Cant.innerText}`,`${p_total.innerText}`];
            list_Productos.push(producto);        
        }
        datos={
            "Operacion": 'PagoCredito',
            Productos: list_Productos,
            Total : document.getElementById("modal_Total").value,
            Cliente : document.getElementById("id_cliente").value
        };
        $.ajax({
            type: "POST",
            url: "./php/venta.php",
            data: datos,
        }).done(function(response){
            //alert(response);
            if(response!=0){
                window.open('./php/ticketv.php?id_Venta='+response, '_blank');
                location.reload();
            }else{
                alert("Error"+response);
            }
            
        }).fail(function(response){
            console.log("error"+response);
        });
    }else{
        alert("No se puede ofrecer un credito a un cliente general");
    }
}
function calcular_cambio(){
    var total=parseFloat($('#modal_Total').val()).toFixed(2);
    var efectivo=parseFloat($('#modal_Pago').val()).toFixed(2);
    var cambio=(efectivo-total).toFixed(2);
    console.log(total);
    console.log(efectivo);
    console.log(cambio);
    $('#modal_Cambio').val(cambio); 
    
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
            datos[i][1]+'</td> <td>'+datos[i][2]+'</td> <td>$ '+number_format(datos[i][3], 2)+'</td> <td>$'+number_format(datos[i][4], 2)+'</td> <td> $'
            +number_format(datos[i][5],2)+'</td> <td> $'+number_format(datos[i][6], 2)+
            '</td> <td><button class="btn btn-success mb-2 ml-2 mr-2" onclick="selectArticulo(this);">Seleccionar</button> </td> <tr>';
        }
        $('#Nombre').val(''); 
        $("#listaBusqueda").modal(); 
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}
function selectArticulo(id){
    id_Producto = $(id).parents("tr").find("td")[0].innerHTML;
    $(codigo).val(id_Producto);
    $("#listaBusqueda").modal("hide");
    leer();
}
function mostrarPendientes(){
    var datos = {
        "Operacion" : 'recuperarVenta',
    };
    $.ajax({
        type: "POST",
        url: "./php/venta.php",
        data: datos,
    }).done(function(response){
        $("#cuerpoPendientes tr").remove(); 
        var datos=JSON.parse(response);
        for ( i = 0; i < datos.length; i++) {
            document.getElementById("cuerpoPendientes").insertRow(i).innerHTML = '<tr><td>'+datos[i][0]+'</td> <td>'+
            datos[i][1]+'</td> <td><button class="btn btn-secondary mb-2 ml-2 mr-2" onclick="seleccionarPendiente(this);">Seleccionar</button></td><tr>';
        }
        $("#TicketsPendientes").modal();
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}

function modalNombrePendiente(){
    $("#ticketPendiente").modal();
}
function seleccionarPendiente(id){
    //alert($(id).parents("tr").find("td")[0].innerHTML);
    var datos = {
        Operacion : "datosvSuspendida",
        id_Ticket : $(id).parents("tr").find("td")[0].innerHTML
    };
    $.ajax({
        type: "POST",
        url: "./php/venta.php",
        data: datos,
    }).done(function(response){
        var datos=JSON.parse(response);
        $("#id_cliente").val(datos[0][0]);
        $("#Descuento").val(datos[0][1]);
        $("#Total").val(datos[0][2]);
        for ( i = 1; i < datos.length; i++) {
            document.getElementById("Productos").insertRow(i).innerHTML = '<tr><td>'+datos[i][0]+'</td> <td>'+
            datos[i][1]+'</td> <td>'+
            datos[i][2]+'</td> <td>'+
            datos[i][3]+'</td> <td>'+
            datos[i][4]+'</td><td><button type="button" onclick="devolucionProducto(this);" class="btn btn-danger"><i class="fa fa-trash"></i></button></td><tr>';
        }
        $("#TicketsPendientes").modal('hide');
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function guardarPendiente(){
    var producto=[];
    var list_Productos=[];
    var resume_table = document.getElementById("Productos");
    for (var i = 1, row; row = resume_table.rows[i]; i++) {
        id_Pro = row.cells[0];
        Nombre= row.cells[1];//Nombre
        p_Unit = row.cells[2];
        Cant = row.cells[3];
        p_total = row.cells[4];
        producto=[`${id_Pro.innerText}`,`${Nombre.innerText}`,`${p_Unit.innerText}`,`${Cant.innerText}`,`${p_total.innerText}`];
        list_Productos.push(producto);        
    }
    datos={
        "Operacion": 'suspenderVenta',
        Productos: list_Productos,
        cliente : document.getElementById("nombre_tPendiente").value,
        id_Cliente : document.getElementById("id_cliente").value,
        Descuento : document.getElementById("Descuento").value,
        Total : document.getElementById("Total").value
    };
    $.ajax({
        type: "POST",
        url: "./php/venta.php",
        data: datos,
    }).done(function(response){
        //alert(response);
        if(response!=0){
            alert("Folio para pagar en caja es "+response);
            location.reload();
        }else{
            alert("Error"+response);
        }
    }).fail(function(response){
        console.log("error"+response);
    });
    console.log(list_Productos);
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