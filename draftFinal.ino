//DHT
  #include <DHT.h>
  #define DHTPIN 2
  #define DHTTYPE DHT11
  DHT dht(DHTPIN, DHTTYPE);

//Red
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  const char *red = "Tec-IoT";
  const char *password = "spotless.magnetic.bridge";
  HTTPClient http;
  WiFiClient clienteWiFi;
  
//MQ135
  #include "MQ135.h"
  #define VOLTAGE_MEASURES 10
  #define VOLTAGE_MEASURES_DELAY_MS 20  //ms
  MQ135 mq135;
  const byte analogInputPin = A0;
  const float R0 = 11668.05;
  const float ADC_VOLTAGE = 3.3;
  const int ADC_MAX_VALUE = 1023;  // valor en bits
  const float a_CO = 578.15;
  const float b_CO = -3.916;
  const float a_CO2 = 113.42;
  const float b_CO2 = -2.859;

void setup() {
  abrirSerial();
  dht.begin();
  pinMode(analogInputPin, INPUT);
  mq135.begin(R0);
  abrirSerial();
  conectarRed();
}

void loop() {
    //Obtener lecturas de sensores
    float temperatura = dht.readTemperature();
    float humedad = dht.readHumidity();
    float sensor_voltage = getSensorVoltage();
    float ppmco = mq135.getPPM(a_CO, b_CO, sensor_voltage);
    float ppmco2 = mq135.getPPM(a_CO2, b_CO2, sensor_voltage);
    float lluvia = !digitalRead(0);

    //Enviar lecturas de sensores
    enviarTemperatura(temperatura);
    enviarHumedad(humedad);
    enviarPpmco(ppmco);
    enviarPpmco2(ppmco2);
    enviarLluvia(lluvia);
    Serial.println();
    delay(10000);
}

float getSensorVoltage() {
  float mean_sensor_voltage = 0.0;
  for (int i = 0; i < VOLTAGE_MEASURES; i++) {
    float sensor_analog_read = analogRead(analogInputPin);
    float sensor_voltage = sensor_analog_read * (ADC_VOLTAGE / ADC_MAX_VALUE);
    mean_sensor_voltage = mean_sensor_voltage + sensor_voltage;
    delay(VOLTAGE_MEASURES_DELAY_MS);
  }
  mean_sensor_voltage = mean_sensor_voltage / VOLTAGE_MEASURES;
  return mean_sensor_voltage;
}

void abrirSerial() {
    Serial.begin(9600);
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

//Envios de lecturas:
void enviarTemperatura(float temperatura){
    String urlTemperatura = String("http://10.48.72.56/ejercicios/draftTemperatura.php?temperatura=" + String(temperatura));
    Serial.println(urlTemperatura);
    if (http.begin(clienteWiFi, urlTemperatura)) {
        int codigo = http.GET(); // hace la peticion y regresa el codigo
        Serial.printf("Código %d \n", codigo);
    }
    Serial.print("Temperatura: ");
    Serial.println(temperatura);
    http.end();
}

void enviarHumedad(float humedad){
  String urlHumedad = String("http://10.48.72.56/ejercicios/draftHumedad.php?humedad=" + String(humedad));
  Serial.println(urlHumedad);
  if (http.begin(clienteWiFi, urlHumedad)) {
    int codigo = http.GET(); // hace la peticion y regresa el codigo
    Serial.printf("Código %d \n", codigo);
  }
  Serial.print("Humedad: ");
  Serial.println(humedad);
  http.end();
}

void enviarPpmco(float ppmco){
  String urlPpmco = String("http://10.48.72.56/ejercicios/draftPpmco.php?ppmco=" + String(ppmco));
  Serial.println(urlPpmco);
  if (http.begin(clienteWiFi, urlPpmco)) {
    int codigo = http.GET(); // hace la peticion y regresa el codigo
    Serial.printf("Código %d \n", codigo);
  }
  Serial.print("Ppm de co: ");
  Serial.println(ppmco);
  http.end();
}

void enviarPpmco2(float ppmco2){
  String urlPpmco2 = String("http://10.48.72.56/ejercicios/draftPpmco2.php?ppmco2=" + String(ppmco2));
  Serial.println(urlPpmco2);
  if (http.begin(clienteWiFi, urlPpmco2)) {
    int codigo = http.GET(); // hace la peticion y regresa el codigo
    Serial.printf("Código %d \n", codigo);
  }
  Serial.print("Ppm de co2: ");
  Serial.println(ppmco2);
  http.end();
}

void enviarLluvia(float lluvia){
  String urlLluvia = String("http://10.48.72.56/ejercicios/draftLluvia.php?lluvia=" + String(lluvia));
  Serial.println(urlLluvia);
  if (http.begin(clienteWiFi, urlLluvia)) {
    int codigo = http.GET(); // hace la peticion y regresa el codigo
    Serial.printf("Código %d \n", codigo);
  }
  Serial.print("Lluvia: ");
  Serial.println(lluvia);
  http.end();
}
