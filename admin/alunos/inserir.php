<?php
include('../../config/base.php');
include('../../config/conexao.php');

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = $_POST['matricula'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $turma = $_POST['turma'] ?? '';

    $sql = "INSERT INTO alunos (matricula, nome, turma) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$matricula, $nome, $turma])) {
        header("Location: alunos.php?sucesso=1");
        exit;
    } else {
        header("Location: alunos.php?erro=1");
        exit;
    }
}
?>
<script>
let formAlterado = false;

// Marcar quando algo for alterado
document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('input', () => {
        formAlterado = true;
    });
});

// Interceptar clique no botão "Voltar"
const voltarBtn = document.querySelector('a[href="./alunos.php"]');
voltarBtn.addEventListener('click', function (e) {
    if (formAlterado) {
        const confirmar = confirm("Você tem alterações não salvas. Deseja sair sem salvar?");
        if (!confirmar) {
            e.preventDefault(); // Cancela o clique
        }
    }
});
</script>
