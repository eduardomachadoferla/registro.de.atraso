<?php
include(__DIR__ . '/../../config/base.php');
include(__DIR__ . '/../../config/conexao.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$permissoes = isset($_POST['permissoes']) ? implode(',', $_POST['permissoes']) : '';

if ($nome && $email && $senha && $tipo) {
    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se e-mail já existe
    $verifica = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $verifica->execute([$email]);
    if ($verifica->fetchColumn() > 0) {
        echo "Erro: E-mail já cadastrado!";
        exit();
    }

    // Insere novo usuário
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo, permissoes) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senha_hashed, $tipo, $permissoes]);

    header("Location: usuarios.php?msg=usuario_adicionado");
    exit();
} else {
    echo "Preencha todos os campos obrigatórios.";
}
