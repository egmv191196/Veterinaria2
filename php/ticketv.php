<?php
require('../fpdf/fpdf.php');
require_once('./Conexion.php'); 
$id_Venta=$_GET['id_Venta'];
//Numero de productos
$consulta = "SELECT COUNT(*) FROM `productos_venta` WHERE id_Venta=$id_Venta";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$numProductos=$row[0];
//Valores necesarios
$consulta = "SELECT venta.Fecha, venta.Hora, usuario.Nombre, cliente.Nombre, venta.Total, venta.Pago, venta.Cambio, venta.forma_Pago
FROM venta JOIN cliente JOIN usuario WHERE 
id_Venta=$id_Venta AND venta.id_User=usuario.id_User AND venta.id_Cliente=cliente.id_Cliente";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$fecha=$row[0];
$hora=$row[1];
$cajero=$row[2];
$cliente=$row[3];
$Total=$row[4];
$Pago=$row[5];
$cambiO=$row[6];
$forma_Pago=$row[7];
$alto=92+($numProductos*4);
$pdf = new FPDF('P','mm',array(80,$alto)); // Tamaño tickt 80mm x 150 mm (largo aprox)
$pdf->AddPage();
$pdf->SetMargins(2, 5, 2);
// CABECERA
$pdf->Image('../img/BALBI-sin-fondo.png',2,8,15);
$pdf->SetFont('Helvetica','',11);
$pdf->Cell(65,4,'Farmacia Veterinaria Balbi',0,1,'C');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(75,4,'RFC: MEML740112FM9',0,1,'C');
$pdf->Cell(75,4,'16 de Septiembre #1512 Int, 2',0,1,'C');
$pdf->Cell(75,4,'C.P.: 74325 Chipilo Pue',0,1,'C');
$pdf->Cell(75,4,'Telefono: 2222830571',0,1,'C');
$pdf->Cell(75,4,'Correo: vetbalbi@hotmail.com',0,1,'C');
 
// DATOS FACTURA        
$pdf->Ln(2);
$pdf->Cell(60,3,'Fecha y hora de compra: '.$fecha.' '. $hora,0,1,'');
$pdf->Cell(10,3,'No Nota: '.$id_Venta,0,1,'');
$pdf->Cell(10,3,'Vendedor: '.$cajero,0,1,'');
$pdf->Cell(10,3,'Cliente: '.$cliente,0,1,'');
if ($forma_Pago==0) {
    $pdf->Cell(10,3,'Forma de pago: Efectivo',0,1,'');
}else {
    $pdf->Cell(10,3,'Forma de pago: Credito',0,1,'');
}
// COLUMNAS
$pdf->SetFont('Helvetica', 'B', 7);
//$pdf->Cell(8, 10, 'Cod', 0);
$pdf->Cell(10, 10, 'Cant.',0,0,'L');
$pdf->Cell(30, 10, 'Articulo', 0,0,'L');
$pdf->Cell(15, 10, 'P.Unit',0,0,'L');
$pdf->Cell(20, 10, 'Subtotal',0,0,'L');
$pdf->Ln(3);
$pdf->Cell(75,0,'','T');
$pdf->Ln(1);
 
// PRODUCTOS
$pdf->SetFont('Helvetica', 'B', 7);
$consulta = "SELECT * FROM `productos_venta` WHERE id_Venta=$id_Venta";
$res = mysqli_query($conexion,$consulta);
while($row = mysqli_fetch_array($res)){
//$pdf->Cell(8, 10, $row[1], 0);
$pdf->Cell(10, 10,  number_format($row[3], 2, '.', ''),0,0,'L');
$pdf->Cell(30, 10,  substr($row[2], 0, 18), 0,0,'L');
$pdf->Cell(15, 10,   '$'.number_format($row[4], 2, '.', ''),0,0,'L');
$pdf->Cell(20, 10,  '$'.number_format($row[5], 2, '.', ''),0,0,'L');
$pdf->Ln(4);
}

// SUMATORIO DE LOS PRODUCTOS Y EL IVA
if ($forma_Pago==0) {
    $pdf->Ln(3);
    $pdf->Cell(75,0,'','T');
    $pdf->Ln(1);        
    $pdf->Cell(55, 3, 'TOTAL: ', 0,0,'R');    
    $pdf->Cell(15, 3,'$'.number_format($Total, 2, '.', ''),0,1,'L');
    $pdf->Ln(1);
    $pdf->Cell(55, 3, 'Efectivo: ', 0,0,'R');    
    $pdf->Cell(15, 3,'$'.number_format($Pago, 2, '.', ''),0,1,'L');
    $pdf->Ln(1);
    $pdf->Cell(55, 3, 'Cambio: ', 0,0,'R');    
    $pdf->Cell(15, 3,'$'.number_format($cambiO, 2, '.', ''),0,1,'L');
    $pdf->Ln(1);
}else {
    $consulta = "SELECT id_Credito FROM creditoVenta WHERE id_Venta=$id_Venta";
    $res = mysqli_query($conexion,$consulta);
    $row = mysqli_fetch_array($res);
    $id_Credito=$row[0];
    $pdf->Ln(3);
    $pdf->Cell(75,0,'','T');
    $pdf->Ln(1);        
    $pdf->Cell(55, 3, 'TOTAL: ', 0,0,'R');    
    $pdf->Cell(15, 3,'$'.number_format($Total, 2, '.', ''),0,'L');
    $pdf->Ln(3);
    $pdf->Cell(75, 3, 'Monto abonado a su credito: $'.number_format($Total, 2, '.', ''), 0,0,'C');    
    $pdf->Ln(5);
}

// PIE DE PAGINA
$pdf->Cell(75,0,'Gracias por su compra ',0,1,'C');

$pdf->Output('Nota'.$id_Venta.'.pdf','i');
?>
