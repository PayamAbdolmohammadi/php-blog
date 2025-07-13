# 📰 PHP Blog Projekt

Ein einfaches PHP-Blog-System mit Admin-Panel, Benutzeroberfläche und MySQL-Datenbank – entwickelt mit nativem PHP ohne Frameworks.

## 🔧 Funktionen

- 📝 Artikelverwaltung (Erstellen, Bearbeiten, Löschen)
- 🧾 Kategorienverwaltung
- 💬 Kommentarverwaltung mit Freigabe oder Löschung
- 📁 Bilder-Upload für Beiträge
- 🔒 Admin-Login-System
- 🔍 Beitragssuche
- 📂 Strukturierte Dateiorganisation

## 🗂️ Projektstruktur

php-blog/
├── admin-panel/          → Adminbereich
├── assets/               → CSS, Fonts, Bilder
├── database/             → SQL-Dateien
├── include/              → Konfiguration & Layout
├── uploads/posts/        → Hochgeladene Bilder
├── index.php             → Startseite
├── search.php            → Suchseite
├── single.php            → Einzelbeitrag
└── README.md             → Diese Datei

## 🛠️ Voraussetzungen

- PHP ≥ 7.4
- MySQL
- Apache Server (z. B. mit XAMPP oder MAMP)

## ⚙️ Installation

1. Projekt herunterladen oder klonen:

   ```bash
   git clone https://github.com/PayamAbdolmohammadi/php-blog.git

 2. SQL-Datei importieren:
 • Öffne phpMyAdmin
 • Neue Datenbank z. B. php_blog erstellen
 • Datei database/php_course_blog.sql importieren
 3. include/config.php öffnen und Datenbankzugang anpassen:

$dbhost = 'localhost';
$dbname = 'php_blog';
$dbuser = 'root';
$dbpass = '';

 4. Projekt in Browser öffnen z. B.:

http://localhost:8080/php-blog/
5. Admin-Bereich aufrufen:

http://localhost:8080/php-blog/admin-panel/pages/auth/login.php
🔑 Standard-Login

Benutzername: ali@gmail.com
Passwort: 123456789

Diese Daten können in der Datenbank geändert werden.

📌 Hinweis

Dieses Projekt wurde mit dem Ziel erstellt, Grundlagen in objektorientierter PHP-Programmierung zu üben und die Vorbereitung auf Frameworks wie Laravel zu ermöglichen.

👨‍💻 Entwickler

Payam Abdolmohammadi
📧 payamabdolmohammadii@gmail.com
📍 Stuttgart, Deutschland

⸻

⭐ Lizenz

Dieses Projekt steht unter keiner speziellen Lizenz und darf zu Lernzwecken verwendet werden.
