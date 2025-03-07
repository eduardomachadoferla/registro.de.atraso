<?php
include('config/base.php');
include('config/conexao.php');
$css = ['estilo.css'];
include("header.php");

// Consultar as turmas da tabela 'sosatraso'
$sql2 = 'SELECT DISTINCT turma FROM sosatraso';
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$turmas = $stmt2->fetchAll(PDO::FETCH_OBJ); // Pega todas as turmas da tabela 'sosatraso'

// Se a turma não foi definida, pegar a turma do formulário enviado
if (isset($_POST['nome'])) {
    $_SESSION['ALUNO']['NOME'] = $_POST['nome'];

    // Buscar a turma do aluno na tabela 'alunos'
    $sqlAluno = 'SELECT turma FROM alunos WHERE nome = :nome LIMIT 1';
    $stmtAluno = $pdo->prepare($sqlAluno);
    $stmtAluno->bindParam(':nome', $_SESSION['ALUNO']['NOME']);
    $stmtAluno->execute();
    $aluno = $stmtAluno->fetch(PDO::FETCH_ASSOC);

    // Se encontrar o aluno, define a turma correta
    if ($aluno) {
        $_SESSION['ALUNO']['TURMA'] = $aluno['turma'];
    } else {
        $_SESSION['ALUNO']['TURMA'] = 'Turma não encontrada'; // Caso o nome não esteja cadastrado
    }

    $_SESSION['ALUNO']['MOTIVO_ATRASO']['OUTRO_TEXT'] = $_POST['motivo_atraso'] . (!empty($_POST['outro_text']) ? ': ' . $_POST['outro_text'] : '');
    $_SESSION['ALUNO']['HORA'] = date('Y-m-d H:i:s');
}

// Inserir dados na tabela 'sosatraso'
$name = utf8_decode($_SESSION['ALUNO']['NOME']);
$description = utf8_decode($_SESSION['ALUNO']['MOTIVO_ATRASO']['OUTRO_TEXT']);
$sql = 'insert into sosatraso (nome, turma, motivo, data) values (:nome, :turma, :motivo, :data)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nome', $name);
$stmt->bindParam(':turma', $_SESSION['ALUNO']['TURMA']); // Nome da turma
$stmt->bindParam(':motivo', $description);
$stmt->bindParam(':data', $_SESSION['ALUNO']['HORA']);
$stmt->execute();
?>

<br>
<div>


<div class="print">
    <div class="texto">
        <h3>
            <center>AUTORIZAÇÃO DE ENTRADA</center>
        </h3>
    </div>
    <div class="texto">
        <p>
            <center>NOME: <span class="under">&nbsp;<?php echo  $_SESSION['ALUNO']['NOME']; ?>&nbsp;</span> 
            TURMA: <span class="under">&nbsp;<?php echo $_SESSION['ALUNO']['TURMA']; ?>&nbsp;</span></center>
        </p>
    </div>
    <div class="texto">
        <p>
            <center>MOTIVO DO ATRASO: <span class="under">&nbsp;<?php echo $_SESSION['ALUNO']['MOTIVO_ATRASO']['OUTRO_TEXT']; ?>&nbsp;</span></center>
        </p>
    </div>
</div>

<!-- O restante do código de relógio, etc., continua o mesmo -->
<center>
    <script>
        function atualizarRelogio() {
            const agora = new Date();
            const horas = String(agora.getHours()).padStart(2, '0');
            const minutos = String(agora.getMinutes()).padStart(2, '0');
            const segundos = String(agora.getSeconds()).padStart(2, '0');
            const horarioFormatado = `${horas}:${minutos}:${segundos}`;
            document.getElementById('relogio').textContent = horarioFormatado;
        }

        function atualizarData() {
            const agora = new Date();
            const dia = String(agora.getDate()).padStart(2, '0');
            const mes = String(agora.getMonth() + 1).padStart(2, '0');
            const ano = agora.getFullYear();
            const dataFormatada = `${dia}/${mes}/${ano}`;
            document.getElementById('data').textContent = dataFormatada;
        }

        setInterval(atualizarRelogio, 1000);
        window.onload = function() {
            atualizarRelogio();
            atualizarData();
        };
    </script>
</center>
<center>
    </head>

    <body>
        <div class="relogio-container">
            <!-- Ícone e Data -->
            <div class="item">
                <img class="icone" src="imagens/Group 6.png" height="20" width="20">
                <span class="texto" id="data">00/00/0000</span>
            </div>

            <!-- Ícone e Hora -->
            <div class="item">
                <img class="icone" src="imagens/­ƒªå icon _clock_.png" height="20" width="20">
                <span class="texto" id="relogio">00:00:00</span>
            </div>
        </div>
</center>
</head>

<body>
    <div class="relogio-container">
        <span class="icone" src=""></span>
        <div class="texto" id="data"></div>
        <br>
        <span class="icone" src=""></span>
        <div class="texto" id="relogio"></div>
    </div>
    </center>
    <br>

    <center>
        <form id="cadastroForm">

            <button type="button" id="btnimprimir" style="padding: 10px 20px; background-color: #48ABE1; color: black; border: none; border-radius: 40px; cursor: pointer;">IMPRIMIR BILHETE</button>
        </form>
    </center>

    <br>

    <script>
        document.getElementById("btnimprimir").addEventListener("click", function(event) {
            event.preventDefault();

            window.onafterprint = function() {
                window.location.href = "index.php";
            };

            window.print();
        });
    </script>
</div>


</body>