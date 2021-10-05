<?php
require('../fpdf/fpdf.php');
require_once('./Conexion.php');
$id_Cliente=$_GET['id_Cliente']; 
$Fecha=date('Y-m-d');
$fechaImprimir=date('d-m-Y');
//Datos Cliente
$consulta = "SELECT * FROM cliente  WHERE id_cliente=$id_Cliente";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$nombreCliente=$row[1];
//Linea de credito
$consulta = "SELECT * FROM lineacredito WHERE id_Cliente=$id_Cliente";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$idCredito=$row[0];
$saldoAcumulado=$row[1];
$saldoAbonado=$row[2];
$saldoRestante=$row[3];
//Compras
$consulta = "SELECT * FROM creditoventa WHERE id_creditoTotal='$idCredito'";
$res1 = mysqli_query($conexion,$consulta);
$numCompras=mysqli_num_rows($res1);
//Abonos
$consulta = "SELECT * FROM operacion_credito WHERE id_Credito=$idCredito";
$res2 = mysqli_query($conexion,$consulta);
$numAbonos=mysqli_num_rows($res2);

$row = mysqli_fetch_array($res);
//$totalAbono=$row[0];
//Total ingreso

//
$pdf = new FPDF('P','mm',array(216,279)); // Tamaño tickt 80mm x 150 mm (largo aprox)
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
$pdf->Cell(200,5,'Reporte del cliente '.$nombreCliente,0,1,'C');
$pdf->Ln(3);
$pdf->SetLineWidth(1.5);
$pdf->Cell(200,0,'','T');
// DATOS del reporte      
$pdf->Ln(2);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(80,5,'Fecha del reporte: '.$fechaImprimir,0);
$pdf->Ln(8);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');

// Ingresos
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(200, 7, 'Compras Realizadas', 0,1,'L');
$pdf->Ln(1);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50, 6, 'Ticket de compra', 0,0,'L');
$pdf->Cell(50, 6, 'Fecha', 0,0);
$pdf->Cell(50, 6, 'Hora', 0,0);
$pdf->Cell(50, 6, 'Monto', 0,1);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->SetFont('Helvetica', '', 10);
while ($row = mysqli_fetch_array($res1)) {
    $pdf->Ln(1);
    $pdf->Cell(50, 6, $row[4], 0,0,'L');
    $pdf->Cell(50, 6, $row[1], 0,0);
    $pdf->Cell(50, 6, $row[2], 0,0);
    $pdf->Cell(50, 6, '$'.number_format($row[3], 2), 0,1);
}
$pdf->Ln(1);
//Abonos
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(200, 7, 'Abonos realizados', 0,1,'L');
$pdf->Ln(1);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50, 6, 'Ticket de Abono', 0,0,'L');
$pdf->Cell(50, 6, 'Fecha', 0,0);
$pdf->Cell(50, 6, 'Hora', 0,0);
$pdf->Cell(50, 6, 'Monto', 0,1);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->SetFont('Helvetica', '', 10);
while ($row = mysqli_fetch_array($res2)) {
    $pdf->Ln(1);
    $pdf->Cell(50, 6, $row[0], 0,0,'L');
    $pdf->Cell(50, 6, $row[1], 0,0);
    $pdf->Cell(50, 6, $row[2], 0,0);
    $pdf->Cell(50, 6, '$'.number_format($row[3], 2), 0,1);
}
$pdf->Ln(1);
//Monto total
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(200, 7, 'Saldo del credito', 0,1,'L');
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(150, 7, 'Total Compras', 0,0,'L');
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50, 6,  '$'.number_format($saldoAcumulado, 2), 0,1);
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(150, 7, 'Total Abonos', 0,0,'L');
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50, 6,  '$'.number_format($saldoAbonado, 2), 0,1);
$pdf->Ln(1);
$pdf->Cell(150,0,'','');
$pdf->Cell(50,0,'','T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(150, 7, 'Restante', 0,0,'L');
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(50, 6,  '$'.number_format($saldoRestante, 2), 0,1);
$pdf->Ln(1);

$pdf->Output('Nota','i');
?>
