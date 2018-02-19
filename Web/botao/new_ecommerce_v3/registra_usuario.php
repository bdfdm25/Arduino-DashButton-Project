<?php
  
  require_once('bd.class.php');
  

  $usuario = $_POST['usuario'];
  $email = $_POST['email'];
  $senha = md5($_POST['senha']);
  
  $objBD = new bd();
  $link = $objBD->conecta_mysql();

  
  $usuario_existe = false;
  $email_existe = false;

  $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
  $resultado_consulta = mysqli_query($link, $sql);
  if($resultado_consulta){
    $dados = mysqli_fetch_array($resultado_consulta);
    if (isset($dados['usuario'])) {
      $usuario_existe = true;
    }

  }else {
    echo 'Erro ao localizar usuario no banco de dados';
  }

  $sql = "SELECT * FROM usuario WHERE email = '$email'";
  $resultado_consulta = mysqli_query($link, $sql);
  if($resultado_consulta){
    $dados = mysqli_fetch_array($resultado_consulta);
    if (isset($dados['usuario'])) {
      $email_existe = true;
    }

  }else {
    echo 'Erro ao localizar usuario no banco de dados';
  }

  if($usuario_existe || $email_existe){
    $retorno_get = '';

    if($usuario_existe){
      $retorno_get.="erro_usuario=1&";
    }

    if($email_existe){
      $retorno_get.="erro_email=1&";
    }

    header("Location: inscrevase.php?".$retorno_get);
    die();
  }
  

  

  $sql = "insert into usuario(usuario, email, senha)values('$usuario', '$email', '$senha')";
  
  if(mysqli_query($link, $sql)){
    //echo 'Usuario inserido com sucesso!';
    header("Location: index.php");
  }else {
    echo 'Erro ao inserir registro';
  }


?>