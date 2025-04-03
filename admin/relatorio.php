   <?php
        include('../config/conexao.php');

        if (!isset($_SESSION['login']['auth'])) {
            header("Location: " . BASE_URL . 'login.php');
        }

        
        $limit = 20;
        $atual = isset($_GET['pagination']) ? $limit * (int)$_GET['pagination'] : 0;
        $sql2 = 'Select * from turmas';
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute();
        $turmas = $stmt2->fetchAll();

        $sqlRelatorio_sql = "SELECT * FROM sosatraso WHERE ";

        if(isset($_POST['data1'])){
            if($_POST['data1'] && $_POST['data2']){
                $sqlRelatorio_sql .= "data BETWEEN '". $_POST['data1']. " 00:00:00' AND '". $_POST['data2']. " 23:59:59'";
            }else{
                $sqlRelatorio_sql .= "data BETWEEN '". $_POST['data1']. " 00:00:00' AND '". $_POST['data1']. " 23:59:59'";
            }
        }

        if(isset($_POST['turma']) && (isset($_POST['data1']) || isset($_POST['data1']))){
            $sqlRelatorio_sql .= " and turma in ('". implode("','", $_POST['turma'])."')";
        }elseif(isset($_POST['turma']) || isset($_GET['turma'])){
            $turma = isset($_POST['turma']) ? $_POST['turma'] : $_GET['turma'];
            $sqlRelatorio_sql .= "turma = '". $turma."'";
        }else{
         $sqlRelatorio_sql .= " 1 = 1";
        }

        $sqlRelatorio =  $sqlRelatorio_sql . " LIMIT $atual, $limit";

        // var_dump($sqlRelatorio);
        
        $stmtRelatorio = $pdo->prepare($sqlRelatorio);
        $stmtRelatorio->execute();
        $dataRelatorio = $stmtRelatorio->fetchAll();

        $totalRelatorio = $pdo->prepare($sqlRelatorio_sql);
        $totalRelatorio->execute();
        $totalPaginas = round($totalRelatorio->rowCount() / $limit);
        
        $css = ['index.css', 'estilo.css'];
        include("include/header.php");
        unset($_SESSION['ALUNO']);
        ?>
<div class="bg-white w-6xl mx-auto p-6 rounded-lg">
<p class="text-2xl mx-auto text-center font-black text-marista mb-6">CONSULTAR ALUNOS</p>
            <form action="relatorio.php" method="post" id="cadastroForm" class="cadastroForm">
            <div class="formulario">
                <div class="data">

                    <input class="border w-ms border-gray-400 rounded-md p-3" type="date" name="data1" id="data1" value="<?php echo isset($_POST['data1']) ? $_POST['data1'] : null; ?>"> até
                    <input class="border w-ms border-gray-400 rounded-md p-3" type="date" name="data2" id="data2" value="<?php echo isset($_POST['data2']) ? $_POST['data2'] : null; ?>">
                </div>
                <div class="data">
                    <select class="border w-md border-gray-400 rounded-md p-3">
                        <option>Selecionar turma...</option>
                        <?php
                        foreach ($turmas as $turma) {
                        ?>
                        <option value="<?php echo $turma['id']; ?>" 
                        <?php 
                        if(isset($_GET['turma']) || isset($_POST['turma'])){
                            $tur = isset($_POST['turma']) ? $_POST['turma'] : $_GET['turma'];
                            echo ($tur == $turma['id']) ? 'selected' : '';
                        }?>><?php echo $turma['turma']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <button  class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg" type="submit">CONSULTAR RELATÓRIO</button>
                </div>
            </div>

        </form>
        <div id="resultados">

            <br><br>

            
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Turma</th>
                        <th>Motivo</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <?php
                if (!empty($dataRelatorio)) {
                ?>
                    <tbody>
                        <?php foreach ($dataRelatorio as $dado) { ?>
                            <tr>
                                <td><?php echo $dado['nome']; ?></td>
                                <td><?php echo $dado['turma']; ?></td>
                                <td><?php echo $dado['motivo']; ?></td>
                                <td><?php
                                    $data = explode(' ', $dado['data']);

                                    echo implode('/', array_reverse(explode('-', $data[0]))) . ' - ' . $data[1];
                                    ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <tr>
                            <td colspan="4">Sem registro na data selecionada!</td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
        </div>
        <div>
      <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs mx-auto" aria-label="Pagination">
        <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
          <span class="sr-only">Previous</span>
          <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
          </svg>
        </a>
        <?php for($i = 1; $i <= $totalPaginas; $i++){ ?>
        <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
        <a href="<?php echo BASE_ADMIN . 'relatorio.php?pagination=' . $i; ?>" aria-current="page" class="<?php echo (isset($_GET["pagination"]) && $_GET["pagination"] == $i) ? 'bg-marista' : ((!isset($_GET["pagination"]) && $i == 1) ? 'bg-marista' : 'bg-marista2') ; ?> relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><?php echo $i; ?></a>
        <?php } ?>
        <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
          <span class="sr-only">Next</span>
          <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
          </svg>
        </a>
      </nav>
     
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

<br>
    <center><a href="gerarpdf.php" target="_blank">
        <button class="bg-marista2 text-white px-6 py-2 rounded-lg drop-shadow-lg mt-6" >GERAR PDF</button></center>
    </a>

    <br>
        </div>
        </body>

        </html>