<?php
session_start();
include('../../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

// Verifica se o ID foi enviado via POST
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo "ID do usuário não informado.";
    exit();
}

$id = (int)$_POST['id']; // converte para inteiro para segurança

// Prepare a exclusão no banco
$sql = "DELETE FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([':id' => $id])) {
    // Exclusão com sucesso, redirecionar com mensagem de sucesso
    $_SESSION['mensagem'] = "Usuário apagado com sucesso!";
    header("Location: listar-usuarios.php"); // substitua pelo caminho correto
    exit();
} else {
    echo "Erro ao apagar o usuário.";
}
?>
