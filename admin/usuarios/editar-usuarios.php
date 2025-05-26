<?php
session_start();

include('../../config/conexao.php');
include('../../config/base.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

include('../include/header.php');

if (!isset($_GET['id'])) {
    echo "<div class='text-red-600 text-center mt-6 font-semibold'>ID do usuário não fornecido.</div>";
    exit();
}

$id = (int)$_GET['id'];

// Buscar dados do usuário
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    echo "<div class='text-red-600 text-center mt-6 font-semibold'>Usuário não encontrado.</div>";
    exit();
}

// Atualizar dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $setor = trim($_POST['setor']);
    $permissao = trim($_POST['permissao']);
    $senha = trim($_POST['senha']);

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
    if ($stmtUpdate->execute($params)) {
        header("Location: lista_usuarios.php");
        exit();
    } else {
        echo "<div class='text-red-600 text-center mt-6 font-semibold'>Erro ao atualizar usuário.</div>";
    }
}
?>

<div class="bg-white max-w-3xl mx-auto p-8 mt-10 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-center text-marista">Editar Usuário</h2>

    <form action="" method="post" class="space-y-6">
        <div>
            <label class="block mb-2 font-medium text-gray-700">Nome:</label>
            <input 
                type="text" 
                name="nome" 
                value="<?= htmlspecialchars($usuario['nome']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
                required
            >
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">E-mail:</label>
            <input 
                type="email" 
                name="email" 
                value="<?= htmlspecialchars($usuario['email']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
                required
            >
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Setor:</label>
            <input 
                type="text" 
                name="setor" 
                value="<?= htmlspecialchars($usuario['setor']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
            >
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Permissão:</label>
            <input 
                type="text" 
                name="permissao" 
                value="<?= htmlspecialchars($usuario['permissao']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
            >
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Senha:</label>
            <input 
                type="password" 
                name="senha" 
                placeholder="Deixe em branco para manter a senha atual"
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
            >
        </div>

        <div class="flex justify-between mt-6">
            <a href="lista_usuarios.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Voltar
            </a>
            <button type="submit" class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg hover:bg-marista2 transition">
                Salvar alterações
            </button>
        </div>
    </form>
</div>
