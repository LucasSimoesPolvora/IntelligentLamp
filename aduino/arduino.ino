#include <WiFi.h>
#include <HTTPClient.h>

#define PIR_PIN 17          // Pin du capteur PIR (détecteur de mouvement)
#define SOUND_PIN 4         // Pin du capteur de son (KY-037)
#define LED_INTERNAL_PIN 2  // LED intégrée sur l'ESP32
#define LED_EXTERNAL_PIN 5  // LED externe connectée au GPIO D5
#define SOUND_THRESHOLD 450 // Seuil pour détecter un son élevé
#define LIGHT_ON_DURATION 1000  // Durée pendant laquelle la lumière reste allumée (5 secondes)

const char* ssid = "OPPO A17";        // SSID Wi-Fi
const char* password = "mynegrito";   // Mot de passe Wi-Fi
const char* postUrl = "http://51.103.218.231/insert/notification"; // URL du serveur pour envoyer les notifications

unsigned long lastMotionTime = 0;
bool lightOn = false;
int mouvement_count = 0;
bool isWiFiConnected = false;  // Indique si nous sommes connectés au Wi-Fi

void setup() {
  pinMode(PIR_PIN, INPUT);          // Configurer le PIR en entrée
  pinMode(SOUND_PIN, INPUT);        // Configurer le capteur de son en entrée
  pinMode(LED_INTERNAL_PIN, OUTPUT);// Configurer la LED intégrée comme sortie
  pinMode(LED_EXTERNAL_PIN, OUTPUT);// Configurer la LED externe (pin D5) comme sortie

  Serial.begin(115200);

  Serial.println("Système prêt. En attente de détection de mouvement ou de son...");
}

void loop() {
  detecterMouvement();
  detecterSon();
  delay(100);  // Petite pause pour éviter les lectures trop fréquentes
}

// Fonction pour détecter les mouvements
void detecterMouvement() {
  int pirState = digitalRead(PIR_PIN); // Lire l'état du capteur PIR

  if (pirState == HIGH) {
    Serial.println("Mouvement détecté !");
    lastMotionTime = millis(); // Mettre à jour le temps du dernier mouvement
    mouvement_count++; // Incrémenter le compteur de mouvements

    // Allumer la LED externe (D5) pendant 1 seconde
    digitalWrite(LED_EXTERNAL_PIN, HIGH);
    delay(1000);  // Garder la LED allumée pendant 1 seconde
    digitalWrite(LED_EXTERNAL_PIN, LOW);
  }
}

// Fonction pour détecter le son
void detecterSon() {
  int soundValue = analogRead(SOUND_PIN); // Lire la valeur du capteur de son

  if (soundValue > SOUND_THRESHOLD) {
    Serial.println("Son élevé détecté !");

    // Allumer et faire clignoter la LED interne pour signaler
    for (int i = 0; i < 3; i++) {
      digitalWrite(LED_INTERNAL_PIN, HIGH);
      delay(200);
      digitalWrite(LED_INTERNAL_PIN, LOW);
      delay(200);
    }

    // Connecter au Wi-Fi et envoyer les données si ce n'est pas déjà fait
    if (!isWiFiConnected) {
      connectWiFi();       // Se connecter au Wi-Fi
      envoyerDonnees();    // Envoyer les données au serveur
      disconnectWiFi();    // Se déconnecter du Wi-Fi pour économiser de l'énergie
    }
  }
}

// Fonction pour se connecter au Wi-Fi
void connectWiFi() {
  WiFi.begin(ssid, password);
  Serial.println("Tentative de connexion au Wi-Fi...");

  // Attendre jusqu'à ce que la connexion soit établie
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  
  Serial.println("Connecté au réseau Wi-Fi");
  Serial.print("Adresse IP: ");
  Serial.println(WiFi.localIP());

  isWiFiConnected = true;  // Mettre à jour l'état de connexion
}

// Fonction pour déconnecter le Wi-Fi
void disconnectWiFi() {
  if (WiFi.status() == WL_CONNECTED) {
    WiFi.disconnect();
    Serial.println("Wi-Fi déconnecté pour économiser de l'énergie.");
    isWiFiConnected = false;
  }
}

// Fonction pour envoyer les données au serveur
void envoyerDonnees() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(postUrl);
    http.addHeader("Content-Type", "application/json");

    // Aquí debes reemplazar "your-csrf-token" con el token real
    http.addHeader("X-CSRF-TOKEN", "your-csrf-token");

    String jsonPayload = "{\"title\": \"Alerte !\", \"message\": \"Merci de bien vouloir vérifier !\", \"fkLampadaire\": 1}";
    int httpResponseCode = http.POST(jsonPayload);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Réponse du serveur: " + response);
    } else {
      Serial.println("Erreur lors de l'envoi des données.");
    }
    http.end();
  } else {
    Serial.println("Non connecté à Wi-Fi.");
  }
}