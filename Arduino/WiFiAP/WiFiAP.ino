
//bibliotecas
#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266WebServer.h>
#include <WebPageDashButton.h>
#include <PubSubClient.h>


/* Set these to your desired credentials. */
const char *ssid = "ESPap";
const char *password = "thereisnospoon";

//objeto da classe newPage
WebPageDashButton newPage;


ESP8266WebServer server(80);

/* Just a little test message.  Go to http://192.168.4.1 in a web browser
 * connected to this access point to see it.
 */
String msg = newPage.createPage();
 
void handleRoot() {
  server.send(200, "text/html", msg);
}

void setup() {
	delay(1000);
	Serial.begin(115200);
	Serial.println();
	configuraModoAP();
  listenClient();
  
}

void loop() {
	server.handleClient();
}


void configuraModoAP() {
  Serial.print("Configuring access point...");
  /* You can remove the password parameter if you want the AP to be open. */
  WiFi.softAP(ssid, password);

  IPAddress myIP = WiFi.softAPIP();
  Serial.print("AP IP address: ");
  Serial.println(myIP);
  server.on("/", handleRoot);
  server.begin();
  Serial.println("HTTP server started");
}


void listenClient() {
  WiFiClient client = server.available();
  
  delay(1000);

  if(!client){
    Serial.println(F("Waiting for a client to connect to this server..."));
    Serial.println(F("On address 192.168.4.1"));
    Serial.println(client);
    delay(200);
    return;
  }

  Serial.println("User Connected!");

  String answer = client.readStringUntil('\r');
  Serial.println(req);
  client.flush();
}


