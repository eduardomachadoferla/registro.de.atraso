<?php
include('../../config/base.php');
include('../../config/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $turma = $_POST['turma'] ?? '';
    $matriculaInput = $_POST['matricula'] ?? '';

    if ($nome && $turma) {
        if (!empty($matriculaInput)) {
            // Usa a matrícula digitada pelo usuário
            $matricula = $matriculaInput;
        } else {
            // Gera matrícula automática
            $ano = date('Y');
            $prefixo = 'ALU' . $ano;

            $stmt = $pdo->prepare("SELECT matricula FROM alunos WHERE matricula LIKE :prefixo ORDER BY matricula DESC LIMIT 1");
            $stmt->execute(['prefixo' => "$prefixo%"]);
            $ultimo = $stmt->fetchColumn();

            if ($ultimo) {
                $numero = intval(substr($ultimo, -4)) + 1;
            } else {
                $numero = 1;
            }

            $matricula = $prefixo . str_pad($numero, 4, '0', STR_PAD_LEFT);
        }

        // Insere no banco
        $stmt = $pdo->prepare("INSERT INTO alunos (matricula, nome, turma) VALUES (:matricula, :nome, :turma)");
        $stmt->execute([
            'matricula' => $matricula,
            'nome' => $nome,
            'turma' => $turma
        ]);

        header('Location: alunos.php');
        exit();
    } else {
        echo "Nome e turma são obrigatórios.";
    }
}
?>
