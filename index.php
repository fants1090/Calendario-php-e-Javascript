<?php
  /*vamos fazer de conta que estou puxando os recursos do projeto aqui e dando o 
  include aqui, no caso esse -->include 'calendario.php'; estava la no dentro do 
  <body> junto com o montacalendario();*/
  include 'calendario.php';
  include 'conexao.php';
  $info = array(
    'tabela' => 'eventos',
    'data' => 'data',
    'titulo' => 'titulo', 
    'link' => 'link',
  );
  /*echo '<pre>';
  print_r(montaEventos($info));
  die;*/
?>

<!DOCTYPE HTML>
<html lang="pt-BR">
  <head>
    <meta charset=UTF-8>
    <title>Calendário de Eventos</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
  </head>

  <body> 
    <div class="calendario">
      <?php 
        $eventos = montaEventos($info);
        montaCalendario($eventos);
      ?>
      <div class="legends">
        <span class="legenda"><span class="blue"></span> Eventos</span>
        <span class="legenda"><span class="red"></span> Hoje</span>
      </div>
    </div>

      <script type="text/javascript" src="js/jquery.js"></script>
      <script type="text/javascript" src="js/functions.js"></script>
  </body>
</html>