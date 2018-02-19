<?php
  
  session_start();

  require_once('bd.class.php');

  $usuario = $_POST['usuario'];
  $senha = md5($_POST['senha']);
  
  $sql = "SELECT id, usuario, email FROM usuario WHERE usuario = '$usuario' AND senha = '$senha'";

  $objBD = new bd();
  $link = $objBD->conecta_mysql();

  $resultado_consulta = mysqli_query($link, $sql);
  

  if($resultado_consulta){
    $dados_usuario = mysqli_fetch_array($resultado_consulta);
    if(isset($dados_usuario['usuario'])){

      $_SESSION["id_usuario"] = $dados_usuario['id'];
      $_SESSION["usuario"] = $dados_usuario['usuario'];
      $_SESSION["email"] = $dados_usuario['email'];
      
      
      header("Location: produtos.php");
    }else {
      header("Location: index.php?erro=1");
    }
  }else {
    echo 'Erro na consulta ao banco!';
  }

?>