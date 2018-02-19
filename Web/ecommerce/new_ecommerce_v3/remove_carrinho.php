<?php

  
  session_start();

  if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  
  require_once('bd.class.php');
  
  $id_comprador = $_SESSION["id_usuario"];
  $id_produto = $_POST['id_produto'];
  //$quantidade = $_POST['quantidade'];
  
  echo $id_comprador;

  $objBD = new bd();
  $link = $objBD->conecta_mysql();

  
  $sql = "DELETE FROM carrinho WHERE id_comprador = $id_comprador AND id_produto = $id_produto ";
  //$sql = "UPDATE carrinho SET quantidade = quantidade - '$quantidade' WHERE id_produto = '$id_produto' AND id_comprador = '$id_comprador'";
  echo $sql;
  
  $resultado_update = mysqli_query($link, $sql);

  if($resultado_update){
    echo 'Ok';
    Header('Location: '.$_SERVER['PHP_SELF']);
  }else{
    echo 'Erro';
  }

  

?>