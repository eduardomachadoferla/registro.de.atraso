<?php
include('../../config/conexao.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
}

include('../include/header.php');