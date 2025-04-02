<!doctype html> 
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL;?>css/geral.css">
    <style type="text/tailwindcss">
      @theme {
        --color-marista:rgb(6, 54, 100);
        --color-marista2:rgb(28, 149, 206);
      }
    </style>
    <link rel="stylesheet" href="<?php echo BASE_ADMIN; ?>css/geral.css">
  </head>
  <body class="bg-marista">
<?php
include('topo.php');
