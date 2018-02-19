<?php
  
  session_start();

  //require_once('bd.class.php');

  $rede = $_POST['wifi'];
  $password = $_POST['password'];

  $retorno_get = '';
  $retorno_get.= $rede;
  $retorno_get.= ';';
  $retorno_get.= $password;

  function get_post_action($name){
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
  }


  switch (get_post_action('save', 'reset')) {
    case 'save':
        header("Location:  http://192.168.4.1/setting?ssid=".$rede."&pass=".$password);
        //echo "Location:  http://192.168.4.1/setting?ssid=".$rede."&pass=".$password;
        break;

    case 'reset':
        header("Location:  http://192.168.4.1/cleareeprom");
        break;

    default:
        //no action sent
  }

  //echo "Retorno: ".$retorno_get;
  
  //header("Location: http://192.168.4.1/".$retorno_get);  
  //header("Location:  http://192.168.4.1/setting?ssid=".$rede."&pass=".$password);


?>