<?php 
include('config/base.php');
$css = ['index.css', 'estilo.css'];
include('config/conexao.php');

$sql2 = 'SELECT * FROM alunos';
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$turmas = $stmt2->fetchAll();

$css = ['index.css', 'estilo.css'];
include("header.php"); 
unset($_SESSION['ALUNO']);
?>

<form action="login.php" method="get">    
    <button type="submit" class="pvd">
        <img src="imagens/Lock.png" height="55" width="55" action="login.php">
    </button>
</form>

<center>
    <form action="autorizacao.php" method="post" id="cadastroForm">
        <!-- Campo de pesquisa de aluno -->
        <input type="text" id="nome" name="nome" placeholder="Nome Completo" required class="cadastroForm" onkeyup="buscarNomes()">
        <div id="sugestoes" class="sugestoes"></div>

        <!-- <select id="turma" name="turma" required class="cadastroForm">
            <option value="">Selecionar turma...</option>
            <?php /*foreach ($turmas as $turma) { ?>
                <option value="<?php echo $turma['id']; ?>"><?php echo $turma['turma']; ?></option>
            <?php } */?>
        </select> -->

        <select id="motivo_atraso" name="motivo_atraso" required onchange="mostrarCaixaTexto()" class="cadastroForm">
            <option value="">Motivo do Atraso</option>
            <option value="Perdi o horário">Perdi o horário</option>
            <option value="Chuva">Chuva</option>
            <option value="Imprevisto com o meio de transporte">Imprevisto com o meio de transporte</option>
            <option value="Outro">Outro</option>
        </select>

        <div id="outro_motivo" class="cadastroForm">
            <input type="text" id="outro_text" name="outro_text" placeholder="Especifique o Motivo">
        </div>

        <button style="border-radius:40px; text-align:center;" type="submit">GERAR BILHETE</button>
    </form>
</center>

<script>
function buscarNomes() {
    var nome = document.getElementById("nome").value;
    if (nome.length < 2) {
        document.getElementById("sugestoes").innerHTML = "";
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buscar_alunos.php?nome=" + nome, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("sugestoes").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function selecionarNome(nome) {
    document.getElementById("nome").value = nome;
    document.getElementById("sugestoes").innerHTML = "";
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("outro_motivo").style.display = "none";
    document.getElementById("outro_text").removeAttribute("required");
});

function mostrarCaixaTexto() {
    var selectElement = document.getElementById("motivo_atraso");
    var outroMotivoDiv = document.getElementById("outro_motivo");
    var outroTextInput = document.getElementById("outro_text");

    if (selectElement.value === "Outro") {
        outroMotivoDiv.style.display = "block";
        outroTextInput.setAttribute("required", "required");
    } else {
        outroMotivoDiv.style.display = "none";
        outroTextInput.removeAttribute("required");
    }
}
</script>

<style>
.sugestoes {
   
    max-height: 100px; /* Altura ajustada */
    overflow-y: auto;
    background: rgba(255, 255, 255, 0.8); /* Fundo transparente */
    position: absolute;
    left: 50%; /* Posiciona o início das sugestões no centro */
    transform: translateX(-50%); /* Centraliza as sugestões */
    width: 50%; /* Largura menor para não ocupar toda a tela */
    z-index: 1000; /* Garante que as sugestões fiquem acima de outros elementos */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
    border-radius: 5px; /* Bordas arredondadas */
    margin-top: 5px; /* Distância entre o campo de pesquisa e as sugestões */
    font-size: 12px; /* Menor tamanho da fonte */
}

.sugestoes div {
    padding: 5px; /* Menor padding */
    cursor: pointer;
}

.sugestoes div:hover {
    background-color: #f0f0f0; /* Cor de fundo ao passar o mouse */
}



</style>
<script>
    function buscarNomes() {
    var nome = document.getElementById("nome").value;
    if (nome.length < 2) {
        document.getElementById("sugestoes").innerHTML = "";
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buscar_alunos.php?nome=" + nome, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("sugestoes").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function selecionarNome(nome) {
    document.getElementById("nome").value = nome;
    document.getElementById("sugestoes").innerHTML = "";
}

</script>

</body>
</html>
