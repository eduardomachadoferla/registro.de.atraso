<?php
include('../../config/base.php');
include('../../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

include('../include/header.php');
?>

<div class="bg-white w-3xl mx-auto p-6 rounded-lg">
    <p class="text-2xl mx-auto text-center font-black text-marista mb-6">ADICIONAR NOVO USUÁRIO</p>

    <form action="inserir.php" method="post" class="max-w-md mx-auto flex flex-col gap-4">
        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
            <input type="text" name="nome" id="nome" required class="border border-gray-400 rounded-md p-3 w-full">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
            <input type="email" name="email" id="email" required class="border border-gray-400 rounded-md p-3 w-full">
        </div>

        <div>
            <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
            <input type="password" name="senha" id="senha" required class="border border-gray-400 rounded-md p-3 w-full">
        </div>

        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuário</label>
            <select name="tipo" id="tipo" required class="border border-gray-400 rounded-md p-3 w-full">
                <option value="">Selecione...</option>
                <option value="admin">Admin</option>
                <option value="educador">Educador</option>
                <option value="coordenacao">Coordenação</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Permissões</label>
            <div class="flex flex-col gap-2 border border-gray-300 p-3 rounded-md">
                <label><input type="checkbox" name="permissoes[]" value="gerenciar_alunos"> Gerenciar Alunos</label>
                <label><input type="checkbox" name="permissoes[]" value="ver_relatorios"> Ver Relatórios</label>
                <label><input type="checkbox" name="permissoes[]" value="editar_turmas"> Editar Turmas</label>
                <label><input type="checkbox" name="permissoes[]" value="administrar_usuarios"> Administrar Usuários</label>
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <a href="./usuarios.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Voltar
            </a>
            <input type="submit" value="Adicionar Usuário"
                class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg hover:bg-marista2 transition cursor-pointer">
        </div>
    </form>
</div>
