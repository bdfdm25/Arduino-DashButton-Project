#include <ESP8266WiFi.h>// Importa a Biblioteca ESP8266WiFi
#include <Wire.h>
#include <EEPROM.h>
#include <PubSubClient.h> // Importa a Biblioteca PubSubClient

//defines:
//defines de id mqtt e tópicos para publicação e subscribe
#define TOPICO_SUBSCRIBE "mqttSub"    //tópico MQTT de escuta
#define TOPICO_PUBLISH   "mqttRec"    //tópico MQTT de envio de informações para Broker
                                                   
#define ID_MQTT  "MqttTest"     //id mqtt (para identificação de sessão - deve ser unico)

//defines - mapeamento de pinos do NodeMCU
#define D0    16
#define D1    5
#define D2    4
#define D3    0
#define D4    2
#define D5    14
#define D6    12
#define D7    13
#define D8    15
#define D9    3
#define D10   1
       


// WIFI
//Variaveis para receber o nome e a senha da rede wifi na qual o botao vai se conectar apos o tratamento na funcao setupWiFiClient();
String wifi_name = "";
String wifi_pwd = "";
// SSID / nome da rede WI-FI que deseja se conectar & // Senha da rede WI-FI que deseja se conectar
const char* SSID = " ";
const char* PASSWORD = " ";

// MQTT
const char* BROKER_MQTT = "iot.eclipse.org"; //URL do broker MQTT que se deseja utilizar
int BROKER_PORT = 1883; // Porta do Broker MQTT

//Senha para acesso ao botao no modo AP (AccessPoint);
const char WiFiAP_PWD[] = "sparkfun";       // Note... need to change




//******Variáveis e objetos globais******//

WiFiServer server(80); 
WiFiClient espClient; // Cria o objeto espClient
PubSubClient MQTT(espClient); // Instancia o Cliente MQTT passando o objeto espClient
char EstadoSaida = '0';  //variável que armazena o estado atual da saída

//Recebe a mensagem do client por completo, 
//neste caso o nome da rede e a senha junto das tags GET / e HTTP/1.1. Ex:GET /NomeDaRede;SenhaDaRede HTTP/1.1
String web_return = "";



//Divisor para separar o nome e a senha da rede na qual o botao vai se conectar;
const char divisor[] = ";";

int i, j, flag = 0, contador = 0;


//Prototypes
void initSerial();
void initWiFi();
void initMQTT();
void setupWiFiAP();
int setupWiFiClient();
void reconectWiFi(); 
void mqtt_callback(char* topic, byte* payload, unsigned int length);
void VerificaConexoesWiFIEMQTT(void);
void InitOutput(void);
//void loadCredentials(String ssid, String password);
//void saveCredentials(String ssid, String password);

          

/* 
 *  Implementações das funções
 */

void setup() 
{
 
  //loadCredentials(String ssid, String password);
  InitOutput();
  initSerial();                   
  initWiFi();
  initMQTT();
  //server.begin();
}


//Função: inicializa comunicação serial com baudrate 115200 (para fins de monitorar no terminal serial 
//        o que está acontecendo.
//Parâmetros: nenhum
//Retorno: nenhum
void initSerial() 
{
    Serial.begin(9600);
    delay(10);
}


//Função: inicializa e conecta-se na rede WI-FI desejada
//Parâmetros: nenhum
//Retorno: nenhum
void initWiFi() 
{
    delay(100);
    
    Serial.println("------Conexao WI-FI------");
    Serial.print("Conectando-se na rede: ");
    Serial.println(SSID);//recebe o nome da rede recebido na variavel wifi_name;
    Serial.println("Aguarde");
    
    reconectWiFi();
}


//Função: inicializa parâmetros de conexão MQTT(endereço do 
//        broker, porta e seta função de callback)
//Parâmetros: nenhum
//Retorno: nenhum
void initMQTT() 
{
    MQTT.setServer(BROKER_MQTT, BROKER_PORT);   //informa qual broker e porta deve ser conectado
    MQTT.setCallback(mqtt_callback);            //atribui função de callback (função chamada quando qualquer informação de um dos tópicos subescritos chega)

}

//Função: função de callback 
//        esta função é chamada toda vez que uma informação de 
//        um dos tópicos subescritos chega)
//Parâmetros: nenhum
//Retorno: nenhum
void mqtt_callback(char* topic, byte* payload, unsigned int length) 
{
    String msg;

    //obtem a string do payload recebido
    for(int i = 0; i < length; i++) 
    {
       char c = (char)payload[i];
       msg += c;
    }
  
    //toma ação dependendo da string recebida:
    //verifica se deve colocar nivel alto de tensão na saída D0:
    //IMPORTANTE: o Led já contido na placa é acionado com lógica invertida (ou seja,
    //enviar HIGH para o output faz o Led apagar / enviar LOW faz o Led acender)
    if (msg.equals("L"))
    {
        digitalWrite(LED_BUILTIN, LOW); 
        //digitalWrite(D0, LOW);
        EstadoSaida = '1';
    }

    //verifica se deve colocar nivel alto de tensão na saída D0:
    if (msg.equals("D"))
    {
        digitalWrite(LED_BUILTIN, HIGH); 
        //digitalWrite(D0, HIGH);
        EstadoSaida = '0';
    }

    if (msg.equals("R"))
    {
      //Volta para o modo AP para configurar uma nova rede;
    }
    
}

//Função: reconecta-se ao broker MQTT (caso ainda não esteja conectado ou em caso de a conexão cair)
//        em caso de sucesso na conexão ou reconexão, o subscribe dos tópicos é refeito.
//Parâmetros: nenhum
//Retorno: nenhum
void reconnectMQTT() 
{
    while (!MQTT.connected()) 
    {
        Serial.print("* Tentando se conectar ao Broker MQTT: ");
        Serial.println(BROKER_MQTT);
        if (MQTT.connect(ID_MQTT)) 
        {
            Serial.println("Conectado com sucesso ao broker MQTT!");
            MQTT.subscribe(TOPICO_SUBSCRIBE); 
        } 
        else 
        {
            Serial.println("Falha ao reconectar no broker.");
            Serial.println("Havera nova tentatica de conexao em 2s");
            delay(2000);
        }
    }
}

//Função: reconecta-se ao WiFi
//Parâmetros: nenhum
//Retorno: nenhum
void reconectWiFi() 
{
    delay(10);
    //se já está conectado a rede WI-FI, nada é feito. 
    //Caso contrário, são efetuadas tentativas de conexão
    if (WiFi.status() == WL_CONNECTED)
        return;

    
    WiFi.begin(SSID, PASSWORD); // Conecta na rede WI-FI

    do{
      while (WiFi.status() != WL_CONNECTED) {
        Serial.print("Waiting...");
        delay(2000);  
      }
      contador++;
    }while(contador < 3);

    if(contador > 0){
      Serial.println("\r\n\r\nDash Button initializing...");
      setupWiFiAP();

      Serial.println("Trying to listening the client!");
      
      
      
    }else{
      
      Serial.println();
      Serial.print("Conectado com sucesso na rede ");
      Serial.print(SSID);
      Serial.println("IP obtido: ");
      Serial.println(WiFi.localIP());
    }
  
    
}


//Função: verifica o estado das conexões WiFI e ao broker MQTT. 
//        Em caso de desconexão (qualquer uma das duas), a conexão
//        é refeita.
//Parâmetros: nenhum
//Retorno: nenhum
void VerificaConexoesWiFIEMQTT(void)
{
    reconectWiFi(); //se não há conexão com o WiFI, a conexão é refeita
    
    if (!MQTT.connected()) 
        reconnectMQTT(); //se não há conexão com o Broker, a conexão é refeita
    
     
}


//Função: envia ao Broker o estado atual do output 
//Parâmetros: nenhum
//Retorno: nenhum
void EnviaEstadoOutputMQTT(void)
{
    if (EstadoSaida == '0')
      MQTT.publish(TOPICO_PUBLISH, "D");

    if (EstadoSaida == '1')
      MQTT.publish(TOPICO_PUBLISH, "L");

    Serial.println("- Estado da saida D0 enviado ao broker!");
    delay(1000);
}


//Função: inicializa o output em nível lógico baixo
//Parâmetros: nenhum
//Retorno: nenhum
void InitOutput(void)
{
    //IMPORTANTE: o Led já contido na placa é acionado com lógica invertida (ou seja,
    //enviar HIGH para o output faz o Led apagar / enviar LOW faz o Led acender)
    //pinMode(D0, OUTPUT);
    pinMode(LED_BUILTIN, OUTPUT);
    //digitalWrite(D0, HIGH); 
    digitalWrite(LED_BUILTIN, HIGH);          
}

//recebe os dados de configuracao da rede do usuario (WiFi SSID & WiFi Pwd) enviados atraves da pagina web de configuracao:
int setupWiFiClient(){ 
  
  WiFiClient client = server.available();//Verifica se o client esta conectado;
  delay(1000);

  //Enquanto o client nao conecta exibe as informacoes do DashButton em modo AP:
  if (!client){ 
    Serial.println("Aguardando conexao do client ao servidor");
    IPAddress myIP = WiFi.softAPIP();
    Serial.println("No endereco: ");
    Serial.println(myIP);
    delay(200);
    return 0;
    
  }
    
  //Se o client conectou comeca a ler o que esta sendo enviado;
  Serial.println("Connected!");
  String req = client.readStringUntil('\r'); //recebe as informacoes enviadas pelo client;
  Serial.println(req);
  client.flush();

   
  int msg_size = req.length(); //verifica o tamanho da mensagem enviada pelo client e armazena em "tamanho";

  //retira as tags GET e HTTP da mensagem e armazena apenas o conteudo util da mensagem enviada pelo client;
  for(i = 5; i < msg_size - 8; i++){
    web_return += req[i];
  }

  if(web_return.equals(" ")){
    String html_erro = "HTTP/1.1 200 OK\r\n";        
           html_erro += "Content-Type: text/html\r\n\r\n";
           html_erro += "<!DOCTYPE html> <html> <head> <title>WiFi Settings</title> </head>";
           html_erro += "<body> <div style=\"position: absolute; margin: auto; top: 20%; left: 50%; \">"; 
           html_erro += "<div> Voce deve informar o nome da sua rede wifi e sua senha antes! </div>";
           html_erro += "<div> <a href=\"http://localhost/arduino_set/index.php\">";
           html_erro += "<input type=\"submit\" value=\"OK\" style=\"height: 80px; width: auto;\"/></a> </div> </div> </body>";
           html_erro += "</html>\n";
           
    client.print(html_erro);//Envia para o client a resposta;
    delay(1);
    Serial.println("Client disonnected");
    return 0;
    
  }else {
    
    //Apos retirar o conteudo util da mensagem ela e dividida em 2 partes - nome da rede(wifi_name) e senha da rede(wifi_pwd) do usuario.
    for(i = 0; i < web_return.length(); i++){
      if(web_return[i] == divisor[0]){
        for(j = i + 1; j < web_return.length(); j++){
          wifi_pwd += web_return[j];
        }
        break;
      }else{
        wifi_name += web_return[i];
      }
    }
  
    //Serial.println(wifi_name);
    //Serial.println(wifi_pwd);
    EEPROM.begin(512);
    EEPROM.put(0, wifi_name);
    EEPROM.put(0, wifi_pwd);
    EEPROM.commit();
    EEPROM.end();

    
    client.flush();
  
  
    //Pagina de retorno para o Client informando que os dados foram salvos;
    String html_ok = "HTTP/1.1 200 OK\r\n";        
           html_ok += "Content-Type: text/html\r\n\r\n";
           html_ok += "<!DOCTYPE html> <html> <head> <title>WiFi Settings</title> </head>";
           html_ok += "<body> <div style=\"position: absolute; margin: auto; top: 20%; left: 50%; \">"; 
           html_ok += "<div> Dash Button configurado! </div>";
           html_ok += "<div> <a href=\"http://localhost/arduino_set/Web/InterfaceWeb.php\">";
           html_ok += "<input type=\"submit\" value=\"OK\" style=\"height: 80px; width: auto;\"/></a> </div> </div> </body>";
           html_ok += "</html>\n";
  
    
    
    client.print(html_ok);//Envia para o client a resposta;
    delay(100);
    Serial.println("Client disonnected");
    
    return 1;
  
    // The client will actually be disconnected 
    // when the function returns and 'client' object is detroyed
    
  }
  
    
  

  
}

//configura o botao para o modo AccessPoint(AP)
void setupWiFiAP(){ 
  WiFi.mode(WIFI_AP);

  // Append the last two bytes of the MAC (HEX'd) to string to make unique
  uint8_t mac[WL_MAC_ADDR_LENGTH];
  WiFi.softAPmacAddress(mac);
  String macID = String(mac[WL_MAC_ADDR_LENGTH - 2], HEX) + String(mac[WL_MAC_ADDR_LENGTH - 1], HEX);
  macID.toUpperCase();
  
  String AP_NameString = "DashButton_" + macID;

  char AP_NameChar[AP_NameString.length() + 1];
  memset(AP_NameChar, AP_NameString.length() + 1, 0);

  for (int i=0; i<AP_NameString.length(); i++)
    AP_NameChar[i] = AP_NameString.charAt(i);
  
  WiFi.softAP(AP_NameChar, WiFiAP_PWD);

  
}


/** Load WLAN credentials from EEPROM */
/*
void loadCredentials(String ssid, String password) {
  //String ssid, password;

  Serial.println(EEPROM.get(0, ssid));
  Serial.println(EEPROM.get(0, password));
  //return ssid, password;
}
*/

/** Store WLAN credentials to EEPROM */
/*
void saveCredentials(String ssid, String password) {
  EEPROM.begin(512);
  EEPROM.put(0, ssid);
  EEPROM.put(0, password);
  EEPROM.commit();
  EEPROM.end();
}*/




void funcao_test(){

  Serial.println("Waiting");
  return;
}

void loop(){
  /*
  while(setupWiFiClient() == 0){
        setupWiFiClient();
      }
    
      if(setupWiFiClient() == 1){
        delay(5000);
        ESP.restart();
      }
    */
  delay(100);
  //Trocar de Modo AP para Client
  if(setupWiFiClient() == 1){
    ESP.restart();
  }else{
    setupWiFiClient();
  }

  Serial.println("EEPROM:");
  Serial.println(EEPROM.get(0, wifi_name));
  Serial.println(EEPROM.get(0, wifi_pwd));

  //do{
    //VerificaConexoesWiFIEMQTT();
    //EnviaEstadoOutputMQTT();
    //MQTT.loop();
  //}while();

  /*
  //garante funcionamento das conexões WiFi e ao broker MQTT
  //VerificaConexoesWiFIEMQTT();

  //envia o status de todos os outputs para o Broker no protocolo esperado
  EnviaEstadoOutputMQTT();

  //keep-alive da comunicação com broker MQTT
  MQTT.loop();
  */
  
}











