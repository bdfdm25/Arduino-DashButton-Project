<?php

  //echo 'Get Test';
  session_start();

  if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  require_once('bd.class.php');
  

  $id_comprador = $_SESSION['id_usuario'];
  
  $objBD = new bd();
  $link = $objBD->conecta_mysql();;

  $sql = "SELECT * FROM wishlist WHERE id_comprador = '$id_comprador' ";
  

  $resultado_consulta = mysqli_query($link, $sql);

  $lista = mysqli_fetch_array($resultado_consulta);

  //echo $lista;

  if($resultado_consulta){

    while($lista = mysqli_fetch_array($resultado_consulta)){
      echo '<div>';
        echo '<a href="#" class="list-group-item"><li class="list-group-item">'.$lista['wishlist_name'].'<span class="badge">'.$lista['wishlist_padrao'].'</span></li></a>';
      echo '</div>';
    } 

  }else {
    echo 'Erro na consulta.';
  }

  /*
  if($resultado_consulta){

    while($lista = mysqli_fetch_array($resultado_consulta)){

      echo '<li class="list-group-item clearfix">';
        echo '<form class="form-inline">';    
          echo '<div class="form-group">';
            echo '<h4 class="list-group-item-heading">'.$lista['wishlist_name'].'</h4>';
            echo '<span>Padrao: '.$lista['wishlist_padrao'].'</span>';
          echo '</div>';
        echo '</form>';
      echo '</li>';
    } 

  }else {
    echo 'Erro na consulta.';
  }
  */
  
  

?>