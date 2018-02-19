<?php
  
  $produtos = array();

  function setProductName($product_name){
    
    switch ($product_name) {
      case 'product1':
        
        break;

      case 'product2':
        echo 'Arroz';
        break;

      case 'product3':
        echo 'Farinha de Coco';
        break;

      case 'product4':
        echo '';
        break;

      case 'product5':
        echo '';
        break;

      case 'product6':
        echo '';
        break;
      
      default:
        # code...
        break;
    }

  }


?>