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
    
    <!-- Bootstrap & CSS-->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilo.css" rel="stylesheet" type="text/css">
    
    <!-- jquery - link cdn -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    
    <script type="text/javascript">
      
      $(document).ready( function(){

        //se botao foi clicado
        $('#btn_criar').click(function(){
          //verificar se o campo de texto possui caracteres
          if($('#text_nome').val().length > 0){

            $.ajax({
              url: 'cria_wishlist.php',
              method: 'post',
              data: $('#form_cria_wislist').serialize(),

              success: function(data){
                $('#text_nome').val('');
                atualizaNomeListas(); 
                //alert(data);
              }

            });
            
          } 

        });

        function atualizaNomeListas(){

          //carregar listas
          $.ajax({
              url: 'get_wishlist.php',
              method: 'post',
              success: function(data){
                $('#listas').html(data);
              }

            });

        }

        atualizaNomeListas(); 

     
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
        <h2>WISHLIST</h2>
      </div>
    </div>

    <!-- Conteudos -->

    <section id="wishlist">
      
      <div class="container">
        
        <div class="row" style="border: 0px solid red" >
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="panel panel-default">
              <div class="panel-body">
                
                <form id="form_cria_wislist">
                  <div class="input-group">
                    <input type="text" class="form-control" id="text_nome" name="text_nome" placeholder="Crie uma nova lista de compras!" maxlength="140">
                    <span class="input-group-btn">
                      <button class="btn btn-default" id="btn_criar" type="button">Criar</button>
                    </span>
                  </div>
                  <br>
                  <div class="input-group">
                    <label class="checkbox-inline pull-right"><input id="lista_padrao" name="lista_padrao" type="checkbox" value="0">Lista de Compras Padrão?</label>
                  </div>
                </form>
              
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>

        <div class="row" style="border: 0px solid red" >
          <div class="col-md-4" style="border: 0px solid red">
            <div id="listas" class="list-group"></div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-7 list-group" style="border: 0px solid red">

          </div>
        </div>
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