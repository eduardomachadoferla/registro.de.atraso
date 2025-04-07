<?php
session_start();
require '../vendor/autoload.php';

use Fpdf\Fpdf;

$pdf_title = utf8_decode($_SESSION['pdf_title']);
$datas = $_SESSION['pdf'];

$pdf = new Fpdf();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 15);
$pdf->Text(10, 10, $pdf_title, 1);
$pdf->Cell(1, 10, '', 0, 1);  

// Cabeçalho
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, 'Turma', 1);
$pdf->Cell(40, 10, 'Total', 1);
$pdf->Ln();

if (is_array($datas)) {
    foreach($datas as $row){
        $turma = isset($row['turma2']) ? $row['turma2'] : (isset($row['turma']) ? $row['turma'] : '---');
        $total = isset($row['total']) ? $row['total'] : '0';

        $pdf->Cell(60, 10, mb_convert_encoding($turma, 'ISO-8859-1', 'UTF-8'), 1);
        $pdf->Cell(40, 10, $total, 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(100, 10, 'Nenhum dado disponível para exibir.', 1);
}

$pdf->Output('D', $pdf_title.'.pdf');
?>
