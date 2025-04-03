<?php
include('../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
}

$permissao = ['admin', 'coordenador'];

if (!in_array($_SESSION['login']['permissao'], $permissao)) {
    header("Location: " . BASE_ADMIN . 'index.php');
}

$sql2 = 'SELECT * FROM turmas';
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$turmas = $stmt2->fetchAll();

$sqlRelatorio = "SELECT count(id) as total, turma FROM sosatraso GROUP BY turma";
$stmtRelatorio = $pdo->prepare($sqlRelatorio);
$stmtRelatorio->execute();
$dataRelatorio = $stmtRelatorio->fetchAll();

include("include/header.php");
?>

<div class="bg-white w-6xl mx-auto p-6 rounded-lg">
    <p class="text-2xl mx-auto text-center font-black text-marista">CONSULTAR RELATÓRIO</p>
    <div class="formulario">
        <a href="gerarpdf.php" target="_blank">
            <button class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg mt-6">GERAR PDF</button>
        </a>
    </div>
    <div id="resultados">
        <br><br>
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Total de atrasos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($dataRelatorio)) {
                    foreach ($dataRelatorio as $total) { ?>
                        <tr>
                            <td>
                                <a href="relatorio.php?turma=<?php echo urlencode($total['turma']); ?>" class="text-blue-500 underline">
                                    <?php echo htmlspecialchars($total['turma']); ?>
                                </a>
                            </td>
                            <td><?php echo isset($total['total']) ? $total['total'] : 0; ?></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="2">Sem registro na data selecionada!</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    var expanded = false;
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
</script>
</body>
</html>
