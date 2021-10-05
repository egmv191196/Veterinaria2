<?php
require('../fpdf/fpdf.php');
require_once('./Conexion.php'); 
$id_Compra=$_GET['id_Compra'];
//Numero de productos
$consulta = "SELECT COUNT(*) FROM productos_compra WHERE id_Compra=$id_Compra";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$numProductos=$row[0];
//Valores necesarios
$consulta = "SELECT compra.Fecha, compra.Hora, compra.num_Ticket, Proveedor.Nombre, compra.Total
FROM compra JOIN proveedor WHERE 
id_Compra=$id_Compra AND compra.id_Proveedor=proveedor.id_Proveedor";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$fecha=$row[0];
$hora=$row[1];
$numticket=$row[2];
$proveedor=$row[3];
$Total=$row[4];
$alto=78+($numProductos*4);
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
$pdf->Cell(60,3,'Fecha y hora de compra: '.$fecha.' '.$hora,0,1,'');
$pdf->Cell(10,3,'No Nota: '.$id_Compra,0,1,'');
$pdf->Cell(10,3,'Proveedor: '.$proveedor,0,1,'');
// COLUMNAS
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Cell(20, 10, 'Codigo', 0);
$pdf->Cell(26, 10, 'Articulo', 0,0,'L');
$pdf->Cell(10, 10, 'P.Unit',0,0,'L');
$pdf->Cell(8, 10, 'Cant.',0,0,'L');
$pdf->Cell(7, 10, 'Subtotal',0,0,'L');
$pdf->Ln(3);
$pdf->Cell(75,0,'','T');
$pdf->Ln(1);
 
// PRODUCTOS
$pdf->SetFont('Helvetica', 'B', 7);
$consulta = "SELECT * FROM productos_compra WHERE id_Compra=$id_Compra";
$res = mysqli_query($conexion,$consulta);
while($row = mysqli_fetch_array($res)){
$pdf->Cell(20, 10, $row[1], 0);
$pdf->Cell(26, 10,  substr($row[2], 0, 21), 0,0,'L');
$pdf->Cell(10, 10,   '$'.number_format($row[4], 2, '.', ''),0,0,'L');
$pdf->Cell(8, 10,  number_format($row[3], 2, '.', ''),0,0,'L');
$pdf->Cell(7, 10,  '$'.number_format($row[5], 2, '.', ''),0,0,'L');
$pdf->Ln(4);
}

// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(3);
$pdf->Cell(75,0,'','T');
$pdf->Ln(1);        
$pdf->Cell(65, 3, 'TOTAL: ', 0,0,'R');    
$pdf->Cell(10, 3,'$'.number_format($Total, 2, '.', ''),0,'L');
$pdf->Ln(1);
// PIE DE PAGINA
$pdf->Cell(75,0,'Compra registrada',0,1,'C');

$pdf->Output('Nota'.$id_Compra.'.pdf','i');
?>
