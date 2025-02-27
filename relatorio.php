        <?php
        include('config/base.php');
        if (!isset($_SESSION['login']['auth'])) {
            header("Location: " . BASE_URL . 'login.php');
        }
        include('config/conexao.php');

        $sql2 = 'Select * from turmas';
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute();
        $turmas = $stmt2->fetchAll();

        if (isset($_POST['turma'])) {

            if (!empty($_POST['data2'])) {
                $sql1 = 'Select A.turma, count(*) as total, T.turma as turma2 from sosatraso as A inner join turmas as T on (T.id = A.turma) where A.turma in (' . implode(',', $_POST['turma']) . ') and data BETWEEN concat(:data1, " 00:00:00") and concat(:data2, " 23:59:59") group by A.turma';
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->bindParam(':data1', $_POST['data1']);
                $stmt1->bindParam(':data2', $_POST['data2']);

                $sql = 'Select sosatraso.*, T.turma as turma2 from sosatraso inner join turmas as T on (T.id = sosatraso.turma) where sosatraso.turma in (' . implode(',', $_POST['turma']) . ') and sosatraso.data BETWEEN concat(:data1, " 00:00:00") and concat(:data2, " 23:59:59")';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':data1', $_POST['data1']);
                $stmt->bindParam(':data2', $_POST['data2']);
                
                //var_dump($dados . 'as');
                //exit;
            } else {
                $sql1 = 'Select A.turma, count(*) as total, T.turma as turma2 from sosatraso as A inner join turmas as T on (T.id = A.turma) where A.turma in (' . implode(',', $_POST['turma']) . ') and data BETWEEN concat(:data1, " 00:00:00") and concat(:data1, " 23:59:59") group by A.turma';
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->bindParam(':data1', $_POST['data1']);

                $sql = 'Select sosatraso.*, T.turma as turma2 from sosatraso inner join turmas as T on (T.id = sosatraso.turma) where sosatraso.turma in (' . implode(',', $_POST['turma']) . ') and sosatraso.data  BETWEEN concat(:data1, " 00:00:00") and concat(:data1, " 23:59:59")';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':data1', $_POST['data1']);
            }
            $stmt->execute();
            $dados = $stmt->fetchAll();
            $_SESSION['pdf'] = $dados;


            $stmt1->execute();
            $totalAtrasos = $stmt1->fetchAll();
            
            $_SESSION['pdf2'] = $totalAtrasos;
        }

        $css = ['index.css', 'estilo.css'];
        include("header.php");
        unset($_SESSION['ALUNO']);
        ?>

        <style>
            table {
                margin: 0 auto;
                width: 90%;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-family: Arial, sans-serif;
                text-align: left;

            }

            th,
            td {
                padding: 12px;
                border: 1px solid #ddd;
            }

            th {
                background-color: #f2f2f2;
                color: #333;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            tr:hover {
                background-color: #f1f1f1;
            }
        </style>

        <form action="login.php" method="get">
            <button type="submit" class="pvd">
                <img src="imagens/Back Arrow.png" height="50" width="50" action="login.php">
            </button>
        </form>

        <form action="relatorio.php" method="post" id="cadastroForm" class="cadastroForm">
            <div class="formulario">
                <div class="data">

                    <input type="date" name="data1" id="data1" value="<?php echo isset($_POST['data1']) ? $_POST['data1'] : null; ?>"> até
                    <input type="date" name="data2" id="data2" value="<?php echo isset($_POST['data2']) ? $_POST['data2'] : null; ?>">
                </div>
                <div class="multiselect">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select>
                            <option>Selecionar turma...</option>
                        </select>
                        <div class="overSelect"></div>
                    </div>
                    <div id="checkboxes">
                        <?php
                        foreach ($turmas as $turma) {
                        ?>
                            <input type="checkbox" name="turma[]" value="<?php echo $turma['id']; ?>" /><?php echo $turma['turma']; ?></label>
                            <label for="<?php echo $turma['turma']; ?>">
                            <?php
                        }
                            ?>
                    </div>
                </div>
                <div>
                    <center><button style="border-radius:40px; text-align:center;" type="submit">CONSULTAR RELATÓRIO</button></center>
                </div>
            </div>
            <br><br><br>

        </form>
        <div id="resultados">

            <br><br>

            <table class="table">
                <thead>
                    <tr>
                        <th>Turma</th>
                        <th>Total de atrasos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($totalAtrasos)) {
                        foreach ($totalAtrasos as $total) { ?>
                            <tr>
                                <td><?php echo $total['turma2']; ?></td>
                                <td><?php echo $total['total']; ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="2">Sem registro na data selecionada!</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
                if (!empty($dados)) {
                ?>
                    <tbody>
                        <?php foreach ($dados as $dado) { ?>
                            <tr>
                                <td><?php echo $dado['nome']; ?></td>
                                <td><?php echo $dado['turma2']; ?></td>
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
        <button style="border-radius:40px; text-align:center;" >GERAR PDF</button></center>
    </a>

    <br>

        </body>

        </html>