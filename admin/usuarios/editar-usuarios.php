<?php
session_start();
include('../../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID do usuário não informado.";
    exit();
}

$id = (int) $_GET['id'];

// Buscar dados do usuário no banco
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit();
}

// Atualizar dados se o formulário for enviado
if (isset($_POST['editar'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $setor = trim($_POST['setor']);
    $permissao = trim($_POST['permissao']);
    $senha = trim($_POST['senha']);

    // Você pode colocar validações aqui

    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE usuarios SET nome = :nome, email = :email, setor = :setor, permissao = :permissao, senha = :senha WHERE id = :id";
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':setor' => $setor,
            ':permissao' => $permissao,
            ':senha' => $senhaHash,
            ':id' => $id,
        ];
    } else {
        $sqlUpdate = "UPDATE usuarios SET nome = :nome, email = :email, setor = :setor, permissao = :permissao WHERE id = :id";
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':setor' => $setor,
            ':permissao' => $permissao,
            ':id' => $id,
        ];
    }

    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $resultado = $stmtUpdate->execute($params);

    if ($resultado) {
        header("Location: lista_usuarios.php"); // Ajuste conforme seu arquivo real de lista
        exit();
    } else {
        echo "<p style='color:red;'>Erro ao atualizar usuário.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Editar Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 40px 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #444;
        }
        form {
            background: #fff;
            max-width: 480px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 9px 12px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
            box-sizing: border-box;
        }
        small {
            font-weight: normal;
            color: #777;
        }
        button {
            margin-top: 25px;
            width: 100%;
            background-color: #4A90E2;
            border: none;
            padding: 12px 0;
            color: white;
            font-size: 17px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #357ABD;
        }
    </style>
</head>
<body>

<h2>Editar Usuário: <?php echo htmlspecialchars($usuario['nome']); ?></h2>

<form action="editar-usuarios.php?id=<?php echo $id; ?>" method="post">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

    <label for="setor">Setor:</label>
    <input type="text" id="setor" name="setor" value="<?php echo htmlspecialchars($usuario['setor']); ?>">

    <label for="permissao">Permissão:</label>
    <input type="text" id="permissao" name="permissao" value="<?php echo htmlspecialchars($usuario['permissao']); ?>">

    <label for="senha">Senha: <small>(Deixe vazio para manter a senha atual)</small></label>
    <input type="password" id="senha" name="senha" placeholder="Nova senha">

    <button type="submit" name="editar">Salvar alterações</button>
</form>

</body>
</html>
