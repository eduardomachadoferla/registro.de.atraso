<?php
session_start();

include('../../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

include('../include/header.php');


if (!isset($_GET['matricula'])) {
    echo "Matrícula do aluno não fornecida.";
    exit();
}

$matricula = $_GET['matricula'];

// Busca os dados do aluno
$sql = "SELECT * FROM alunos WHERE matricula = :matricula";
$stmt = $pdo->prepare($sql);
$stmt->execute([':matricula' => $matricula]);
$aluno = $stmt->fetch();

$sql2 = 'Select * from turmas';
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$turmas = $stmt2->fetchAll();

if (!$aluno) {
    echo "Aluno não encontrado.";
    exit();
}
?>

<div class="bg-white w-6xl mx-auto p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-marista">Editar Aluno</h2>

    <form action="atualizaaluno.php" method="post" class="flex flex-col gap-4 max-w-lg mx-auto">
        
        <input type="hidden" name="matricula" value="<?= htmlspecialchars($aluno['matricula']) ?>">

        <label class="flex flex-col">
            Nome:
            <input type="text" name="nome" value="<?= htmlspecialchars($aluno['nome']) ?>" class="border rounded p-2">
        </label>

        <label class="flex flex-col">
        <select class="border w-md border-gray-400 rounded-md p-3" name="turma" id="turma">
                        <option value="">Selecionar turma...</option>
                        <?php
                        foreach ($turmas as $turma) {
                        ?>
                        <option value="<?php echo $turma['id']; ?>" 
                        <?php echo ($turma['id'] == $aluno['turma']) ? 'selected' : '';
                        ?>><?php echo $turma['turma']; ?></option>
                       <?php } ?>
                    </select>
        </label>
        <label class="flex flex-col">
            Matricula:
            <input type="text" name="turma" value="<?= htmlspecialchars($aluno['matricula']) ?>" class="border rounded p-2">
        </label>
        <button type="submit" class="bg-marista text-white px-4 py-2 rounded">Salvar Alterações</button>
    </form>
</div>

<?php include('../include/footer.php'); ?>
