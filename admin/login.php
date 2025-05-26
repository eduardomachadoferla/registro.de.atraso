<?php
session_start();
include('../config/conexao.php');

$css = ['geral.css', 'index.css', 'estilo.css'];
include('../includes/header.php');
?>

</head>
<body>
<div class="bg-white w-[40%] mx-auto rounded-lg drop-shadow-lg mt-22 px-10 py-10 h-[350px]">
    <h3 style="text-align:center;">ACESSO RESTRITO</h3>
    

    <?php if (isset($_SESSION['error'])) { ?>
        <div class="error" style="color:red; text-align:center;">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
            ?>
        </div>
    <?php } ?>

    <form action="logar.php" method="post" id="cadastroForm" class="cadastroForm" style="text-align:center;">
        <input type="text" class="border w-md border-gray-400 rounded-md p-3 mb-5" id="setor" name="setor" placeholder="Setor" required>

        <input type="password" class="border w-md border-gray-400 rounded-md p-3 mb-5" id="senha" name="senha" placeholder="Senha" required>

        <br>

        <a href="<?php echo BASE_URL; ?>" class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg mr-6 ml-10">Voltar a Home</a>
        <button class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg mt-6" type="submit">ACESSAR RELATÓRIO</button>
    </form>
    
</div>
</body>
</html>
