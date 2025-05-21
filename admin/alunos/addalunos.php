<?php
include('../../config/base.php');
include('../../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

// Buscar turmas no banco de dados
$sqlTurmas = "SELECT id, turma FROM turmas ORDER BY turma ASC";
$stmtTurmas = $pdo->prepare($sqlTurmas);
$stmtTurmas->execute();
$turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);

// Define valor padrão para turma selecionada
$aluno['turma'] = $aluno['turma'] ?? null;

include('../include/header.php');
?>

<div class="bg-white w-3xl mx-auto p-6 rounded-lg">
    <p class="text-2xl mx-auto text-center font-black text-marista mb-6">ADICIONAR NOVO ALUNO</p>

    <form action="inserir.php" method="post" class="max-w-md mx-auto flex flex-col gap-4">
        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
            <input type="text" name="nome" id="nome" required
                   class="border border-gray-400 rounded-md p-3 w-full">
        </div>
         <div>
            <label for="matricula" class="block text-sm font-medium text-gray-700 mb-1">matricula</label>
            <input type="text" name="matricula" id="matricula" required
                   class="border border-gray-400 rounded-md p-3 w-full">
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Turma:</label>
            <select 
                name="turma" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
                required
            >
                <option value="">Selecionar turma...</option>
                <?php foreach ($turmas as $turma): ?>
                    <option value="<?= $turma['id']; ?>" <?= ($turma['id'] == $aluno['turma']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($turma['turma']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex justify-between mt-6">
            <a href="./alunos.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Voltar
            </a>
            <input type="submit" value="Adicionar Aluno"
                   class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg hover:bg-marista2 transition cursor-pointer">
        </div>
    </form>
</div>
