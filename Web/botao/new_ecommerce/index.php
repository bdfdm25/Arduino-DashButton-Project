<?php

  $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;


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
    
    <script src="seleciona_qntde.js"></script>

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
            url: 'get_produtos.php',
            method: 'post',
            success: function(data){
              $('#produtos_ofertas').html(data);
            }

          });
        }



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
            <li><a href="novo_produto.php">Meu Carrinho</a></li>
            <li class="divisor" role="separator"></li>
            <li><a href="inscrevase.php">Inscrever-se</a></li>
            <li class="<?= $erro == 1 ? 'open' : '' ?>">
                <a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrar</a>
                <ul class="dropdown-menu" aria-labelledby="entrar">
                  <div class="col-md-12">
                    <h4>Você possui uma conta?</h4>
                    <br />
                    <form method="post" action="validar_acesso.php" id="formLogin">
                      <div class="form-group">
                        <input type="text" class="form-control" id="campo_usuario" name="usuario" placeholder="Usuário" />
                      </div>
                    
                      <div class="form-group">
                        <input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" />
                      </div>
                    
                      <button type="buttom" class="btn btn-warning" id="btn_login" style="">Entrar</button>

                      <br /><br />

                      <?php
                        if($erro == 1){
                          echo '<font color="#FF0000">Usuário e/ou senha inválido(s)</font>';
                        }

                      ?>
                    </form>
                  </div>
                </ul>
              </li>
          </ul>
          
        </div>
        
      </div><!-- Fim Container -->
      
    </nav><!-- Fim Nav -->

    <div class="capa">
      <div class="texto-capa">
        <h2>Os melhores produtos online</h2>
        <h2>Com o melhor preco e mais agilidade!</h2>
      </div>
    </div>

    <!-- Conteudos -->


    <section id="ofertas">
      <div class="container">
        <h3>Principais Ofertas:</h3>
      </div>
      
      <div class="container" style="border: 1px solid red">
        
        <div id="produtos_ofertas" class="list-group"></div>
        
      </div>
    </section>

    <section id="produtos">
      <div class="container">
        <div class="row">
            
          <!-- Recursos -->
          <div class="col-md-5">
            <h2>Fácil.</h2>

            <h3>Buscar</h3>
            <p>Já sabe o que quer escutar? É só procurar e apertar o play.</p>
            

            <h3>Navegar</h3>
            <p>Veja os novos lançamentos, o que está bombando nas paradas e as melhores playlists para o seu momento.</p>
            

            <h3>Descobrir</h3>
            <p>Curta músicas novas toda segunda-feira com uma playlist personalizada pra você. Ou relaxe e curta uma das rádios.</p>
          </div>

          <div class="col-md-2"></div>

          <!-- Img Recursos -->
          <div class="col-md-5 align">

            <div class="row">
              <div class="col-md-10">
                <img src="imagens/111.jpg" class="img-responsive">
              </div>
            </div><!-- Fim row -->
          </div>

        </div>
      </div>
    </section>

    <section id="novas_ofertas">
      <div class="container" style="border: 1px solid red;">
        conteudo/ novas_ofertas
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