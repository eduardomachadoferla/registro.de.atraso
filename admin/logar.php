<?php
session_start();
include('../config/conexao.php');

// Pega dados do formulário
$setor = $_POST['setor'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$setor || !$senha) {
    $_SESSION['error'] = "Preencha todos os campos.";
    header("Location: login.php");
    exit;
}

// Busca usuário pelo setor
$sql = 'SELECT * FROM usuarios WHERE setor = :setor LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':setor', $setor);
$stmt->execute();
$usuario = $stmt->fetchObject();

if (!$usuario) {
    $_SESSION['error'] = "Usuário ou senha inválido!";
    header("Location: login.php");
    exit;
}

// Verifica a senha com hash
if (password_verify($senha, $usuario->senha)) {
    $_SESSION['login']['auth'] = true;
    $_SESSION['login']['id'] = $usuario->id;
    $_SESSION['login']['nome'] = $usuario->setor;
    $_SESSION['login']['permissao'] = $usuario->permissao;

    header("Location: index.php"); // Página protegida após login
    exit;
} else {
    $_SESSION['error'] = "Usuário ou senha inválido!";
    header("Location: login.php");
    exit;
}
