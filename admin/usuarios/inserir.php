<?php
include(__DIR__ . '/../../config/base.php');
include(__DIR__ . '/../../config/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $permissoes = isset($_POST['permissoes']) ? $_POST['permissoes'] : [];

    if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
        die("Preencha todos os campos obrigatórios.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $permissaoStr = implode(',', $permissoes);

    $sql = "INSERT INTO usuarios (nome, email, setor, senha, permissao) VALUES (:nome, :email, :setor, :senha, :permissao)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':setor', $tipo);
    $stmt->bindParam(':senha', $senhaHash);
    $stmt->bindParam(':permissao', $permissaoStr);

    if ($stmt->execute()) {
        $msg = "Usuário criado com sucesso!";
        header("Location: adicionar_usuario.php?msg=" . urlencode($msg));
        exit();
    } else {
        echo "Erro ao cadastrar usuário.";
    }
} else {
    header('Location: adicionar_usuario.php');
    exit();
}
