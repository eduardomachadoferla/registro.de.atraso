<?php
session_start();
require 'vendor/autoload.php';  

$datas = $_SESSION['pdf'];
$rows = $_SESSION['pdf2'];

use Fpdf\Fpdf;  

$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');

$pdf = new Fpdf();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, 'Turma', 1);  
$pdf->Cell(40, 10, 'Total', 1);  
$pdf->Cell(1, 10, '', 0, 1);

foreach($rows  as $row){
    $pdf->Cell(60, 10,  mb_convert_encoding($row['turma2'], 'ISO-8859-1', 'UTF-8'), 1);  
    $pdf->Cell(40, 10, $row['total'], 1);  
    $pdf->Cell(1, 10, '', 0, 1);
}
$pdf->Cell(1, 10, '', 0, 1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, 'Nome', 1);  
$pdf->Cell(40, 10, 'Turma', 1);  
$pdf->Cell(60, 10, 'Motivo', 1);  
$pdf->Cell(35, 10, 'Data', 1);  
$pdf->Cell(1, 10, '', 0, 1);  

foreach($datas  as $row){
    $pdf->Cell(60, 10,  mb_convert_encoding($row['nome'], 'ISO-8859-1', 'UTF-8'), 1);  
    $pdf->Cell(40, 10, mb_convert_encoding($row['turma2'], 'ISO-8859-1', 'UTF-8'), 1);  
    $pdf->Cell(60, 10,  mb_convert_encoding($row['motivo'], 'ISO-8859-1', 'UTF-8'), 1);  
    $data = explode(' ', $row['data']);
    $pdf->Cell(35, 10, implode('/', array_reverse(explode('-', $data[0]))) . ' - ' . $data[1], 1);  
    $pdf->Cell(1, 10, '', 0, 1);
}

$pdf->Output('D', 'relatorio.pdf');  
?>