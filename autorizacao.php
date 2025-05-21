<?php
include('config/conexao.php');

$sql2 = 'Select * from turmas where id = :id';
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindParam(':id', $_POST['turma']);
$stmt2->execute();
$turma = $stmt2->fetchObject();

if (isset($_POST['nome'])) {
    $_SESSION['ALUNO']['NOME'] = $_POST['nome'];
    $_SESSION['ALUNO']['TURMA'] = $turma->turma;
    $_SESSION['ALUNO']['MOTIVO_ATRASO']['OUTRO_TEXT'] = $_POST['motivo_atraso'] . (!empty($_POST['outro_text']) ?  ': ' . $_POST['outro_text'] : '');
    $_SESSION['ALUNO']['HORA'] = date('Y-m-d H:i:s');
}

$sql = 'insert into sosatraso (nome, turma, motivo, data) values (:nome, :turma, :motivo, :data)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nome', $_SESSION['ALUNO']['NOME']);
$stmt->bindParam(':turma', $turma->id);
$stmt->bindParam(':motivo', $_SESSION['ALUNO']['MOTIVO_ATRASO']['OUTRO_TEXT']);
$stmt->bindParam(':data', $_SESSION['ALUNO']['HORA']);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/autorizacao.css">
</head>
<body>
    <div class="print">
        <div class="texto">
            <h3>AUTORIZAÇÃO DE ENTRADA</h3>
        </div>
        <div class="texto">
            <b>NOME:</b> &nbsp;<?php echo  $_SESSION['ALUNO']['NOME']; ?>&nbsp;
        </div>
        <div class="texto">
            <b>TURMA:</b> &nbsp;<?php echo $_SESSION['ALUNO']['TURMA']; ?>&nbsp
        </div>
        <div class="texto">
            <b>MOTIVO DO ATRASO:</b> &nbsp;<?php echo $_SESSION['ALUNO']['MOTIVO_ATRASO']['OUTRO_TEXT']; ?>&nbsp;
        </div>
    </div>
        <div class="relogio-container">
            <!-- Ícone e Data -->
            <div class="item">
                <?php 
                $date = strtotime($_SESSION['ALUNO']['HORA']);
                $duracao = '00:04:00';
                list($h, $m, $s) = explode(':', $duracao);
                ?>
                <img class="icone" src="imagens/Group 6.png" height="20" width="20">&nbsp;
                <span class="texto" id="data"><?php echo date('d/m/Y',$date); ?></span>&nbsp&nbsp

                <img class="icone" src="imagens/icon _clock_.png" height="20" width="20">&nbsp;
                <span class="texto" id="relogio"><?php echo date("H:i:s", $date); ?></span>
                &nbsp;&nbsp;
                <img class="icone" src="imagens/icon _clock_.png" height="20" width="20">&nbsp;
                <span class="texto" id="relogio"><?php echo date('H:i:s', $date + $s + ($m * 60) + ($h * 3600)); ?></span>
            </div>
        </div>
    </div>

    <script>
        // document.getElementById("btnimprimir").addEventListener("click", function(event) {
            // event.preventDefault();
        document.addEventListener("DOMContentLoaded", () => {

            window.onafterprint = function() {
                window.location.href = "index.php";
            };

            window.print();
        });
    </script>
</body>
</html>