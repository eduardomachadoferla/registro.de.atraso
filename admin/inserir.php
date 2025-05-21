<?php
include(__DIR__ . '/../config/base.php');
include(__DIR__ . '/../config/conexao.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$setor = $_POST['setor'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($setor && $senha) {
    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se setor já existe
    $verifica = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE setor = ?");
    $verifica->execute([$setor]);
    if ($verifica->fetchColumn() > 0) {
        echo "Erro: Setor já cadastrado!";
        exit();
    }

    // Insere novo usuário
    $sql = "INSERT INTO usuarios (setor, senha) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$setor, $senha_hashed]);

    header("Location: usuarios.php?msg=usuario_adicionado");
    exit();
} else {
    echo "Preencha todos os campos obrigatórios.";
}
