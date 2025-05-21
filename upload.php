<?php
global $pdo;
require 'vendor/autoload.php';
include('config/base.php');
include('config/conexao.php');
ini_set('exibir_erros', 1);
ini_set('exibir_erros_de_inicialização', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\IOFactory;

$inputFileName = __dir__ . '/arquivo/relacao_alunos.xls';

$spreadsheet = IOFactory::load($inputFileName);
$sheet = $spreadsheet->getActiveSheet();
$dataArray = $sheet->toArray();


$stmt = $pdo->prepare("INSERT INTO alunos (matricula, turma, nome) VALUES (?,?,?)");
try {
    $pdo->beginTransaction();
    $stmt2 = $pdo->prepare("TRUNCATE TABLE alunos");
    $stmt2->execute();

    foreach ($dataArray as $key => $row)
    {
        if($key === 0)
            continue;

        // $stmt->execute(str_replace(' - 2025', '', $row));
        $stmt->execute([
            0 => $row[0] , 
            1 => str_replace(' - 2025', '', $row[1]), 
            2 => mb_convert_encoding($row[2], "UTF-8", mb_detect_encoding($row[2]))
        ]);
    }
    $pdo->commit();

    echo 'Sucesso!';
}catch (Exception $e){
    $pdo->rollback();
    echo 'Error: ' . $e->getMessage();
    throw $e;
}
