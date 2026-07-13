# Stichprobenrechner für unendliche und endliche Grundgesamtheiten (v2.0)

Ein didaktisch aufbereitetes PHP-Framework zur stichprobenmethodischen Herleitung und Ermittlung der erforderlichen Mindest-Stichprobengröße nach mathematischen Standardformeln.

## Autoren & Akademischer Ursprung
* **Entwickler:** Dr. Uwe Janatzek, M.A. (FLEDISoft MemexXa)
* **Ursprung:** Erstellt für die "Lehrveranstaltung 3 - Vertiefung wissenschaftlicher Methoden" im Rahmen der Propädeutik-Seminare (B.A.-Studiengänge) an der **Evangelischen Hochschule Bochum**.

## Praxisnachweis & Referenzierung
Dieses Werkzeug besitzt nachgewiesene Relevanz in der akademischen Lehre, Forschung und Rechtsprechung. Es wurde u. a. im Beschluss des **Verwaltungsgerichtshofs Baden-Württemberg vom 20.04.2020 (Az. 4 S 3276/19, ECLI:DE:VGHBW:2020:0420.4S3276.19.00)** als stichprobentheoretisches Referenzwerkzeug gewürdigt.
* **Historische Live-URL:** http://www.fledisoft.de/stichprobengroesse_berechnen.php
* **Gerichtlicher Permanentlink:** https://www.landesrecht-bw.de/perma?d=NJRE001420817

## Features
* **Mathematische Genauigkeit:** Berechnung für endliche und unendliche Grundgesamtheiten auf Basis etablierter statistischer Standardformeln.
* **Didaktischer Fokus:** Der Code wurde bewusst linear, barrierearm und ohne komplexe Framework-Abstraktionen gestaltet, um Lehrenden und Studierenden aus den Sozialwissenschaften ohne tiefe Informatik-Kenntnisse die Nachvollziehbarkeit und Modifikation zu erleichtern.
* **Zufallsgenerator:** Integrierte datenbasierte Ziehung von Zufallsnummern aus der Grundgesamtheit, inklusive automatischer Fehlerkorrektur und Berechnung notwendiger Bruttostichproben (Fragebogenversand) anhand geschätzter Rücklaufquoten.

## Systemvoraussetzungen
* **Laufzeitumgebung:** Ein beliebiger Webserver (z. B. Apache, Nginx, IIS) mit installierter PHP-Umgebung.
* **Kompatibilität:** Ausgelegt auf maximale Abwärtskompatibilität und "Green IT" (voll lauffähig ab PHP-Version 4.3 bis hin zu modernen PHP 8.x Versionen).
* **Abhängigkeiten:** Keine. Es werden keine externen Frameworks, Bibliotheken oder SQL-Datenbanken benötigt. Das Skript arbeitet komplett autark.

## Installations- und Betriebsanleitung (Step-by-Step)

### Option A: Installation auf einem Webserver (Shared Hosting / Eigener Server)
1. **Datei entpacken:** Entpacken Sie dieses ZIP-Archiv auf Ihrem Computer. Sie erhalten die Datei `stichprobengroesse_berechnen_v2.0.php`.
2. **Hochladen:** Laden Sie die Datei `stichprobengroesse_berechnen_v2.0.php` per SFTP/FTP (z. B. mit FileZilla) auf Ihren Webserver in das gewünschte öffentliche Verzeichnis (meistens `public_html`, `www` oder `htdocs`) hoch.
3. **Rechte prüfen:** Stellen Sie sicher, dass die Datei lesbar ist (Standard-Dateirechte `0644` oder `rwxr-xr-x` sind völlig ausreichend).
4. **Aufrufen:** Öffnen Sie Ihren Webbrowser und rufen Sie die URL auf, unter der Sie die Datei abgelegt haben (z. B. `https://ihre-domain.de/stichprobengroesse_berechnen_v2.0.php`). Das Tool steht sofort einsatzbereit zur Verfügung.

### Option B: Lokaler Betrieb auf dem eigenen PC (für Lehre & Offline-Nutzung)
Wenn Sie keinen öffentlichen Webserver besitzen, können Sie das Tool lokal auf Ihrem Windows-, Mac- oder Linux-Rechner ausführen:
1. **Lokale PHP-Umgebung installieren:** Laden Sie ein kostenloses Softwarepaket wie **XAMPP** (https://www.apachefriends.org) oder **MAMP** herunter und installieren Sie es. Dieses Paket simuliert einen lokalen Webserver auf Ihrem PC.
2. **Datei ablegen:** Kopieren Sie die Datei `stichprobengroesse_berechnen_v2.0.php` in das lokale Web-Verzeichnis der Software:
   * Bei XAMPP: C:\xampp\htdocs\
   * Bei MAMP: /Applications/MAMP/htdocs/
3. **Server starten:** Öffnen Sie das XAMPP/MAMP Control Panel und starten Sie die Module "Apache" (Webserver).
4. **Im Browser aufrufen:** Öffnen Sie Ihren Webbrowser und tippen Sie in die Adresszeile ein: `http://localhost/stichprobengroesse_berechnen_v2.0.php`. Das Tool läuft nun komplett offline auf Ihrem Gerät.

## Nutzungsbedingungen / Lizenz
Freigegeben für nicht-kommerzielle Zwecke, insbesondere für die akademische Lehre und Forschung. Modifikationen und Weiterverbreitung sind unter Beibehaltung der Urheberangaben und zu denselben Bedingungen gestattet (Copyleft / CC BY-NC-SA 4.0). Details entnehmen Sie bitte dem Lizenz-Header direkt im Quelltext der PHP-Datei.