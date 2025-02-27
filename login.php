<?php
include('config/base.php');
$css = ['index.css', 'estilo.css'];
include("header.php");
unset($_SESSION['ALUNO']);






?>

<form action="index.php" method="get">
    <button type="submit" class="pvd">
        <img src="imagens/Back Arrow.png" height="50" width="50" action="index.php">
    </button>
</form>

</head>

<body>

    <h3 style="text-align:center;">ACESSO RESTRITO</h3>

    
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="error">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
            ?>
        </div>
    <?php } ?>
    <center>
        <form action="logar.php" method="post" id="cadastroForm" class="cadastroForm">
            <input type="nome" id="setor" name="setor" placeholder="Setor" required>
    </center>

    <center>
        <form action="/submit-form" method="POST">
            <input type="password" id="senha" name="senha" placeholder="Senha" class="cadastroForm" required>
    </center>
    <br>
    <center><button style="border-radius:40px; text-align:center;" type="submit">ACESSAR RELATÓRIO</button></center>
    </form>
    <div id="resultados"></div>
    <style>
        /* Estilos gerais para o formulário */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

/* Estilo para o título */
h3 {
    color: #333;
    font-size: 24px;
    margin-top: 50px;
}

/* Estilo para o botão de voltar */
.pvd {
    background-color: transparent;
    border: none;
    cursor: pointer;
}

.pvd img {
    margin-top: 20px;
    transition: transform 0.3s;
}

.pvd img:hover {
    transform: scale(1.1);
}

/* Estilo para o formulário */
form {
    margin-top: 20px;
}

/* Estilo para os campos de entrada */
input[type="nome"],
input[type="password"] {
    padding: 10px;
    width: 250px;
    margin: 10px 0;
    border-radius: 30px;
    border: 1px solid #ddd;
    font-size: 16px;
    text-align: center;
}

input[type="nome"]:focus,
input[type="password"]:focus {
    border-color: #48abe1;
    outline: none;
}

/* Estilo para o botão de enviar */
button {
    background-color: #48abe1;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 40px;
    cursor: pointer;
    width: 200px;
    margin-top: 20px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #3589b5;
}

/* Estilo para a mensagem de erro */
.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 10px;
    width: 80%;
    margin: 20px auto;
    text-align: center;
    border-radius: 5px;
}

/* Centraliza o conteúdo */
.center {
    text-align: center;
}

/* Estilo para o input quando está vazio ou com erro */
input:invalid {
    border-color: #f44336;
}

input:valid {
    border-color: #4CAF50;
}

    </style>