(function() {
  window.Main = {};
  Main.Page = (function() {
    var mosq = null;
    function Page() {
      var _this = this;
      mosq = new Mosquitto();

      $(document).ready(function() {
        return _this.connect();
      });
      $('#disconnect-button').click(function() {
        return _this.disconnect();
      });
      $('#subscribe-button').click(function() {
        return _this.subscribe();
      });
      $('#unsubscribe-button').click(function() {
        return _this.unsubscribe();
      });
      
      
      $('#liga-output').click(function() {
        var payload = "L";  
        var TopicPublish = $('#pub-topic-text')[0].value;       
        mosq.publish(TopicPublish, payload, 0);
      });

      
      $('#desliga-output').click(function() {
        var payload = "D";  
        var TopicPublish = $('#pub-topic-text')[0].value;       
        mosq.publish(TopicPublish, payload, 0);
      });

      $('#reset-output').click(function() {
        var payload = "R";  
        var TopicPublish = $('#pub-topic-text')[0].value;       
        mosq.publish(TopicPublish, payload, 0);
      });

      mosq.onconnect = function(rc){
        var p = document.createElement("p");
        var topic = $('#pub-subscribe-text')[0].value;
        console.log("Conectado ao Broker!");
        //p.innerHTML = "Conectado ao Broker!";
        //$("#debug").append(p);
        mosq.subscribe(topic, 0);
        
      };
      mosq.ondisconnect = function(rc){
        var p = document.createElement("p");
        var url = "ws://iot.eclipse.org/ws";
        console.log("A conexão com o broker foi perdida");
        //p.innerHTML = "A conexão com o broker foi perdida";
        //$("#debug").append(p);        
        mosq.connect(url);
      };
      mosq.onmessage = function(topic, payload, qos){
        var p = document.createElement("p");
        var acao = payload[0];
        
        //escreve o estado do output conforme informação recebida
         if (acao == 'C')
            //$("#janela").modal();
            p.innerHTML = "<meta http-equiv='refresh' content='1; url=checkout.html'>"
            //openModal();
          else
            p.innerHTML = " "
        
        $("#debug").html(p);
      };
    }

    function openModal(){
      $(document).ready(function(){
        
          $("#janela").modal();
      
      });
    }
    
    Page.prototype.connect = function(){
      var url = "ws://iot.eclipse.org/ws";
      mosq.connect(url);
    };
    Page.prototype.disconnect = function(){
      mosq.disconnect();
    };
    Page.prototype.subscribe = function(){
      var topic = $('#sub-topic-text')[0].value;
      mosq.subscribe(topic, 0);
    };
    Page.prototype.unsubscribe = function(){
      var topic = $('#sub-topic-text')[0].value;
      mosq.unsubscribe(topic);
    };
    
    return Page;
  })();
  $(function(){
    return Main.controller = new Main.Page;
  });
}).call(this);
