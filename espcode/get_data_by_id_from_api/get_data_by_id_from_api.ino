// Copyright 2024 ariefsetyonugroho
// 
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
// 
//     https://www.apache.org/licenses/LICENSE-2.0
// 
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

#include <WiFi.h>
#include <ASNProject.h>

// Wi-Fi Credentials
const char* ssid = "Itel"; // Change this with your SSID
const char* password = "qwertyuiop"; // Change this with your password SSID

ASNProject asnproject;

//API Endpoint
const char* serverName = "http://192.168.214.56:8000/api/limits"; // Change this with your api url

void setup() {
  Serial.begin(115200);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan ke WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("\nWiFi terhubung");

  String response = asnproject.getById(serverName, "1234"); // Change "3" to your id
  Serial.println("Server Response: " + response);

  // Alokasi buffer JSON (gunakan ukuran yang cukup besar jika ragu)
  const size_t capacity = 1024;
  DynamicJsonDocument doc(capacity);

  // Parse JSON
  DeserializationError error = deserializeJson(doc, response);
  if (error) {
    Serial.print("Gagal parse JSON: ");
    Serial.println(error.c_str());
    return;
  }

  // Ambil data yang diinginkan
  String status = doc["status"].as<String>();
  String uid = doc["data"]["uid"].as<String>();
  String name = doc["data"]["name"].as<String>();
  String role = doc["data"]["role"].as<String>();
  String limit = doc["data"]["limit"].as<String>();
  String createdAt = doc["data"]["created_at"].as<String>();
  String updatedAt = doc["data"]["updated_at"].as<String>();

  // Tampilkan hasil
  Serial.println("Status" + status);
  Serial.println("UID: " + uid);
  Serial.println("Name: " + name);
  Serial.println("Role: " + role);
  Serial.println("Limit: " + limit);
  Serial.println("Created At: " + createdAt);
  Serial.println("Updated At: " + updatedAt);
}

void loop() {}