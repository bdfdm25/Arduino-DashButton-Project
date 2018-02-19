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
    <!--<link rel="stylesheet" type="text/css" href="estilo.css">-->
    <link rel="stylesheet" type="text/css" href="estilo.css">


    <script type="text/javascript" src="js/seleciona_qntde.js"></script>
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
            <li><a href="#">Lista de Compras</a></li>
            <li><a href="#">Meu Carrinho</a></li>
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
        <div class="col-md-10">
          <section class="fundo-pagina">
            <div>
              <!--Inicio da primeira linha de ofertas-->
              <div class="master-grid">
                <div class="col-md-4"> 

                  <div class="produto_1" style="border: 1px solid grey">         
                    <img src="imagens/1.png" class="img-responsive"/>
                    <div class="form">
                      <form action="#" method="post">
                        <p>Sal de Cozinha</p>
                        <h4>$20.99 <span>$35.00</span></h4><br>
                        <input type="hidden" name="produto" value="product1">
                        <button type="submit" class="btn btn-primary form-control form-button">Carrinho</button><br><br>
                        <button type="submit" class="btn btn-primary form-control form-button">Wishlist</button>
                        <br><br>
                        
                        <!--Alterar CSS para nao afetar os efeitos no botao de quantidade-->                       
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button class="btn btn-success btn-number" onclick="delProduto()" type="button">
                              <span class="glyphicon glyphicon-minus"></span>
                            </button>
                          </span>
                          <input type="text" class="form-control input-number" name="quantity" value="1" maxlength="2" max="10" size="1" id="number">
                          <span class="input-group-btn">
                            <button class="btn btn-success" onclick="addProduto()" type="button">
                              <span class="glyphicon glyphicon-plus"></span>
                            </button>
                          </span>
                        </div>
                        <!--Alterar CSS para nao afetar os efeitos no botao de quantidade-->       
                      </form>
                    </div>           
                  </div>
                </div>
                <div class="col-md-4"> 
                  <div class="produto_1" style="border: 1px solid grey;">         
                    <img src="imagens/2.png" class="img-responsive" />
                    <div class="form">
                      <form action="#" method="post">
                        <p>Arroz</p>
                        <h4>$9.99 <span>$15.00</span></h4><br>
                        <input type="hidden" name="produto" value="product1">
                        <button type="submit" class="btn btn-primary form-control form-button">Carrinho</button><br><br>
                        <button type="submit" class="btn btn-primary form-control form-button">Wishlist</button>
                      </form>
                    </div>           
                  </div>
                </div>
                <div class="col-md-4"> 
                  <div class="produto_1" style="border: 1px solid grey;">         
                    <img src="imagens/3.png" class="img-responsive"/>
                    <div class="form">
                      <form action="#" method="post">
                        <p>Acucar</p>
                        <h4>$10.99 <span>$14.00</span></h4><br>
                        <input type="hidden" name="produto" value="product1">
                        <button type="submit" class="btn btn-primary form-control form-button">Carrinho</button><br><br>
                        <button type="submit" class="btn btn-primary form-control form-button">Wishlist</button>
                      </form>
                    </div>           
                  </div>
                </div>
                <div class="clearfix"> </div>
              </div> <!--//Fim da primeira linha de ofertas-->

              <!--Inicio da segunda linha de ofertas-->
              <div class="master-grid">
                <div class="col-md-4"> 
                  <div class="produto_1" style="border: 1px solid grey;">         
                    <img src="imagens/4.png" class="img-responsive" />
                    <div class="form">
                      <form action="#" method="post">
                        <p>Cafe</p>
                        <h4>$20.99 <span>$35.00</span></h4><br>
                        <input type="hidden" name="produto" value="product1">
                        <button type="submit" class="btn btn-primary form-control form-button">Carrinho</button><br><br>
                        <button type="submit" class="btn btn-primary form-control form-button">Wishlist</button>
                      </form>
                    </div>           
                  </div>
                </div>
                <div class="col-md-4"> 
                  <div class="produto_1" style="border: 1px solid grey;">         
                    <img src="imagens/5.png" class="img-responsive" />
                    <div class="form">
                      <form action="#" method="post">
                        <p>Feijao</p>
                        <h4>$20.99 <span>$35.00</span></h4><br>
                        <input type="hidden" name="produto" value="product1">
                        <button type="submit" class="btn btn-primary form-control form-button">Carrinho</button><br><br>
                        <button type="submit" class="btn btn-primary form-control form-button">Wishlist</button>
                      </form>
                    </div>           
                  </div>
                </div>
                <div class="col-md-4"> 
                  <div class="produto_1" style="border: 1px solid grey;">         
                    <img src="imagens/6.png" class="img-responsive"/>
                    <div class="form">
                      <form action="#" method="post">
                        <p>Achocolatado</p>
                        <h4>$20.99 <span>$35.00</span></h4><br>
                        <input type="hidden" name="produto" value="product1">
                        <button type="submit" class="btn btn-primary form-control form-button">Carrinho</button><br><br>
                        <button type="submit" class="btn btn-primary form-control form-button">Wishlist</button>
                      </form>
                    </div>           
                  </div>
                </div>
                <div class="clearfix"> </div>
              </div> <!--//Fim da segunda linha de ofertas-->
            </div>
          </section>
        </div>
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