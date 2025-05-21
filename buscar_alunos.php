<?php
include('config/conexao.php');

if (isset($_GET['nome'])) {
    $nome = $_GET['nome'] . "%"; // Busca nomes que começam com o texto digitado
    $sql = "SELECT nome, turma FROM alunos WHERE nome LIKE :nome LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($alunos as $aluno) {
        echo "<div onclick=\"selecionarNome('" . $aluno['nome'] . "|" . $aluno['turma'] ."')\">" . $aluno['nome'] . "</div>";
    }
}
?>
