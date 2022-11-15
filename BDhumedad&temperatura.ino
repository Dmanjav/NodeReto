#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <DHT.h>

#define DHTPIN 2
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);
  
const char *red = "Tec-IoT";
const char *password = "spotless.magnetic.bridge";

String urlBase = "http://10.48.76.142/ejercicios/insertaTemperatura.php?valor=";
String extra = "&humedad=";
HTTPClient http;
WiFiClient clienteWiFi;

void setup() {
  abrirSerial();
  conectarRed();
  dht.begin();
}

void loop() {
  float temperatura = dht.readTemperature();
  float humedad = dht.readHumidity();
  String url = String(urlBase + String(temperatura)+ extra + String(humedad));
  Serial.println(url);

  if (http.begin(clienteWiFi, url)) {
    int codigo = http.GET(); // hace la peticion y regresa el codigo
    Serial.printf("Código %d \n", codigo);
  }
  http.end();
  Serial.print("Temperatura: ");
  Serial.println(temperatura);
  Serial.print("Humedad: ");
  Serial.println(humedad);
  delay(10000);
}

void abrirSerial(){
  Serial.begin(9600);
  delay(1000);
  Serial.println("Monitor Serial listo... \n");
}

void conectarRed(){
  Serial.println("Conectando...");
  WiFi.begin(red, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println(" Conectado a la red!");
}
