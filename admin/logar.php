<?php
include('../config/conexao.php');

$usuario = $_POST['setor'];
$sql = 'Select * from usuarios where setor = :setor';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":setor", $usuario);
$stmt->execute();
$usuario = $stmt->fetchObject();

if(empty($usuario)){
    $_SESSION['error'] = "Usuário ou senha inválido!";
    header("Location: ". BASE_ADMIN . 'login.php');
    exit;
}

if (password_verify($_POST['senha'], $usuario->senha)) {
    $_SESSION['login']['auth'] = true;
    $_SESSION['login']['id'] = $usuario->id;
    $_SESSION['login']['nome'] = $usuario->setor;
    $_SESSION['login']['permissao'] = $usuario->permissao;
    
    header("Location: ". BASE_ADMIN . 'index.php');
}else{
    $_SESSION['error'] = "Usuário ou senha inválido!";
    header("Location: ". BASE_ADMIN . 'login.php');
}
