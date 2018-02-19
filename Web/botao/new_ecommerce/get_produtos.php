<?php

  //session_start();

  //if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  echo "Teste";
  require_once('bd.class.php');
  
  //$id_usuario = $_SESSION["id_usuario"]; 
  
  $objBD = new bd();
  $link = $objBD->conecta_mysql();;

  $sql = "SELECT * FROM produto ORDER BY id_produto DESC ";

  
  echo $sql;

  /*
  $resultado_consulta = mysqli_query($link, $sql);

  if($resultado_consulta){

    while($produto = mysqli_fetch_array($resultado_consulta)){
      
      echo '<a href="#" class="list-group-item">';
      echo '<h4 class="list-group-item-heading">'.$produto['nome_produto'].' <small> - '.$produto['original_price'].'</small></h4>';
      echo '<p class="list-group-item-text">'.$produto['last_price'].'</p>';
      echo '</a>';
    } 

  }else {
    echo 'Erro na consulta.';
  }
  */
  

?>