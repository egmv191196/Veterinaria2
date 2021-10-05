<?php
require('../fpdf/fpdf.php');
require_once('./Conexion.php'); 
$Fecha=date('Y-m-d');
$fechaImprimir=date('d-m-Y');
//Cantidad de productos
$consulta = "SELECT SUM(Cantidad) FROM productos_venta JOIN venta WHERE venta.Fecha='$Fecha' AND productos_venta.id_Venta=venta.id_Venta";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$numProductos=$row[0];
//total Venta dia
$consulta = "SELECT SUM(Total) FROM venta WHERE Fecha='$Fecha'";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$TotalVenta=$row[0];
//Ingresos por abono de credito
$consulta = "SELECT SUM(Monto) FROM operacion_credito WHERE Fecha='$Fecha'";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$totalAbono=$row[0];
//Total ingreso
$totalIngreso=$totalAbono+$TotalVenta;

//Creditos
$consulta = "SELECT COUNT(id_Credito) FROM creditoVenta WHERE Fecha='$Fecha'";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$numCreditos=$row[0];

//saldo de credito restantes
$consulta = "SELECT SUM(monto_Credito) FROM creditoVenta WHERE Fecha='$Fecha'";
$res = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($res);
$totalCredito=$row[0];
$totalRestante=$totalCredito;

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
$pdf->Cell(200,5,'Productos vendidos en el dia',0,1,'C');
$pdf->Ln(3);
$pdf->SetLineWidth(1.5);
$pdf->Cell(200,0,'','T');
// DATOS del reporte      
$pdf->Ln(5);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(80,5,'Fecha del reporte: '.$fechaImprimir,0);
$pdf->Ln(5);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
// PRODUCTOS
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(200, 7, 'Productos', 0,1,'C');
$pdf->Cell(150, 6, 'Concepto', 0,0);
$pdf->Cell(50, 6, 'Cantidad', 0,1);
$pdf->Ln(1);
$pdf->SetLineWidth(.5);
$pdf->Cell(200,0,'','T');
$pdf->Ln(1);
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(150, 5, 'Cantidad de productos vendidos ', 0,0);
$pdf->Cell(50, 5, $numProductos, 0,1);
$pdf->Cell(200, 5, 'Productos mas vendidos', 0,1);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(20, 5, 'Numero', 0,0  );
$pdf->Cell(130, 5, 'Descripcion', 0,0  );
$pdf->Cell(50, 5, 'Cantidad', 0,1);
$pdf->SetFont('Helvetica', '', 10);
//Productos mas vendidos
$consulta = "SELECT DISTINCT productos_venta.id_Producto,productos_venta.Nombre, SUM(Cantidad) AS total FROM productos_venta JOIN venta 
WHERE venta.Fecha='$Fecha' AND productos_venta.id_Venta=venta.id_Venta GROUP BY productos_venta.id_Producto ORDER BY total DESC LIMIT 15";
$res = mysqli_query($conexion,$consulta);
$i=1;
while ($row = mysqli_fetch_array($res)) {
    $pdf->Cell(20, 5, $i.'-', 0,0  );
    $pdf->Cell(130, 5, $row[1], 0,0  );
    $pdf->Cell(50, 5, $row[2], 0,1);
    $i++;
}
$pdf->Output('Nota','i');
?>
