//Create a new Client object with your broker's hostname, port and your own clientId
var TopicPublish = $('#rec-topic')[0].value;
var topic = $('#sub-topic')[0].value;

var client = new Messaging.Client(hostname, port, clientid);

var options = {

     //connection attempt timeout in seconds
     timeout: 3,

     //Gets Called if the connection has successfully been established
     onSuccess: function () {
         alert("Connected");
     },

     //Gets Called if the connection could not be established
     onFailure: function (message) {
         alert("Connection failed: " + message.errorMessage);
     }

 };

//Attempt to connect
client.connect(options);