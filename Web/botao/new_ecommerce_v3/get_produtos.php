<?php
  
  session_start();

  //if(!isset($_SESSION['usuario'])) header("Location: home.php?erro=1");

  require_once('bd.class.php');
  
  
  $objBD = new bd();
  $link = $objBD->conecta_mysql();;

  $sql = "SELECT * FROM produto ORDER BY id_produto DESC ";

  
  $resultado_consulta = mysqli_query($link, $sql);

  if($resultado_consulta){

    while($produto = mysqli_fetch_array($resultado_consulta)){
    
      echo '<div class="col-md-4">';
        echo '<div class="produto_1" style="border: 1px solid grey">';
          echo '<img src="img_produto/'.$produto['imagem'].'"" alt="Foto de exibição" class="img-responsive"/><br />';
          echo '<div class="form">';
            echo '<form method="post">';
              echo '<p>'.$produto['nome_produto'].'</p>';
              echo '<h4>R$ '.$produto['original_price'].'<span>R$ '.$produto['last_price'].'</span></h4><br>';
              echo '<input class="form-control" type="number" name="quantidade" id="quantidade_'.$produto['id_produto'].'" placeholder="Quantidade" max="20" min="1"><br>';
              echo '<button type="submit" class="btn btn-primary form-control form-button btn_carrinho" id="carrinho_'.$produto['id_produto'].'" data-id_produto="'.$produto['id_produto'].'">Carrinho</button><br><br>';
              echo '<button type="submit" class="btn btn-primary form-control form-button btn_wishlist" id="wishlist_'.$produto['id_produto'].'" data-id_produto="'.$produto['id_produto'].'" data-toggle="modal" data-target="#myModal">Lista de Compras</button>';
              echo '<br><br>';
            echo '</form>';
          echo '</div>';
        echo '</div>';
      echo '</div>';


    } 

  }else {
    echo 'Erro na consulta.';
  }

?>



