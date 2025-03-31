<?php
include('../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
}

include('include/header.php');
?>


<div class="bg-white w-[50%] mx-auto rounded-lg drop-shadow-lg mt-22 px-10 py-10 h-[350px]">
Olá
Educadores
SOS ATRASO é um projeto iniciado em 2024 e finalizado em 2025 por dois grupos de alunos do Marista Escola Social Cascavel. O sistema foi desenvolvido com o objetivo de minimizar erros humanos no registro de informações, como horários, datas, nomes dos estudantes e motivos de atraso. Além disso, o sistema oferece a funcionalidade de agrupar os atrasos por aluno e/ou turma, proporcionando à equipe pedagógica uma visão mais precisa e detalhada. Isso facilita o acompanhamento individualizado dos alunos, permitindo que ações corretivas sejam tomadas de forma mais eficaz.
</div>

