<?php
$senha = 'admin'; // Substitua pela senha desejada
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
?>
