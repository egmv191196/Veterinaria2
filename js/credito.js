$(document).ready(function() {
    $('#codigo').trigger('focus');
    $('#venAbono').on('shown.bs.modal', function () {
        $('#monto_Pago').trigger('focus');
      })
      $('#pagarAbono').on('shown.bs.modal', function () {
        $('#efectivo_Modal').trigger('focus');
      })
});
function venAbono(id){
    $('#id_Credito').val($(id).parents("tr").find("td")[0].innerHTML);  
    $('#nom_Cliente').val($(id).parents("tr").find("td")[1].innerHTML); 
    $('#total_Credito').val($(id).parents("tr").find("td")[2].innerHTML); 
    $('#total_Abonado').val($(id).parents("tr").find("td")[3].innerHTML);
    var total=parseFloat($(id).parents("tr").find("td")[2].innerHTML);
    var abonado=parseFloat($(id).parents("tr").find("td")[3].innerHTML);
    restante=total-abonado;
    $('#restante').val(restante);  
    $("#venAbono").modal();       
}
function pagarAbonoModal(){
    $('#id_CreditoModal').val($('#id_Credito').val());
    $('#total_Pagar').val($('#monto_Pago').val());
    $("#pagarAbono").modal(); 
}
function calcular_restante(){
    total=parseFloat($('#restante').val());
    abono=parseFloat($('#monto_Pago').val());
    restante=(total-abono).toFixed(2);
    $('#restante_Pagar').val(restante);
}
function calcular_Cambio(){
    deuda=parseFloat($('#total_Pagar').val());
    efectivo=parseFloat($('#efectivo_Modal').val());
    restante=(efectivo-deuda).toFixed(2);
    $('#cambio_Modal').val(restante);
}
function editProducto(id) {
    $('#id_Producto').val($(id).parents("tr").find("td")[0].innerHTML);  
    $('#Nombre').val($(id).parents("tr").find("td")[1].innerHTML); 
    $('#p_Compra').val($(id).parents("tr").find("td")[3].innerHTML); 
    $('#p_VentaC').val($(id).parents("tr").find("td")[4].innerHTML); 
    $('#p_VentaM').val($(id).parents("tr").find("td")[5].innerHTML);  
    $('#p_VentaMa').val($(id).parents("tr").find("td")[6].innerHTML);
    $('#stock').val($(id).parents("tr").find("td")[7].innerHTML);
    $("#VenActualizar").modal();
}
function pagarAbono(){
    Cambio=document.getElementById("cambio_Modal").value;
    if (Cambio>=0) {
        datos={
            "Operacion": 'Abono',
            restante : document.getElementById("restante_Pagar").value,
            Monto: document.getElementById("monto_Pago").value,
            Efectivo : document.getElementById("efectivo_Modal").value,
            Cambio : document.getElementById("cambio_Modal").value,
            id_Credito: document.getElementById("id_CreditoModal").value
        };
        $.ajax({
            type: "POST",
            url: "./php/Creditos.php",
            data: datos,
        }).done(function(response){
            //alert(response);
            if(response!=0){
                window.open('./php/ticketAbono.php?id_Abono='+response, '_blank');
                location.reload();
            }else{
                alert("Error"+response);
            }
            
        }).fail(function(response){
            console.log("error"+response);
        });

    } else {
        alert("Por favor verificar tu pago");
    }
    
    
}