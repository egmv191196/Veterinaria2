<?php
    require('../fpdf/fpdf.php');
    require_once('./Conexion.php'); 
    $id_Abono=$_GET['id_Abono'];
    //Numero de productos
    $consulta = "SELECT * FROM operacion_credito JOIN lineacredito JOIN usuario JOIN cliente 
    WHERE operacion_credito.id_Abono=$id_Abono AND operacion_credito.id_Credito=lineacredito.id_CreditoTotal 
    AND operacion_credito.id_User=usuario.id_User AND lineacredito.id_Cliente=cliente.id_Cliente";
    $res = mysqli_query($conexion,$consulta);
    $row = mysqli_fetch_array($res);
    $Fecha=$row[1];
    $Hora=$row[2];
    $Monto=$row[3];
    $Efectivo=$row[4];
    $Cambio=$row[5];
    $montoCredito=$row[9];
    $montoAbonado=$row[10];
    $montoRestante=$montoCredito-$montoAbonado;
    $empleado=$row[14];
    $cliente=$row[22];

    $pdf = new FPDF('P','mm',array(80,115)); // Tamaño tickt 80mm x 150 mm (largo aprox)
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
    $pdf->Cell(60,3,'Fecha y hora del Abono: '.$Fecha.' '. $Hora,0,1,'');
    $pdf->Cell(10,3,'Folio del Abono: '.$id_Abono,0,1,'');
    $pdf->Cell(10,3,'Vendedor: '.$empleado,0,1,'');
    $pdf->Cell(10,3,'Cliente: '.$cliente,0,1,'');
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(75, 10, 'ABONO', 0,1,'C');
    $pdf->Cell(75,0,'','T');
    $pdf->Ln(1);
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Ln(3);
    $pdf->Ln(1);        
    $pdf->Cell(50, 5, 'Monto del credito: ', 0,0);    
    $pdf->Cell(25, 5,'$'.number_format($montoCredito, 2, '.', ''),0,1);
    $pdf->Cell(50, 5, 'Monto del abono: ', 0,0);    
    $pdf->Cell(10, 5,'$'.number_format($Monto, 2, '.', ''),0,1);
    $pdf->Cell(50, 5, 'Pago: ', 0,0);    
    $pdf->Cell(10, 5,'$'.number_format($Efectivo, 2, '.', ''),0,1);
    $pdf->Cell(50, 5, 'Cambio: ', 0,0);    
    $pdf->Cell(10, 5,'$'.number_format($Cambio, 2, '.', ''),0,1);
    if ($montoRestante==0) {
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(75, 5, 'Gracias por su pago', 0,1,'C');
        $pdf->Cell(75, 5, 'Su credito esta liquidado', 0,1,'C');   
    }else{
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(75, 5, 'Monto para liquidar su credito', 0,1,'C');    
        $pdf->Cell(75, 6,'$'.number_format($montoRestante, 2, '.', ''),0,1,'C');
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(75,0,'Gracias por su abono',0,1,'C');   
    }
    $pdf->Output('Nota.pdf','i');
?>
