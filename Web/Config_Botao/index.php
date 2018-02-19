<!--Arduino-->

<!DOCTYPE html>
<html>

  <head>
    <title>Wifi Settings</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    

    <!-- bootstrap - link cdn -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

  </head>


  <body>
    <div class="container">    
        
      <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3"> 
        <div class="row logo">                
          <div class="iconmelon">
            <img src="img/wifi.png">
          </div>
        </div>
          
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title text-center">Insira aqui os dados do seu Wi-Fi</div>
          </div>     

          <div class="panel-body">

            <form name="form" method="POST" action="configura_rede.php" id="form-config" class="form-horizontal">
                     
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-signal"></i></span>
                <input id="wifi" type="text" class="form-control" name="wifi" value="" placeholder="Wi-Fi Name">        
              </div>

              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
              </div>                                                                  
              <br />
              <div class="form-group">
                <!-- Button -->
                <div class="col-sm-6">
                  <button type="submit" name="save" class="btn btn-warning center-block"><i class="glyphicon glyphicon-ok"></i> SALVAR</button>                          
                </div>
                <div class="col-sm-6">
                  <button type="submit" name="reset" class="btn btn-warning center-block"><i class="glyphicon glyphicon-refresh"></i> RESET</button>                          
                </div>
              </div>

            </form>     

          </div>                     
        </div>  
      </div>
    </div>

    <!--<div id="particles"></div>-->

  </body>

</html>


