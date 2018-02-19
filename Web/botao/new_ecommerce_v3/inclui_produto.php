<?php

  
  //session_start();

  //if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  require_once('bd.class.php');
  
  $nome_produto = $_POST['nome'];
  $preco_original = $_POST['preco_original'];
  $preco_desconto = $_POST['preco_desconto'];
  $foto = $_FILES["imagem"];

  $objBD = new bd();
  $link = $objBD->conecta_mysql();



  if(!empty($foto["name"])){


    // Largura máxima em pixels
    $largura = 150;
    // Altura máxima em pixels
    $altura = 180;
    // Tamanho máximo do arquivo em bytes
    $tamanho = 100000;
 
    $error = array();

    // Verifica se o arquivo é uma imagem
    if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
       $error[1] = "Isso não é uma imagem.";
    } 

    // Pega as dimensões da imagem
    $dimensoes = getimagesize($foto["tmp_name"]);

    // Verifica se a largura da imagem é maior que a largura permitida
    if($dimensoes[0] > $largura) {
      $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
    }
 
    // Verifica se a altura da imagem é maior que a altura permitida
    if($dimensoes[1] > $altura) {
      $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
    }
    
    // Verifica se o tamanho da imagem é maior que o tamanho permitido
    if($foto["size"] > $tamanho) {
        $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
    }

    if (count($error) == 0) {
    
      // Pega extensão da imagem
      preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
 
          // Gera um nome único para a imagem
          $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
 
          // Caminho de onde ficará a imagem
          $caminho_imagem = "img_produto/" . $nome_imagem;
 
      // Faz o upload da imagem para seu respectivo caminho
      move_uploaded_file($foto["tmp_name"], $caminho_imagem);
    
      // Insere os dados no banco
      $sql = "INSERT INTO produto(nome_produto, original_price, last_price, imagem) VALUES('$nome_produto', $preco_original, $preco_desconto, '$nome_imagem') ";



       mysqli_query($link, $sql);
    
      // Se os dados forem inseridos com sucesso
      if ($sql){
        //header("Location: novo_produto.php");
        echo 'Salvo com sucesso';
      }
    }

    if (count($error) != 0) {
      foreach ($error as $erro) {
        echo $erro . "<br />";
      }
    }

  }
  
?>