<!--
<?php
  
  //session_start();

  //if(!isset($_SESSION['wifi_name'])) header("Location: http://localhost/arduino_set/index.php?erro=1");

?>
-->


<!DOCTYPE html>
<html>
  <head>
    <title>Wifi Settings</title>
    
    <style type="text/css"> </style>
    <script type='text/javascript' src='test.js'></script>

  </head>

  <body>
    <div>
      <div>
        <input type="text" id="sub-topic" name="sub-topic" value="Sub Topic">
      </div>
      <div>
        <input type="text" id="rec-topic" name="rec-topic" value="Rec Topic">
      </div>
      <div></div>
    </div>
    <div>
      <button>LIGA</button>
      <button>DESLIGA</button>
      <button>RESET</button>
    </div>
  </body>
</html>