<?php
  
  class bd{

    public function conecta_mysql(){
      DEFINE('DB_USERNAME', 'root');
      DEFINE('DB_PASSWORD', 'root');
      DEFINE('DB_HOST', 'localhost');
      DEFINE('DB_DATABASE', 'ecommerce');

      $con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("Erro ao conectar ao servidor: ".mysql_error());
      mysqli_select_db($con, DB_DATABASE) or die("Erro ao selecionar o banco de dados: ".mysql_error());

      
      mysqli_query($con, "SET NAMES 'utf8'");
      mysqli_query($con, "SET character_set_connection=uf8");
      mysqli_query($con, "SET character_set_client=uf8");
      mysqli_query($con, "SET character_set_results=uf8");
      

      return $con;

    }
    
  }

?>