
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOS Atraso</title>
    <style>
      body{
        /* background-color: #056897; */
        margin: 0;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php

    if(isset($css)){
      foreach($css as $row){
        echo '<link rel="stylesheet" type="text/css" href="css/'.$row.'">';
      }
    }
    ?>
    <style>
      .botao{
    width: 300px;
    height: 45px;
    border:0; 
    padding: 11px 21px; 
    vertical-align: middle; 
    background:#D9D9D9; 
    color:black;
    border-radius:6px; 
    font-size: 20px; 
    font-family: Arial, Helvetica, sans-serif;
    text-decoration:none;
    text-align:center;
}
  .texto{
    font-family: Arial, Helvetica, sans-serif;
  }
  .btn{
    width: 300px;
    height: 45px;
    border:0; 
    padding: 11px 21px; 
    vertical-align: middle; 
    background:#48ABE1; 
    color:black;
    border-radius:16px; 
    font-size: 20px; 
    font-family: Arial, Helvetica, sans-serif;
    text-decoration:none;
    text-align:center;
    cursor: pointer;
  }
  .relogio-container{
    display:flex;
   justify-content:center;
  
}
.item{
    margin:6px;
}
.pvd {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 5px;
    border: 100px ;
    background-color: white;
    cursor: pointer;
    border-radius: 300px;
    font-size: 16px;
  }
   
  .pvd img {
    width: 50px;
    height: auto;
    margin-bottom: 5px;
  }
   
  .pvd:hover {
    background-color: #f2f2f2;
  }

      
    </style>
  </head>
  <body>
  
<div class="cont naoimprimir">
    <img src="imagens/png marista 1.png" height="55" width="55" style="margin-top:20px;" class="img">
    <div class="textos">
    <h1 class="txt" style="color:black;">SOS</h1> 
    <h1 class="txt" style="color:white;">ATRASO</h1> 
  </div>
</div>  