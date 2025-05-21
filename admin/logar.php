<?php
session_start();
include('../config/conexao.php');

$setor = $_POST['setor'];
$senha = $_POST['senha'];

// Buscar usuário pelo setor
$sql = 'SELECT * FROM usuarios WHERE setor = :setor';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":setor", $setor);
$stmt->execute();
$usuario = $stmt->fetchObject();

if (!$usuario) {
    $_SESSION['error'] = "Usuário ou senha inválido!";
    header("Location: " . BASE_ADMIN . 'login.php');
    exit;
}

// Verificar senha
if (password_verify($senha, $usuario->senha)) {
    $_SESSION['login']['auth'] = true;
    $_SESSION['login']['id'] = $usuario->id;
    $_SESSION['login']['nome'] = $usuario->setor;
    $_SESSION['login']['permissao'] = $usuario->permissao;

    header("Location: " . BASE_ADMIN . 'index.php');
    exit;
} else {
    $_SESSION['error'] = "Usuário ou senha inválido!";
    header("Location: " . BASE_ADMIN . 'login.php');
    exit;
}
?>
