//include das bibliotecas utilizadas
#include <ESP8266WiFi.h> //biblioteca utilizada para realizar a conexao do botao a rede.
#include <ESP8266WebServer.h> //utilizada para criar um webserver dentro da placa
#include <EEPROM.h> //utilizada para armazenar dados na eeprom (memoria nao-volatil) da placa
#include <PubSubClient.h> //utilizada para realizar a comunicacao entre o botao e a pagina web

ESP8266WebServer server(80); //inicia um webserver na porta 80

//os topicos de envio e escuta sao unicos para cada botao, 
//caso contrario existe a chance de controlar e monitorar outro botao.
#define TOPICO_SUBSCRIBE "botao01_Sub"     //tópico MQTT de escuta
#define TOPICO_PUBLISH   "botao01_Pub"    //tópico MQTT de envio de informações para Broker

//o id, utilizado para identificacao de sessao, tambem sao unicos por botao,
//se dois clients conectarem utilizando o mesmo ID ao broker, um deles sera desconectado automaticamente.                                                   
#define ID_MQTT  "botao01"     //id mqtt (para identificação de sessão)
                              
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

const int botao = 5; //define a saida do botao na porta 5 (D1) 

//as variaveis ssid e passphrase definem o nome e senha da rede criada pelo boto no modo AP.
const char* ssid = "MeuBotao_17"; 
const char* passphrase = "default";

String st;
String content;

//variaveis para salvar o ssid e a senha da rede domestica informada pelo usuario, na qual o botao deve se conectar.
String esid;
String epass = "";

//variavel criada para receber o estado do botao, se esta pressionado ou nao. Retorna HIGH ou LOW
int estadoBotao = 0;

//esse flag recebe o valor true apos o botao se conectar a rede domestica informada
bool flag = false;

//variavel responsavel por receber o status da requisicao web.
int statusCode;

// MQTT
const char* BROKER_MQTT = "iot.eclipse.org"; //URL do broker MQTT que se deseja utilizar
int BROKER_PORT = 1883; // Porta do Broker MQTT

WiFiClient espClient;
PubSubClient MQTT(espClient); // Instancia o Cliente MQTT passando o objeto espClient
char EstadoSaida = '0';  //variável que armazena o estado atual da saída

//Funcoes:
void initOutput(); //incializa as saidas da placa - O botao como INPUT e o LED da placa como OUTPUT.
void inicializaBotao(); //funcao para ler os dados de rede e senha salvos na EEPROM da placa e assim conecta-la a rede do usuario.
void initMQTT(); //inicializa parâmetros de conexão MQTT(endereço do broker, porta e seta função de callback).
bool testWifi(void); //testa a conexao wifi do botao, se ele nao conseguir se conectar na rede do usuario a placa entra em modo AP e aguarda a insercao de novos dados para conexao.
void launchWeb(int webtype); //apos conectado na rede do usuario,  chama a funcao responsavel por criar o webserver e redireciona o usuario a pagina web do ecommerce
void setupAP(void); //configura o botao no modo AP. Exibe as conexoes de rede disponiveis e aguarda o usuario informar o nome e senha para a rede que ele deseja que o botao se conecte.
void createWebServer(int webtype); //cria e configura um webserver na placa.
void mqtt_callback(char* topic, byte* payload, unsigned int length); //função de callback: esta função é chamada toda vez que uma informação de um dos tópicos subescritos chega. 
                                                                     //Neste caso ela é utilzada para interpretar se o usuario enviou um comando atraves da pagina web para resetar a placa 
                                                                     //e configura-la em uma nova rede.
void reconnectMQTT();//reconecta-se ao broker MQTT (caso ainda não esteja conectado ou em caso de a conexão cair) em caso de sucesso na conexão ou reconexão, o subscribe dos tópicos é refeito.
void reconectWiFi();//verifica conexao WiFi.
void VerificaConexoesWiFIEMQTT(void);//verifica o estado das conexões WiFI e ao broker MQTT. Em caso de desconexão (qualquer uma das duas), a conexão é refeita.
void EnviaEstadoOutputMQTT(void);//envia ao Broker o estado atual do output.Esta funcao é responsavel por enviar a pagina web a informacao de que o botao foi pressionado.


//Essa funcao é chamada quando o programa comeca, utilizada para iniciar variaveis e funcoes. 
//é executada somente uma vez, quando o Arduino é iniciado ou resetado.
void setup() {
  initOutput();
  inicializaBotao();
  initMQTT();
}

bool testWifi(void) {
  int c = 0;
  Serial.println("Aguardano WiFi conectar");  
  while ( c < 20 ) {
    if (WiFi.status() == WL_CONNECTED) { 
      return true; 
    } 
    delay(500);    
    Serial.print('.');
    c++;
  }
  Serial.println("");
  Serial.println("Tentativas de conexao esgotadas. Ativando modo AP.");
  return false;
} 

void launchWeb(int webtype) {
  Serial.println("");
  Serial.println("Conectado a rede WiFi");
  
  Serial.print("Local IP: ");
  Serial.println(WiFi.localIP());
  Serial.print("SoftAP IP: ");
  Serial.println(WiFi.softAPIP());
  createWebServer(webtype);
  // Start the server
  server.begin();
  Serial.println("Server iniciado");
   
}

void setupAP(void) {
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();
  delay(100);
  int n = WiFi.scanNetworks();
  Serial.println("scan done");
  if (n == 0)
    Serial.println("Nenhuma rede encontrada.");
  else
  {
    Serial.print(n);
    Serial.println("Redes encontradas");
    for (int i = 0; i < n; ++i)
     {
      // Imprimi o SSID e a senha para cada rede encontrada.
      Serial.print(i + 1);
      Serial.print(": ");
      Serial.print(WiFi.SSID(i));
      Serial.print(" (");
      Serial.print(WiFi.RSSI(i));
      Serial.print(")");
      Serial.println((WiFi.encryptionType(i) == ENC_TYPE_NONE)?" ":"*");
      delay(10);
     }
  }
  Serial.println(""); 
  st = "<ol>";
  for (int i = 0; i < n; ++i)
    {
      // Print SSID and RSSI for each network found
      st += "<li>";
      st += WiFi.SSID(i);
      st += " (";
      st += WiFi.RSSI(i);
      st += ")";
      st += (WiFi.encryptionType(i) == ENC_TYPE_NONE)?" ":"*";
      st += "</li>";
    }
  st += "</ol>";
  delay(100);
  WiFi.softAP(ssid, passphrase, 6);
  Serial.println("softap");
  launchWeb(1);
  Serial.println("over");
}

void createWebServer(int webtype)
{
  if ( webtype == 1 ) {
    server.on("/", []() {
        IPAddress ip = WiFi.softAPIP();
        String ipStr = String(ip[0]) + '.' + String(ip[1]) + '.' + String(ip[2]) + '.' + String(ip[3]);
        content = "<!DOCTYPE html> <html> <head> <title>Wifi Settings</title> <meta http-equiv=\"refresh\" content=\"2; URL='http://localhost/Config_Botao/index.php'\" /> </head>"; 
        content += "<body> <div style=\"border:0px solid red; position: absolute; margin: auto; top: 20%; left: 45%;\">"; 
        content += "<div> Redirecionando... </div> </div> </body> </html>";
        
        server.send(200, "text/html", content);  
    });
    server.on("/cleareeprom", []() {
      content = "<!DOCTYPE html> <html> <head> <title>Wifi Settings</title> <meta http-equiv=\"refresh\" content=\"0; URL='http://localhost/Config_Botao/index.php'\" /> </head>"; 
      content += "<body> <div style=\"border:0px solid red; position: absolute; margin: auto; top: 20%; left: 45%;\">"; 
      content += "<div> Redirecionando... </div> </div> </body> </html>";
      server.send(200, "text/html", content);
      Serial.println("clearing eeprom");
      for (int i = 0; i < 512; ++i) { EEPROM.write(i, 0); }
      EEPROM.commit();
      Serial.println("EEPROM CLEAR");
      flag = false;
    });
    server.on("/setting", []() {
        String qsid = server.arg("ssid");
        String qpass = server.arg("pass");
        if (qsid.length() > 0 && qpass.length() > 0) {
          Serial.println("clearing eeprom");
          for (int i = 0; i < 96; ++i) { EEPROM.write(i, 0); }
          Serial.println(qsid);
          Serial.println("");
          Serial.println(qpass);
          Serial.println("");
            
          Serial.println("writing eeprom ssid:");
          for (int i = 0; i < qsid.length(); ++i)
            {
              EEPROM.write(i, qsid[i]);
              Serial.print("Wrote: ");
              Serial.println(qsid[i]); 
            }
          Serial.println("writing eeprom pass:"); 
          for (int i = 0; i < qpass.length(); ++i)
            {
              EEPROM.write(32+i, qpass[i]);
              Serial.print("Wrote: ");
              Serial.println(qpass[i]); 
            }    
          EEPROM.commit();
          //content = "{\"Success\":\"saved to eeprom... reset to boot into new wifi\"}";
          content = "<!DOCTYPE html> <html> <head> <title>Wifi Settings</title> <meta http-equiv=\"refresh\" content=\"2; URL='http://localhost/e-commerce/index.html'\" /></head>"; 
          content += "<body><div style=\"border:0px solid red; position: absolute; margin: auto; top: 20%; left: 45%;\"><div> Parabens! Seu botao foi configurado em sua rede. </div> <br>"; 
          content += "<div> Redirecionando... </div> </div> </body> </html>";
          statusCode = 200;
          
        } else {
          //content = "{\"Error\":\"404 not found\"}";
          content = "<!DOCTYPE html> <html> <head> <title>Wifi Settings</title> <style type=\"text/css\"> </style> </head> <body> <div style=\"border:1px solid red; position: absolute; margin: auto; top: 20%; left: 45%;\"> <div style=\"border:1px solid red;\"> ERRO 404 Not Found! </div> </div> </body> </html>";
          statusCode = 404;
          Serial.println("Sending 404");
          delay(100);
        }
        //server.send(statusCode, "application/json", content);
        server.send(statusCode, "text/html", content);
        delay(100);
        
        ESP.restart();
    });
  } else if (webtype == 0) {
    flag = true;
    server.on("/", []() {
      IPAddress ip = WiFi.localIP();
      String ipStr = String(ip[0]) + '.' + String(ip[1]) + '.' + String(ip[2]) + '.' + String(ip[3]);
      server.send(200, "application/json", "{\"IP\":\"" + ipStr + "\"}");
      //flag = true;
      
    });
    server.on("/cleareeprom", []() {
      content = "<!DOCTYPE html> <html> <head> <title>Wifi Settings</title> <meta http-equiv=\"refresh\" content=\"0; URL='http://localhost/Config_Botao/index.php'\" /> </head>"; 
      content += "<body> <div style=\"border:0px solid red; position: absolute; margin: auto; top: 20%; left: 45%;\">"; 
      content += "<div> Redirecionando... </div> </div> </body> </html>";
      server.send(200, "text/html", content);
      Serial.println("clearing eeprom");
      for (int i = 0; i < 512; ++i) { EEPROM.write(i, 0); }
      EEPROM.commit();
      Serial.println("EEPROM CLEAR");
      flag = false;
    });
  }
}

void inicializaBotao(){
  Serial.begin(115200);
  EEPROM.begin(512);
  delay(10);
  Serial.println();
  Serial.println();
  Serial.println("Startup");
  
  //ead eeprom for ssid and pass
  Serial.println("Reading EEPROM ssid");
  for (int i = 0; i < 32; ++i)
    {
      esid += char(EEPROM.read(i));
    }
    
  Serial.print("SSID: ");
  Serial.println(esid);
  
  Serial.println("Reading EEPROM pass");
  for (int i = 32; i < 96; ++i)
    {
      epass += char(EEPROM.read(i));
    }
  Serial.print("PASS: ");
  Serial.println(epass);  
  if ( esid.length() > 1 ) {
      WiFi.begin(esid.c_str(), epass.c_str());
      if (testWifi()) {
        launchWeb(0);
        return;
      } 
  }
  setupAP();
}

/**************MQTT**************/
 
//Função: inicializa parâmetros de conexão MQTT(endereço do 
//        broker, porta e seta função de callback)
void initMQTT() 
{
    MQTT.setServer(BROKER_MQTT, BROKER_PORT);   //informa qual broker e porta deve ser conectado
    MQTT.setCallback(mqtt_callback);            //atribui função de callback (função chamada quando qualquer informação de um dos tópicos subescritos chega)
}
 
//Função: função de callback 
//        esta função é chamada toda vez que uma informação de 
//        um dos tópicos subescritos chega)
void mqtt_callback(char* topic, byte* payload, unsigned int length) 
{
    String msg;

    //obtem a string do payload recebido
    for(int i = 0; i < length; i++) 
    {
       char c = (char)payload[i];
       msg += c;
    }

    Serial.println("MQTT Callback:");
    Serial.println(msg);
    
    
    
    //toma ação dependendo da string recebida:
    if (msg.equals("R"))
    {
        for (int i = 0; i < 512; ++i) { EEPROM.write(i, 0); }
        EEPROM.commit();
        Serial.println("EEPROM CLEAR");
        flag = false;
        
        content = "<!DOCTYPE html> <html> <head> <title>Wifi Settings</title> <meta http-equiv=\"refresh\" content=\"2; URL='http://localhost/Config_Botao/index.php'\" /> </head>"; 
        content += "<body> <div style=\"border:0px solid red; position: absolute; margin: auto; top: 20%; left: 45%;\">"; 
        content += "<div> Redirecionando... </div> </div> </body> </html>";
        
        server.send(200, "text/html", content);
        ESP.restart();  
    }
    
    
}
 
//Função: reconecta-se ao broker MQTT (caso ainda não esteja conectado ou em caso de a conexão cair)
//        em caso de sucesso na conexão ou reconexão, o subscribe dos tópicos é refeito.
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
void reconectWiFi() 
{
    //se já está conectado a rede WI-FI, nada é feito. 
    //Caso contrário, são efetuadas tentativas de conexão
    if (WiFi.status() == WL_CONNECTED)
        return;
        
    // Conecta na rede WI-FI
    WiFi.begin(esid.c_str(), epass.c_str());
    
    while (WiFi.status() != WL_CONNECTED) 
    {
        delay(100);
        Serial.print(".");
    }
  
    Serial.println();
    Serial.print("Conectado com sucesso na rede ");
    Serial.print(esid);
    Serial.println("IP obtido: ");
    Serial.println(WiFi.localIP());
}

//Função: verifica o estado das conexões WiFI e ao broker MQTT. 
//        Em caso de desconexão (qualquer uma das duas), a conexão
//        é refeita.
void VerificaConexoesWiFIEMQTT(void)
{
    if (!MQTT.connected()) 
        reconnectMQTT(); //se não há conexão com o Broker, a conexão é refeita
    
     reconectWiFi(); //se não há conexão com o WiFI, a conexão é refeita
}

//Função: envia ao Broker o estado atual do output 
void EnviaEstadoOutputMQTT(void)
{
    
    delay(500);
    estadoBotao = digitalRead(botao);
    
    if(estadoBotao == HIGH){
      digitalWrite(LED_BUILTIN, LOW);
      MQTT.publish(TOPICO_PUBLISH, "N");
      
    }else{
      digitalWrite(LED_BUILTIN, HIGH);
      MQTT.publish(TOPICO_PUBLISH, "C");
    } 
    
    Serial.println("- Estado da saida D0 enviado ao broker!");
}

//Função: inicializa o output em nível lógico baixo
void initOutput(void)
{
    //IMPORTANTE: o Led já contido na placa é acionado com lógica invertida (ou seja,
    //enviar HIGH para o output faz o Led apagar / enviar LOW faz o Led acender)
    pinMode(botao, INPUT);
    pinMode(LED_BUILTIN, OUTPUT); 
    digitalWrite(LED_BUILTIN, HIGH);          
}

void loop() {
  server.handleClient();
  
  //essas funcoes devem ser executadas somete apos a confirmacao de conexao na rede.
  while(flag){
    VerificaConexoesWiFIEMQTT();
    EnviaEstadoOutputMQTT();
    MQTT.loop();
  }
}
