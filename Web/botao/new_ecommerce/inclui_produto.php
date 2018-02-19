<?php

  
  //session_start();

  //if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  require_once('bd.class.php');
  
  $nome_produto = $_POST['nome'];
  $preco_original = $_POST['preco_original'];
  $preco_desconto = $_POST['preco_desconto'];
  
  $objBD = new bd();
  $link = $objBD->conecta_mysql();;

  $sql = "INSERT INTO produto(nome_produto, original_price, last_price) VALUES('$nome_produto', $preco_original, $preco_desconto) ";

  mysqli_query($link, $sql);
  
  

?>