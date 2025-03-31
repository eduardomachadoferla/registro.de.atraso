<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOS Atraso</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap">
    <?php

    if(isset($css)){
      foreach($css as $row){
        echo '<link rel="stylesheet" type="text/css" href="css/'.$row.'">';
      }
    }
    ?>
  </head>
<body>
  <div class="cont img">
    <img src="<?php echo BASE_URL; ?>imagens/logo-escolas-sociais.png"  width="250" style="margin-top:20px; position: relative; left: 20px;" class="img">
    <div class="textos txt" >
      <span style="color:black;">SOS</span> 
      <span style="color:white;">ATRASO</span> 
    </div>
  </div>  