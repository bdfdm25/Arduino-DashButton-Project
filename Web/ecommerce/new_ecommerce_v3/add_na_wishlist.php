<?php
    
  session_start();

  if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  require_once('bd.class.php');
  
  $id_comprador = $_SESSION['id_usuario'];
  $id_produto = $_POST['id_produto'];
  $quantidade = $_POST['quantidade'];  

  $produto_existe = false;

  $objBD = new bd();
  $link = $objBD->conecta_mysql();


  $sql = "SELECT * FROM produtos_wishlist WHERE id_produto = '$id_produto' AND id_comprador = '$id_comprador'";
  
  $resultado_consulta = mysqli_query($link, $sql);

  if($resultado_consulta){
    $produto = mysqli_fetch_array($resultado_consulta);
    if(isset($produto['id_produto']) && isset($produto['id_comprador'])){
      $produto_existe = true;
    }else{
      $produto_existe = false;
    }
  }else{
    echo "Not OK";
  }

  
  if($produto_existe){
    //echo 'Produto Existe';
    $sql = "UPDATE produtos_wishlist SET quantidade = quantidade + '$quantidade' WHERE id_produto = '$id_produto' AND id_comprador = '$id_comprador'";
    if(mysqli_query($link, $sql)){
      header("Location: meu_carrinho.php");
      
    }
  }else{
    //echo 'Produto Nao Existe';
    $sql = "INSERT INTO produtos_wishlist(id_produto, quantidade, id_comprador) VALUES ('$id_produto', '$quantidade', '$id_comprador') ";
    if(mysqli_query($link, $sql)){
      header("Location: meu_carrinho.php");
    }
  }

  

  
  
  

?>




