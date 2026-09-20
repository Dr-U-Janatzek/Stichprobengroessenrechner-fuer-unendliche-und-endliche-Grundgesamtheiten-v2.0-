# Calculation of Required Minimum Sample Size (Version 2.0)

[ 🇬🇧 English Documentation ](#english) | [ 🇩🇪 Deutsche Dokumentation ](#deutsch)

---

<a name="english"></a>
## 🇬🇧 English Documentation

An educationally optimized PHP framework and online calculator designed for the methodological derivation and determination of the required minimum sample size for both finite and infinite populations based on standard statistical formulas. 

This tool is specifically engineered for educators, researchers in the social sciences, and students. It features linear, highly accessible code structure without framework abstraction to ensure effortless comprehension and modification.

[![DOI](https://zenodo.org)](https://doi.org)

---

### 🔬 Academic Origin & Legal Reference

* **Academic Foundation:** Originally developed for *Lecture 3 – Advanced Scientific Methods* within the Propedeutic Seminars (B.A. programs) at the **Evangelische Hochschule Bochum** (University of Applied Sciences). It remains widely utilized in academic teaching and empirical research.
* **Judicial Reference & Validation:** Legally recognized and cited as a theoretical reference tool by the **Higher Administrative Court of Baden-Württemberg (Verwaltungsgerichtshof Baden-Württemberg)** in its decision dated April 20, 2020 (*Az. 4 S 3276/19, ECLI:DE:VGHBW:2020:0420.4S3276.19.00*).
  * Judicial Permanent Link: [Landesrecht BW (NJRE001420817)](https://www.landesrecht-bw.de/perma?d=NJRE001420817)

---

### ⚙️ Statistical Formulas Implemented

The framework executes deterministic sample size calculations based on classical statistical sampling theory:

#### 1. Infinite Population (Unendliche Grundgesamtheit)
Used when the total population size is unknown or practically limitless:

\[n \ge \frac{z^2 \cdot P \cdot Q}{\epsilon^2}\]

#### 2. Finite Population (Endliche Grundgesamtheit)
Used when the precise total size of the population (N) is known, applying the finite population correction:

\[n \ge \frac{N}{1 + \frac{(N - 1) \cdot \epsilon^2}{z^2 \cdot P \cdot Q}}\]

*Where:*
*   n = Required minimum sample size (automatically rounded up to the next integer).
*   z = Confidence level value derived from the standard normal distribution (e.g., \(95\% \Rightarrow z = 1.96\)).
*   P = Estimated variance / baseline proportion of the target characteristic in the population (default value: \(50\% \Rightarrow 0.5\) for maximum variance protection).
*   Q = Complement of the variance (1 - P).
*   ε = Tolerable margin of error / confidence interval width (e.g., \(5\% \Rightarrow 0.05\)).
*   N = Total population size.

---

### 🚀 Core Features

* **Dual-Mode Calculation:** Computes precise sample thresholds for both finite and infinite target pools.
* **Didactic Implementation:** Linear, clean code layout void of complex abstractions, making the mathematical logic step-by-step transparent for non-computer scientists.
* **Response Rate Estimator:** Integrates an empirical gross-sample calculator. Computes the necessary brute volume of physical or digital questionnaires to be distributed based on projected response rates (R): \(\text{Gross Volume} = \frac{n}{R} \cdot 100\).
* **Random Data Generator:** Includes a server-side random number sequence extractor to draw unbiased baseline samples from finite populations.
* **Green IT & Heritage Support:** Fully standalone deployment architecture requiring **zero database overhead** or external libraries. Backwards compatible down to **PHP 4.3** up to modern **PHP 8.x**.

---

### 🔧 Installation & Deployment

#### Option A: Server Deployment (Shared Hosting / Dedicated Host)
1. Extract the repository file `stichprobengroesse_berechnen_v2.0.php`.
2. Upload the file to your web server's public directory (`public_html`, `www`, or `htdocs`) via SFTP/FTP.
3. Ensure file read permissions are set appropriately (Standard `0644`).
4. Execute via browser: `https://your-domain.com`.

#### Option B: Local Evaluation (Offline Lehre)
1. Deploy a local stack environment such as XAMPP or MAMP.
2. Copy `stichprobengroesse_berechnen_v2.0.php` into the local root (`C:\xampp\htdocs\` or `/Applications/MAMP/htdocs/`).
3. Boot the local Web Server (Apache/Nginx).
4. Run locally via browser: `http://localhost/stichprobengroesse_berechnen_v2.0.php`.

---

### ⚖️ License & Terms

Released under the **Creative Commons Attribution 4.0 International (CC-BY-4.0)** license.  
Permitted for non-commercial educational, research, and teaching deployments provided that the original attribution to the author is preserved intact within the source code, metadata layer, and user interface.

---

<a name="deutsch"></a>
## 🇩🇪 Deutsche Dokumentation

# Berechnung der erforderlichen Mindest-Stichprobengröße für unendliche und endliche Grundgesamtheiten (Version 2.0)

Ein didaktisch aufbereitetes PHP-Framework und Online-Rechner zur stichprobenmethodischen Herleitung und Ermittlung der erforderlichen Mindest-Stichprobengröße für unendliche und endliche Grundgesamtheiten nach mathematischen Standardformeln. 

Das Tool richtet sich insbesondere an Lehrende und Forschende der Sozialwissenschaften sowie Studierende. Es zeichnet sich durch einen linear und barrierearm gestalteten Code zur leichten Nachvollziehbarkeit ohne komplexe Abstraktionsschichten aus.

---

### 🔬 Akademischer Ursprung & Praxisnachweis

* **Akademisches Fundament:** Ursprünglich erstellt für die *Lehrveranstaltung 3 – Vertiefung wissenschaftlicher Methoden* – im Rahmen der Propädeutik-Seminare (B.A.-Studiengänge) an der **Evangelischen Hochschule Bochum**. Es findet breite Anwendung in der akademischen Lehre und empirischen Forschung.
* **Gerichtliche Referenzierung:** Durch Beschluss des **Verwaltungsgerichtshofs Baden-Württemberg** vom 20.04.2020 (*Az. 4 S 3276/19, ECLI:DE:VGHBW:2020:0420.4S3276.19.00*) offiziell als stichprobentheoretisches Referenzwerkzeug gewürdigt.
  * Gerichtlicher Permanentlink: [Landesrecht BW (NJRE001420817)](https://www.landesrecht-bw.de/perma?d=NJRE001420817)

---

### ⚙️ Mathematische Formelbasis

Das Skript führt Berechnungen auf Basis der klassischen statistischen Stichprobentheorie aus:

#### 1. Unendliche Grundgesamtheit
Wird angewendet, wenn der Gesamtumfang der Grundgesamtheit unbekannt oder unbegrenzt ist:

\[n \ge \frac{z^2 \cdot P \cdot Q}{\epsilon^2}\]

#### 2. Endliche Grundgesamtheit
Wird angewendet, wenn die exakte Populationsgröße (N) bekannt ist, unter Verwendung der endlichen Grundgesamtheitskorrektur:

\[n \ge \frac{N}{1 + \frac{(N - 1) \cdot \epsilon^2}{z^2 \cdot P \cdot Q}}\]

*Bedeutung der Variablen:*
*   n = Erforderliche Mindest-Stichprobengröße (wird im Skript mathematisch *immer* auf die nächste Ganzzahl aufgerundet).
*   z = Konfidenzniveau (z-Wert aus der Standardnormalverteilung, z. B. \(95\% \Rightarrow z = 1,96\)).
*   P = Erwarteter Mittelwert / geschätzte Verteilung des Merkmals (Standardwert: \(50\% \Rightarrow 0,5\) für maximale Varianzabsicherung).
*   Q = Gegenwahrscheinlichkeit zu P (1 - P).
*   ε = Gewählter tolerierbarer Fehlerbereich / Fehlertoleranz (z. B. \(5\% \Rightarrow 0,05\)).
*   N = Gesamte Populationsgröße / Grundgesamtheit.

---

### 🚀 Kern-Features

* **Duale Berechnungsmatrix:** Exakte mathematische Ermittlung sowohl für begrenzte als auch unbegrenzte Zielgruppen-Pools.
* **Didaktischer Fokus:** Bewusst linearer Programmierstil zur schrittweisen Nachvollziehbarkeit für Studierende ohne tiefe Informatik-Kenntnisse.
* **Bruttostichproben-Kalkulator:** Berechnet anhand der geschätzten Rücklaufquote (R) bei Fragebogenverfahren die notwendige Anzahl zu versendender Fragebögen: \(\text{Brutto-Umfang} = \frac{n}{R} \cdot 100\).
* **Integrierter Zufallsgenerator:** Ermöglicht die direkte, serverseitige Ziehung von Zufallsnummern aus einer definierten endlichen Grundgesamtheit zur unverfälschten Stichprobenziehung.
* **Green IT & Autarkie:** Keine externen Frameworks, Bibliotheken oder SQL-Datenbanken erforderlich. Volle Abwärtskompatibilität ab **PHP 4.3** bis hin zu modernen **PHP 8.x**-Umgebungen.

---

### 🔧 Installations- und Betriebsanleitung

#### Option A: Installation auf einem Webserver (Shared Hosting / Eigener Server)
1. Entpacken Sie das Archiv auf Ihrem lokalen Rechner, um die Datei `stichprobengroesse_berechnen_v2.0.php` zu erhalten.
2. Laden Sie die Datei per SFTP/FTP (z. B. via FileZilla) auf Ihren Webserver in das öffentliche Stammverzeichnis (`public_html`, `www` oder `htdocs`) hoch.
3. Stellen Sie sicher, dass die Dateirechte lesbar gesetzt sind (Standard-Dateirechte `0644`).
4. Rufen Sie die Anwendung im Browser auf: `https://ihre-domain.de/stichprobengroesse_berechnen_v2.0.php`.

#### Option B: Lokaler Betrieb auf dem eigenen PC (Offline-Lehre)
1. Installieren Sie eine lokale PHP-Laufzeitumgebung wie XAMPP oder MAMP.
2. Kopieren Sie die Datei `stichprobengroesse_berechnen_v2.0.php` in das lokale Web-Verzeichnis (`C:\xampp\htdocs\` bzw. `/Applications/MAMP/htdocs/`).
3. Starten Sie das Webserver-Modul (Apache oder Nginx) über das Control Panel der Software.
4. Rufen Sie das Tool offline im Browser auf: `http://localhost/stichprobengroesse_berechnen_v2.0.php`.

---

### ⚖️ Nutzungsbedingungen & Lizenz

Veröffentlicht unter der **Creative Commons Attribution 4.0 International (CC-BY-4.0)** Lizenz.  
Die Nutzung für nicht-kommerzielle Lehr- und Forschungszwecke ist ausdrücklich freigegeben, sofern die Urheberangaben im Quelltext, in den Metatags und auf der Benutzeroberfläche unverändert beibehalten werden.
