<?php
session_start();

include('../../config/conexao.php');
include('../../config/base.php');
include('../alunos/inserir.php');


if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

include('../include/header.php');

if (!isset($_GET['matricula'])) {
    echo "<div class='text-red-600 text-center mt-6 font-semibold'>Matrícula do aluno não fornecida.</div>";
    exit();
}

$matricula = $_GET['matricula'];

// Busca os dados do aluno
$sql = "SELECT * FROM alunos WHERE matricula = :matricula";
$stmt = $pdo->prepare($sql);
$stmt->execute([':matricula' => $matricula]);
$aluno = $stmt->fetch();

$sql2 = 'SELECT * FROM turmas';
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$turmas = $stmt2->fetchAll();

if (!$aluno) {
    echo "<div class='text-red-600 text-center mt-6 font-semibold'>Aluno não encontrado.</div>";
    exit();
}
?>

<div class="bg-white max-w-3xl mx-auto p-8 mt-10 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-center text-marista">Editar Aluno</h2>
                   <!-- Precisa ser criado a parte de salar alunos -->
    <form action="./alunos.php" method="post" class="space-y-6">

        <input type="hidden" name="matricula" value="<?= htmlspecialchars($aluno['matricula']) ?>">

        <div>
            <label class="block mb-2 font-medium text-gray-700">Nome:</label>
            <input 
                type="text" 
                name="nome" 
                value="<?= htmlspecialchars($aluno['nome']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
                required
            >
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

        <div>
            <label class="block mb-2 font-medium text-gray-700">Matrícula:</label>
            <input 
                type="text" 
                name="matricula_exibida" 
                value="<?= htmlspecialchars($aluno['matricula']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 bg-gray-100 cursor-not-allowed"
                disabled
            >
        </div>

        <div class="flex justify-between mt-6">
            <a href="./alunos.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Voltar
            </a>
            <input type="submit" value="Salvar alterações"
                   class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg hover:bg-marista2 transition cursor-pointer">
        </div>
        
    </form>
</div>
