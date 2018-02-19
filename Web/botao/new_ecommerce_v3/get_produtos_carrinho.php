<?php
  
  session_start();

  if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");

  require_once('bd.class.php');

  $id_comprador = $_SESSION['id_usuario'];
  
  $objBD = new bd();
  $link = $objBD->conecta_mysql();;

  //fazer um join no bd para pegar os dados do produto:imagem, nome, valor e quantidade. Apos isso exibir os dados em uma lista.

  $sql = " SELECT c.id_produto_carrinho, c.id_produto, SUM(c.quantidade), c.id_comprador, p.nome_produto, p.last_price, p.imagem FROM carrinho AS c JOIN produto AS p ON (c.id_produto = p.id_produto) WHERE id_comprador = '$id_comprador' GROUP BY c.id_produto ORDER BY c.id_produto_carrinho DESC";

  $resultado_consulta = mysqli_query($link, $sql);
  
  if($resultado_consulta){

    while($produto = mysqli_fetch_array($resultado_consulta)){

      echo '<li class="list-group-item clearfix">';
        echo '<form class="form-inline">';    
          echo '<div class="form-group">';
            echo '<h4 class="list-group-item-heading">'.$produto['nome_produto'].'</h4>';
            echo '<span>Preco unitario: R$'.$produto['last_price'].' | Quantidade: '.$produto['SUM(c.quantidade)'].'</span>';
          echo '</div>';
          echo '<div class="pull-right">';
            //echo '<input class="form-control" type="number" name="quantidade" id="quantidade_'.$produto['id_produto'].'" style="width:80px; margin-right:18px;" max="20" min="0">';
            echo '<button type="button" class="btn btn-danger pull-right btn_remover" id="remove_'.$produto['id_produto'].'" data-id_produto="'.$produto['id_produto'].'">';
                echo '<span class="glyphicon glyphicon-remove"></span>';
            echo '</button>';
          echo '</div>';
        echo '</form>';
      echo '</li>';
     
    } 

  }else {
    echo 'Erro na consulta.';
    //echo $resultado_consulta;
  }
  


?>




