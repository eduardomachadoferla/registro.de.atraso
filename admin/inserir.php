<?php
include('../../config/base.php');
include('../../config/conexao.php');

// Receber dados do formulário
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$tipo = $_POST['tipo'] ?? '';
$permissoes = isset($_POST['permissoes']) ? implode(',', $_POST['permissoes']) : '';

if ($nome && $email && $senha && $tipo) {
    // Verifica se e-mail já existe
    $verifica = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $verifica->execute([$email]);
    if ($verifica->fetchColumn() > 0) {
        echo "Erro: E-mail já cadastrado!";
        exit();
    }

    // Inserir no banco
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo, permissoes) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senha, $tipo, $permissoes]);

    header("Location: usuarios.php?msg=usuario_adicionado");
    exit();
} else {
    echo "Preencha todos os campos obrigatórios.";
}
