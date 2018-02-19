<!DOCTYPE html>
<html lang="pt-br">
  <head>

    <title>Adiciona Produto</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    
  </head>
  <body>
    
    <div class="container"> 
      
      <div class="page-header">
        <h1>Adiciona Produto:</h1>
      </div>
      
      <div class="row titulo-secao">
        <div class="col-sm-4"></div>

        <div class="col-sm-4">
          <h3>Novo Produto:</h3>
          <form method="post" action="inclui_produto.php" id="form_novoproduto">
            <div class="form-group">
              <label for="nome">Nome:</label>
              <input type="text" class="form-control" id="nome" name="nome">
            </div>

            <div class="form-group">
              <label for="imagem">Imagem:</label>
              <input type='file' name='imagem'>
            </div>

            <div class="form-group">
              <label for="preco_original">Preco Original:</label>
              <input type="text" class="form-control" id="preco_original" name="preco_original">
            </div>

            <div class="form-group">
              <label for="preco_desconto">Preco com desconto:</label>
              <input type="text" class="form-control" id="preco_desconto" name="preco_desconto">
            </div>

            <button type="submit" class="btn btn-primary" id="btn_salvaproduto">Salvar</button>
          </form>
        </div>

        <div class="col-sm-4"></div>
      </div>


    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>