<?php
session_start(); // ESSENCIAL para trabalhar com $_SESSION

include('../../config/conexao.php');

// Redirecionamento se não estiver autenticado
if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

include('../include/header.php');

// Paginação
$limit = 20;
$paginaAtual = isset($_GET['pagination']) ? (int)$_GET['pagination'] : 1;
$offset = ($paginaAtual - 1) * $limit;

// Pegando nome da pesquisa por GET ou POST
$busca_nome = '';
if (isset($_POST['busca_nome'])) {
    $busca_nome = trim($_POST['busca_nome']);
    // Redireciona para GET com o parâmetro
    header("Location: ?pagination=1&busca_nome=" . urlencode($busca_nome));
    exit();
} elseif (isset($_GET['busca_nome'])) {
    $busca_nome = trim($_GET['busca_nome']);
}

// Filtro SQL
$filtro_nome = "";
$params = [];

if (!empty($busca_nome)) {
    $filtro_nome = "WHERE nome LIKE :nome";
    $params[':nome'] = "%" . $busca_nome . "%";
}

// Consulta principal com limite e offset
$sqlRelatorio_sql = "SELECT * FROM sosatraso $filtro_nome ORDER BY data DESC LIMIT $offset, $limit";
$stmtRelatorio = $pdo->prepare($sqlRelatorio_sql);
$stmtRelatorio->execute($params);
$dataRelatorio = $stmtRelatorio->fetchAll();

// Total para paginação
$sqlTotal = "SELECT COUNT(*) as total FROM sosatraso $filtro_nome";
$stmtTotal = $pdo->prepare($sqlTotal);
$stmtTotal->execute($params);
$totalRegistros = $stmtTotal->fetch()['total'];
$totalPaginas = ceil($totalRegistros / $limit);
?>

<!-- HTML -->
<div class="bg-white w-6xl mx-auto p-6 rounded-lg">
    <p class="text-2xl mx-auto text-center font-black text-marista mb-6">GERENCIAMENTO ALUNOS</p>

    <form method="post" class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-center">
        <input type="text" name="busca_nome" placeholder="Buscar aluno pelo nome"
               value="<?php echo htmlspecialchars($busca_nome); ?>"
               class="border border-gray-400 rounded-md p-3 w-64">

        <button type="submit" class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg">Buscar</button>
        <a href="./addalunos.php" class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg">Adicionar Aluno</a>
    </form>

    <div id="resultados">
        <table class="table w-full text-left">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Turma</th>
                    <th>Motivo</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dataRelatorio)) {
                    foreach ($dataRelatorio as $dado) { ?>
                        <tr>
                            <td class="flex items-center gap-2">
                                <a href="./editalunos.php?id=<?php echo $dado['id']; ?>">
                                    <img src="../imagems/edit.svg" alt="editar" class="w-5 h-5 hover:scale-110 transition-transform duration-200">
                                </a>
                                <?php echo htmlspecialchars($dado['nome']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($dado['turma']); ?></td>
                            <td><?php echo htmlspecialchars($dado['motivo']); ?></td>
                            <td>
                                <?php
                                $data = explode(' ', $dado['data']);
                                echo implode('/', array_reverse(explode('-', $data[0]))) . ' - ' . $data[1];
                                ?>
                            </td>
                        </tr>
                <?php }
                } else { ?>
                    <tr><td colspan="4">Nenhum aluno encontrado!</td></tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <div class="mt-8">
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs mx-auto justify-center flex" aria-label="Pagination">
                <?php
                $queryBase = "?busca_nome=" . urlencode($busca_nome) . "&pagination=";
                $prev = $paginaAtual - 1;
                $next = $paginaAtual + 1;
                ?>
                <a href="<?php echo ($prev >= 1) ? $queryBase . $prev : '#'; ?>"
                   class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                    <span class="sr-only">Anterior</span>
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                </a>

                <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <a href="<?php echo $queryBase . $i; ?>"
                       class="<?php echo ($i == $paginaAtual) ? 'bg-marista' : 'bg-marista2'; ?> relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold text-white">
                        <?php echo $i; ?>
                    </a>
                <?php } ?>

                <a href="<?php echo ($next <= $totalPaginas) ? $queryBase . $next : '#'; ?>"
                   class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                    <span class="sr-only">Próxima</span>
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </nav>
        </div>

        <!-- Botão PDF -->
        <div class="text-center mt-8">
            <a href="gerarpdf.php?busca_nome=<?php echo urlencode($busca_nome); ?>" target="_blank">
                <button class="bg-marista2 text-white px-6 py-2 rounded-lg drop-shadow-lg">GERAR PDF</button>
            </a>
        </div>
    </div>
</div>
