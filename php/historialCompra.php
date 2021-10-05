<?php
require('../fpdf/fpdf.php');
require_once('./Conexion.php'); 
$codigo=$_GET['codigo'];
$Fecha=date('Y-m-d');
$fechaImprimir=date('d-m-Y');
$pdf = new FPDF('P','mm',array(216,279)); 
$pdf->AddPage();
$pdf->SetMargins(10, 5, 10);
// CABECERA
$pdf->Image('../img/BALBI-sin-fondo.png',10,10,30);
$pdf->SetFont('Helvetica','',18);
$pdf->Cell(200,5,'Farmacia Veterinaria Balbi',0,1,'C');
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(200,5,'RFC: MEML740112FM9',0,1,'C');
$pdf->Cell(200,5,'16 de Septiembre #1512 Int, 2',0,1,'C');
$pdf->Cell(200,5,'C.P.: 74325 Chipilo Pue',0,1,'C');
$pdf->Cell(200,5,'Telefono: 2222830571',0,1,'C');
$pdf->Cell(200,5,'Correo: vetbalbi@hotmail.com',0,1,'C');
//Reporte
$pdf->Ln(3);
$pdf->SetFont('Helvetica','',18);
$pdf->Cell(200,5,'Historia del compra',0,1,'C');
$pdf->SetFont('Helvetica','',15);
$pdf->Cell(200,5,'Codigo del producto: '.$codigo,0,1,'C');
$pdf->Ln(3);
$pdf->SetLineWidth(1.5);
$pdf->Cell(200,0,'','T');
// DATOS del reporte      
$pdf->Ln(5);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(80,5,'Fecha del reporte: '.$Fecha,0,1);
$pdf->Cell(200,0,'',0,1,'T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Ln(1);
$pdf->Cell(50, 7, 'Nombre del articulo', 0,0);
$pdf->Cell(50, 6, 'Proveedor', 0,0);
$pdf->Cell(50, 6, 'Fecha de compra', 0,0);
$pdf->Cell(40, 6, 'Precio de compra', 0,1);
$pdf->Ln(1);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', '', 12);
$consulta = "SELECT * FROM productos_compra JOIN compra JOIN proveedor WHERE productos_compra.id_Producto=$codigo AND productos_compra.id_Compra=compra.id_Compra 
AND compra.id_Proveedor=proveedor.id_Proveedor ORDER BY precio_Compra ASC";
$res = mysqli_query($conexion,$consulta);
while ($row = mysqli_fetch_array($res)) {
    $pdf->Cell(50, 5, $row[2], 0,0  );
    $pdf->Cell(50, 5, $row[13], 0,0  );
    $pdf->Cell(50, 5, $row[7], 0,0  );
    $pdf->Cell(40, 5, $row[4], 0,1);
}
$pdf->Output('Nota','i');
?>
