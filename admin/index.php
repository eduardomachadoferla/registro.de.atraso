<?php
include('../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
}

include('include/header.php');
?>


<div class="bg-white w-full max-w-2xl mx-auto rounded-xl shadow-xl mt-16 p-10 text-gray-800 font-serif leading-7 transition-transform duration-300 hover:scale-105">
  <h1 class="text-3xl font-semibold text-gray-900 uppercase tracking-wide text-center">Olá, Educadores</h1>
  <p class="mt-5 text-base font-light">
    <strong>SOS ATRASO</strong> é um projeto iniciado em 2024 e finalizado em 2025 por dois grupos de alunos do Marista Escola Social Cascavel. O sistema foi desenvolvido para minimizar erros no registro de informações, como horários, datas, nomes dos estudantes e motivos de atraso. 
  </p>
  <p class="mt-4 text-base font-light">
    Além disso, o sistema agrupa os atrasos por aluno e/ou turma, proporcionando à equipe pedagógica uma visão mais detalhada. Isso facilita o acompanhamento individualizado dos alunos e permite que ações corretivas sejam tomadas com mais eficiência.
  </p>
</div>




