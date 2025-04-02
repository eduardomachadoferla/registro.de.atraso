<?php 

include('config/base.php');
include('config/conexao.php');
include('includes/header.php');

$sql2 = 'SELECT * FROM alunos';
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$turmas = $stmt2->fetchAll();

$css = ['geral.css', 'index.css', 'estilo.css'];

unset($_SESSION['ALUNO']);
?>

    <div class="bg-white w-[40%] mx-auto rounded-lg drop-shadow-lg mt-22 px-10 py-10 h-[350px]">
   

    <form action="autorizacao.php" method="post" id="cadastroForm" class="flex flex-col justify-center items-center center mt-10">
        <!-- Campo de pesquisa de aluno -->
        <div class="w-md pesquisa">
        <input class="border w-md border-gray-400 rounded-md p-3 mb-5" type="text" id="nome" name="nome" placeholder="Nome Completo" required class="cadastroForm" onkeyup="buscarNomes()">
        <input type="hidden" id="turma" name="turma">
        <div id="sugestoes" class="sugestoes"></div>
        </div>
        

        <select  class="border w-md border-gray-400 rounded-md p-3 mb-5" id="motivo_atraso" name="motivo_atraso" required onchange="mostrarCaixaTexto()" class="cadastroForm">
            <option value="">Motivo do Atraso</option>
            <option value="Perdi o horário">Perdi o horário</option>
            <option value="Chuva">Chuva</option>
            <option value="Imprevisto com o meio de transporte">Imprevisto com o meio de transporte</option>
            <option value="Outro">Outro</option>
        </select>

        <div id="outro_motivo" class="cadastroForm">
            <input type="text" id="outro_text" name="outro_text" placeholder="Especifique o Motivo">
        </div>
        <div class="text-center">
        <button class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg mt-6"  type="submit">GERAR BILHETE</button>
        </div>
      
    </form>
</div>

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
    var words = nome.split("|");
    document.getElementById("nome").value = words[0];
    document.getElementById("turma").value = words[1];
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
</body>
</html>
