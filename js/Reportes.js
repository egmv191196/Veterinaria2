$(document).ready(function() {
    $('#corteModal').on('shown.bs.modal', function () {
        $('#efectivoContado').trigger('focus')
      })
      $('#codigoModal').on('shown.bs.modal', function () {
        $('#codigoProducto').trigger('focus')
      })
});
function asignarFondoModal(){
    alert("Error");
    $("#asignarFondoModal").modal();  
}
function asignarFondo(){
    Usuario=document.getElementById("id_empleado").value;
    Efectivo=document.getElementById("efectivoFondo").value;
    if (Efectivo>0&& Usuario!=null) {
        datos={
            "Operacion": 'Asignacion',
            Empleado : Usuario,
            Monto: Efectivo
        };
        $.ajax({
            type: "POST",
            url: "./php/Caja.php",
            data: datos,
        }).done(function(response){
            if(response!=0){
                window.open('./php/ticketFondo.php?id_Caja='+response, '_blank');
                location.reload();
            }else{
                alert("Error"+response);
            }
        }).fail(function(response){
            console.log("error"+response);
        });
    } else {
        alert("Por favor verificar los datos ingresados");
    }
} 
//
function corteModal(){
    $("#corteModal").modal();  
}
function datosCorte(){
    Usuario=document.getElementById("id_empleadoCorte").value;
    datos={
        "Operacion": 'CorteDatos',
        Empleado : Usuario
    };
    $.ajax({
        type: "POST",
        url: "./php/Caja.php",
        data: datos,
    }).done(function(response){
        if (response!=0) {
            var datosCorte=JSON.parse(response);
            var fondo=parseFloat(datosCorte.Fondo).toFixed(2);
            var ingresoTotal=parseFloat(datosCorte.IngresoTotal).toFixed(2);
            var total=Number(fondo)+Number(ingresoTotal);
            $('#fondoModal').val("");
            $('#totalIngreso').val("");
            $('#totalPorEntregar').val("");
            $('#totalPorEntregar').val(total);
            $('#fondoModal').val(fondo);
            $('#totalIngreso').val(ingresoTotal);
        }else{
            $('#fondoModal').val("");
            $('#totalIngreso').val("");
            $('#totalPorEntregar').val(""); 
        }
    }).fail(function(response){
        console.log("error"+response);
    });
}
function calcularDiferencia(){
    Total=parseFloat($('#totalPorEntregar').val()).toFixed(2);
    efectivo=parseFloat($('#efectivoContado').val()).toFixed(2);
    Diferencia=parseFloat(efectivo-Total).toFixed(2);
    $('#diferenciaCorte').val(Diferencia);
}
function realizarCorte(){
    Efectivo=$('#efectivoContado').val();
    if (Efectivo==""|| Efectivo==0) {
        alert("Verificar el campo de efectivo");
    } else {
        Usuario=$('#id_empleadoCorte').val();
        totalIngreso=$('#totalIngreso').val();
        totalDia=$('#totalPorEntregar').val();
        Diferencia=$('#diferenciaCorte').val();
        datos={
            "Operacion": 'Corte',
            Empleado : Usuario,
            totalIngreso: totalIngreso,
            totalDia: totalDia,
            efectivo: Efectivo,
            diferencia: Diferencia
        };
        $.ajax({
            type: "POST",
            url: "./php/Caja.php",
            data: datos,
        }).done(function(response){
            //alert(response);
            if(response!=0){
                window.open('./php/ticketCorte.php?id_Caja='+response, '_blank');
                location.reload();
            }else{
                alert("Error"+response);
            }
        }).fail(function(response){
            console.log("error"+response);
        });
    } 
}
function ProductosVendidos(){
    window.open('./php/productosVendidos.php', '_blank');
    location.reload();
}
function corteDia(){
    window.open('./php/reporteCajaDia.php', '_blank');
    location.reload();
}
function bajoStock(){
    window.open('./php/bajoStock.php', '_blank');
    location.reload();
}
function altoStock(){
    window.open('./php/altoStock.php', '_blank');
    location.reload();
}
function historialCompraModal(){
    $("#codigoModal").modal();
}
function historialCompra(){
    codigo=$('#codigoProducto').val();
    window.open('./php/historialCompra.php?codigo='+codigo, '_blank');
    location.reload();

}
function reporteCliente(){
    idCliente=$('#id_ClienteModal').val();
    window.open('./php/reporteCliente.php?id_Cliente='+idCliente, '_blank');
    location.reload();
}
function fecha1(){

}
function fecha(){
    fechaInicio = $('#fecha').val();
    var datos = {
        "Operacion" : 'ticketPorFecha',
        Fecha : fechaInicio
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
            datos[i][1]+'</td> <td>'+datos[i][2]+'</td> <td>$ '+datos[i][3]+'</td> <td><button class="btn btn-success mb-2 ml-2 mr-2" onclick="reimprimirTicket(this);">Seleccionar</button> </td> <tr>';
        } 
        $("#listarTickets").modal(); 
    }).fail(function(response){
        alert("Hubo un error en el server, reintentelo de nuevo");
    });
}
function reimprimirTicket(id){
    id_Ticket= $(id).parents("tr").find("td")[0].innerHTML;
    window.open('./php/ticketv.php?id_Venta='+id_Ticket, '_blank');
}
