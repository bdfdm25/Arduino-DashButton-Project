<?php

  session_start();

  if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");


?>


<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Supermercado Virtual</title>

    <link rel="icon" href="imagens/shoppingCart.png">
    
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!-- Bootstrap & CSS-->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="estilo.css">-->
    <link rel="stylesheet" type="text/css" href="estilo.css">

    <script>
      $(document).ready( function(){

        //verifica se os campos de usuário e senha foram devidamente preenchidos
        $('#btn_login').click( function (){

          var campo_vazio = false;

          if( $('#campo_usuario').val() == '' ){
            $('#campo_usuario').css({'border-color' : '#A94442'});
            campo_vazio = true;
          }else {
            $('#campo_usuario').css({'border-color' : '#ccc'});
          }

          if( $('#campo_senha').val() == '' ){
            $('#campo_senha').css({'border-color' : '#A94442'});
            campo_vazio = true;
          } else {
            $('#campo_senha').css({'border-color' : '#ccc'});
          }

          if(campo_vazio) return false;

        });

        function listaOfertas(){

          $.ajax({
            async: true,
            url: 'get_produtos.php',
            method: 'post',
            success: function(data){
              $('#produtos').html(data);

              //verifica se o botao "carrinho" foi pressionado
              $('.btn_carrinho').click( function(){
                var id_produto = $(this).data('id_produto');
                var quantidade = $('#quantidade_' + id_produto).val();

                
                //verifica se possui mais de 1 na quantidade
                if($('#quantidade_' + id_produto).val() >= 1){
                  //envia para "add_carrinho.php" o id do produto e quantidade.
                  //dessa forma a pagina add_carrinho salva no bd os dados do produto adicionado ao carrinho.
                  $.ajax({
                    async: true,
                    url: 'add_carrinho.php',
                    method: 'post',
                    data: {id_produto : id_produto,
                           quantidade : quantidade},
                    success: function(data){
                      //alert(data);
                    }
                  });
                }else{
                  alert('Quantidade precisa ser maior do que 0.');
                }
              });


              $('.btn_wishlist').click( function(){
                var id_produto = $(this).data('id_produto');

              });
            }

          });
        }

        listaOfertas();
     
      });         
    </script>

  </head>

  <body>

    <nav class="navbar navbar-fixed-top navbar-inverse navbar-transparente">
      <div class="container">

        <!-- Header -->
        <div class="navbar-header">

          <!-- Toggle Button -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra-navegacao">
            <span class="sr-only">alternar navegacao</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>


          <a href="index.php" class="navbar-brand">
            <span class="img-logo">Supermercado</span>
          </a>
          
        </div>

        <!-- NavBar -->
        <div class="collapse navbar-collapse" id="barra-navegacao">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="produtos.php">Produtos</a></li>
            <li><a href="minha_wishlist.php">Lista de Compras</a></li>
            <li><a href="meu_carrinho.php">Meu Carrinho</a></li>
            <li class="divisor" role="separator"></li>
            <li><a href="sair.php">Sair</a></li>
            
          </ul>
          
        </div>
        
      </div><!-- Fim Container -->
      
    </nav><!-- Fim Nav -->

    <div class="capa">
      <div class="texto-capa">
        <h2>Produtos</h2>
      </div>
    </div>

    <!-- Conteudos -->

    <section id="ofertas">
      <div class="container">
        <div class="col-md-1"></div>
        <div id="produtos" class="col-md-10"></div>
        <div class="col-md-1"></div>
      </div>
    </section>
    

    <!-- Rodape --> 
    <footer id="rodape">
      <div class="container">
        <div class="row"><!--Inicio Row -->
          <div class="col-md-2">
            <span class="img-logo">Spotify</span>
          </div>

          <div class="col-md-2">
            <h4>COMPANY</h4>
            <ul class="nav">
              <li><a href="#">Sobre</a></li>
              <li><a href="#">Empregos</a></li>
              <li><a href="#">Impresnsa</a></li>
              <li><a href="#">Novidades</a></li>
            </ul>
          </div>

          <div class="col-md-2">
            <h4>COMUNIDADES</h4>
            <ul class="nav">
              <li><a href="#">Artistas</a></li>
              <li><a href="#">Desenvolvedores</a></li>
              <li><a href="#">Marcas</a></li>
            </ul>
          </div>

          <div class="col-md-2">
            <h4>LINKS UTEIS</h4>
            <ul class="nav">
              <li><a href="#">Ajuda</a></li>
              <li><a href="#">Presentes</a></li>
              <li><a href="#">Player da web</a></li>
            </ul>
          </div>

          <div class="col-md-4">
            <ul class="nav">
              <li class="item-rede-social"><a href="#"><img src="imagens/facebook.png"></a></li>
              <li class="item-rede-social"><a href="#"><img src="imagens/instagram.png"></a></li>
              <li class="item-rede-social"><a href="#"><img src="imagens/twitter.png"></a></li>
            </ul>
          </div>


        </div><!--Fim Row -->
        
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>