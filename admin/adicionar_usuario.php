<?php
include(__DIR__ . '/../config/base.php');
include(__DIR__ . '/../config/conexao.php'); // cria $pdo

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

$msg = '';
$nome = $email = $tipo = '';
$permissoes = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $permissoes = isset($_POST['permissoes']) ? $_POST['permissoes'] : [];

    if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
        $msg = "Preencha todos os campos obrigatórios.";
    } else {
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
            // Limpar variáveis para limpar o formulário
            $nome = $email = $tipo = '';
            $permissoes = [];
        } else {
            $msg = "Erro ao cadastrar usuário.";
        }
    }
}

include(__DIR__ . '/include/header.php');
?>

<div class="bg-white w-3xl mx-auto p-6 rounded-lg">

    <?php if ($msg): ?>
        <div class="max-w-md mx-auto mb-4 p-3 border-2 rounded-md
            <?= strpos($msg, 'sucesso') !== false ? 'border-green-500 bg-green-50 text-green-700' : 'border-red-500 bg-red-50 text-red-700' ?>
            text-center text-xl font-bold shadow-sm">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <p class="text-2xl mx-auto text-center font-black text-marista mb-6">ADICIONAR NOVO USUÁRIO</p>

    <form action="" method="post" class="max-w-md mx-auto flex flex-col gap-4">
        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
            <input type="text" name="nome" id="nome" required class="border border-gray-400 rounded-md p-3 w-full" value="<?= htmlspecialchars($nome) ?>">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
            <input type="email" name="email" id="email" required class="border border-gray-400 rounded-md p-3 w-full" value="<?= htmlspecialchars($email) ?>">
        </div>

        <div>
            <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
            <input type="password" name="senha" id="senha" required class="border border-gray-400 rounded-md p-3 w-full" value="">
        </div>

        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuário</label>
            <select name="tipo" id="tipo" required class="border border-gray-400 rounded-md p-3 w-full">
                <option value="">Selecione...</option>
                <option value="admin" <?= $tipo === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="educador" <?= $tipo === 'educador' ? 'selected' : '' ?>>Educador</option>
                <option value="coordenacao" <?= $tipo === 'coordenacao' ? 'selected' : '' ?>>Coordenação</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Permissões</label>
            <div class="flex flex-col gap-2 border border-gray-300 p-3 rounded-md">
                <label><input type="checkbox" name="permissoes[]" value="gerenciar_alunos" <?= in_array('gerenciar_alunos', $permissoes) ? 'checked' : '' ?>> Gerenciar Alunos</label>
                <label><input type="checkbox" name="permissoes[]" value="ver_relatorios" <?= in_array('ver_relatorios', $permissoes) ? 'checked' : '' ?>> Ver Relatórios</label>
                <label><input type="checkbox" name="permissoes[]" value="editar_turmas" <?= in_array('editar_turmas', $permissoes) ? 'checked' : '' ?>> Editar Turmas</label>
                <label><input type="checkbox" name="permissoes[]" value="administrar_usuarios" <?= in_array('administrar_usuarios', $permissoes) ? 'checked' : '' ?>> Administrar Usuários</label>
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <input type="submit" value="Adicionar Usuário"
                class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg hover:bg-marista2 transition cursor-pointer">
        </div>
    </form>
</div>
