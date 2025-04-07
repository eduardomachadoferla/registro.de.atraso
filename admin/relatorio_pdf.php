<?php
session_start();
require '../vendor/autoload.php';  

$pdf_title = utf8_decode($_SESSION['pdf_title']);
$datas = $_SESSION['pdf'];

use Fpdf\Fpdf;  

$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');

$pdf = new Fpdf();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 15);
$pdf->Text(10, 10, $pdf_title, 1);
$pdf->Cell(1, 10, '', 0, 1);  

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 10, 'Nome', 1);  
$pdf->Cell(20, 10, 'Turma', 1);  
$pdf->Cell(60, 10, 'Motivo', 1);  
$pdf->Cell(35, 10, 'Data', 1);  
$pdf->Cell(1, 10, '', 0, 1);  

foreach($datas  as $row){
    $pdf->Cell(80, 10,  mb_convert_encoding($row['nome'], 'ISO-8859-1', 'UTF-8'), 1);  
    $pdf->Cell(20, 10, mb_convert_encoding($row['turma'], 'ISO-8859-1', 'UTF-8'), 1);  
    $pdf->Cell(60, 10,  mb_convert_encoding($row['motivo'], 'ISO-8859-1', 'UTF-8'), 1);  
    $data = explode(' ', $row['data']);
    $pdf->Cell(35, 10, implode('/', array_reverse(explode('-', $data[0]))) . ' - ' . $data[1], 1);  
    $pdf->Cell(1, 10, '', 0, 1);
}

$pdf->Output('D', $pdf_title.'.pdf');  
?>