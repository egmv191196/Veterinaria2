<?php
require('../fpdf/fpdf.php');
require_once('./Conexion.php'); 
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
$pdf->Cell(200,5,'Productos con alto stock',0,1,'C');
$pdf->Ln(3);
$pdf->SetLineWidth(1.5);
$pdf->Cell(200,0,'','T');
// DATOS del reporte      
$pdf->Ln(5);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(80,5,'Fecha del reporte: '.$fechaImprimir,0,1);
$pdf->Cell(200,0,'',0,1,'T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Ln(1);
$pdf->Cell(50, 7, 'Codigo', 0,0);
$pdf->Cell(120, 6, 'Descripcion', 0,0);
$pdf->Cell(20, 6, 'Cantidad', 0,1);
$pdf->Ln(1);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', '', 12);
$consulta = "SELECT * FROM producto ORDER by Cantidad DESC LIMIT 85";
$res = mysqli_query($conexion,$consulta);
while ($row = mysqli_fetch_array($res)) {
    $pdf->Cell(50, 5, $row[0], 0,0  );
    $pdf->Cell(120, 5, $row[2], 0,0  );
    $pdf->Cell(20, 5, $row[3], 0,1);
}
$pdf->Output('Nota','i');
?>
