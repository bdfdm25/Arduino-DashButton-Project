<?php

  
  session_start();

  if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  $id_comprador = $_SESSION["id_usuario"];
  $wishlist_name = $_POST['text_nome'];
  $wishlist_padrao = isset($_POST['lista_padrao']);


  require_once('bd.class.php');
  
 

  
  $objBD = new bd();
  $link = $objBD->conecta_mysql();;

  $sql = "INSERT INTO wishlist(wishlist_padrao, wishlist_name, id_comprador) VALUES('$wishlist_padrao', '$wishlist_name', '$id_comprador') ";

  mysqli_query($link, $sql);
  

?>