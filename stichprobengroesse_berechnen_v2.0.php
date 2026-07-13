<!DOCTYPE html>
<html lang="de-DE">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type"
      content="text/html; charset=utf-8">
<title>Berechnung der erforderlichen Mindest-Stichprobengröße für unendliche und endliche Grundgesamtheiten (v2.0)</title>
<style type="text/css">
.fsz_groesse_1 {
font-family: verdana;
font-size: 7px;
}
.fsz_groesse_2 {
font-family: verdana;
font-size: 11px;
}
.fsz_groesse_3 {
font-family: verdana;
font-size: 12px;
color: #000000;
}
</style>
<meta name="author" content="Dr. Uwe Janatzek, M.A.">
<meta name="copyright" content="Dr. Uwe Janatzek, M.A. - FLEDISoft MemexXa">
<meta name="description" content="Online-Rechner zur Berechnung der erforderlichen Mindest-Stichprobengröße für unendliche und endliche Grundgesamtheiten. Mit Zufallsgenerator, Fehlerkontrolle falls F > G, Formelanzeige und Schritt-für-Schritt-Anleitung zur Auflösung der Formeln.">
<meta name="abstract" content="Online-Rechner zur Berechnung der erforderlichen Mindest-Stichprobengröße für unendliche und endliche Grundgesamtheiten. Mit Zufallsgenerator, Fehlerkontrolle falls F > G, Formelanzeige und Schritt-für-Schritt-Anleitung zur Auflösung der Formeln.">
</head>
<body>
<?php
// Hinweis:
// Dieses Script richtet sich NICHT an professionelle Programmierer oder Informatiker, sondern im Besonderen an Lehrende aus anderen Fachbereichen, insbesondere den Sozialwissenschaften sowie an wissenschaftlich interessierte Privatpersonen. Da in diesem Bereich Programmierkenntnisse häufig nicht oder in nicht sehr hohem Maße vorliegen, wurde der Code aus didaktischen und Inklusionsgründen so einfach und linear wie möglich gehalten, um eine möglichst weitgehende Nachvollziehbarkeit auch für wenig versierte Personen zu gewährleisten und ihnen somit Änderungen, falls notwendig, zu erleichtern.
//
// Sinn und Zweck des Scripts:
// Dieses Script dient der Ermittlung der erforderlichen Stichprobengröße bei endlichen und unendlichen Grundgesamtheiten. Dafür wird die Standardformel herangezogen. Zusätzlich enthält das Script entsprechende Erläuterngen zu den Werten und der Berechnungsfolge. Weiterhin ist ein Zufallsgenerator enthalten, der die erforderliche Anzahl an Zufallsnummern aus der Grundgesamtheit zieht, unter Berücksichtigung der Rücklaufquote bei der Verwendung von Fragebogenverfahren (nur für endliche Grundgesamtheit).
//Version: 2.0
// Änderung: Umstellung der Eingabeverarbeitung auf explizite Variablenzuweisung zur Erhöhung der Serversicherheit bei vollständiger Wahrung der mathematischen Logik und Abwärtskompatibilität.
//
// Referenzierung:
// Dieses Skript findet Anwendung in der akademischen Lehre sowie in der wissenschaftlichen Forschung B.A.- / .M.A.-Arbeiten / Dissertationen. Es wurde u. a. im Beschluss des Verwaltungsgerichtshofs Baden-Württemberg vom 20.04.2020 (Az. 4 S 3276/19, ECLI:DE:VGHBW:2020:0420.4S3276.19.00) als Referenzwerkzeug (http://www.fledisoft.de/stichprobengroesse_berechnen.php) für die stichprobentheoretische Herleitung zitiert.

// Hier werden die zur Berechnung notwenigen Werte aus dem POST-Array geholt - ANFANG
$stw=$_POST['stw']; // RÜcksetz-Button
$ruecklauf=$_POST['ruecklauf']; // Rücklaufwert
$N=$_POST['N']; // N-Wert
$z=$_POST['z']; // $z-Wert
$p=$_POST['p']; // p-Wert
$e=$_POST['e']; // e-Wert

$eg=$_POST['eg']; // Button für endliche Grundgesamtheit
$ug=$_POST['ug']; // Button für unendliche Grundgesamtheit
// Hier werden die zur Berechnung notwenigen Werte aus dem POST-Array geholt - ENDE

$addr=$_SERVER['SCRIPT_NAME']; // Dies ist die Zieladresse, auf die das Method-Target verweist. $_SERVER['SCRIPT_NAME'] bewirkt, dass immer der aktuelle Scriptname verwendet wird.

//------------------------------ Sicherheits- und Kontrollfunktionen -- ANFANG
// An dieser Stelle werden die aus den Eingabefeldern übergebenen Werte bereinigt, falls versucht wurde, Schadcode einzuschleusen; es wird empfohlen, dies nicht zu ändern.
$ruecklauf=strip_tags($ruecklauf);
$N=strip_tags(trim($N));
$z=strip_tags(trim($z));
$p=strip_tags(trim($p));
$e=strip_tags(trim($e));
$ruecklauf=htmlspecialchars($ruecklauf);
$N=htmlspecialchars($N);
$z=htmlspecialchars($z);
$p=htmlspecialchars($p);
$e=htmlspecialchars($e);
$ruecklauf=str_replace(",","",$ruecklauf);
$ruecklauf=str_replace(".","",$ruecklauf);
$ruecklauf=str_replace(";","",$ruecklauf);
$ruecklauf=str_replace(":","",$ruecklauf);
$N=str_replace(",","",$N);
$N=str_replace(".","",$N);
$N=str_replace(";","",$N);
$N=str_replace(":","",$N);
//------------------------------ Sicherheits- und Kontrollfunktionen -- ENDE

// Sicherstellung, dass es sich auch um Zahlen handelt - ANFANG
$ruecklauf=$ruecklauf + 0;
$N=$N + 0;
$z=$z + 0;
$p=$p + 0;
$e=$e + 0;
// Sicherstellung, dass es sich auch um Zahlen handelt - ENDE

// Einsetzen von Standardwerten für den Erststart oder wenn eine Eingabe leer ist - ANFANG
if (!($z)) { $z=1.96; }
if (!($p)) { $p=0.5; }
if (!($e)) { $e=0.05; }
if (!($N)) { $N=7500; } if (($N) < 100) { $N=100; }
if (!($ruecklauf)) { $ruecklauf=20; }
if (($ruecklauf) > 99) { $ruecklauf=99; }
// Einsetzen von Standardwerten für den Erststart oder wenn eine Eingabe leer ist - ENDE

// --------------------------------------------------------------------------------- Tab. Hintergrundfarbe -- ANFANG
// Je nachdem, welche Grundgesamtheit berechnet wird, ändert sich die Tabellenfarbe - dies dient der besseren Übersichtlichkeit
if (($ug)) { $bgug='#FFFFD7'; $bgeg='#eeeeee'; $onmouse_eg='onmouseover="this.bgColor='."'".'#FFFFD7'."'".'" onmouseout="this.bgColor='."'".'#eeeeee'."'".'"'; }
if (($eg)) { $bgeg='#FFFFD7'; $bgug='#eeeeee'; $onmouse_ug='onmouseover="this.bgColor='."'".'#FFFFD7'."'".'" onmouseout="this.bgColor='."'".'#eeeeee'."'".'"'; }
if (!($eg) AND !($ug)) {  $bgeg='#eeeeee'; $bgug='#eeeeee'; $onmouse_eg='onmouseover="this.bgColor='."'".'#FFFFD7'."'".'" onmouseout="this.bgColor='."'".'#eeeeee'."'".'"'; $onmouse_ug='onmouseover="this.bgColor='."'".'#FFFFD7'."'".'" onmouseout="this.bgColor='."'".'#eeeeee'."'".'"'; }
// ----------------------------------------------------------------------------------- Tab. Hintergrundfarbe -- ENDE

// ------------------------------------------- Textausgabe Werte -- ANFANG
$text='
<br><br><hr><div class="fsz_groesse_3"><br><br>
<span style="font-family:verdana;"><b><u>Erläuterungen zu den Formelwerten und Eingabefeldern:</u></b></span>
<table border="0" width="100%" cellpading="0" cellspacing="0">
<tr><td class="fsz_groesse_3">
<span style="font-family:verdana;">
<br><br>
<b><u>Konfidenzniveau (z):</u></b><br>
Das Konfidenzniveau oder auch Vertrauensniveau bezeichnet einen aus der zentralen Wahrscheinlichkeit der Standardnormalverteilung berechneten Wert der gewählten Sicherheitswahrscheinlichkeit und bestimmt neben dem Fehlerbereich wesentlich die Stichprobengröße.<br>
Liegt das Konfidenzniveau z.B. bei 95 %, heißt das, dass ein statistischer berechneter Wert im Rahmen einer Stichprobe mit 95 %iger Wahrscheinlichkeit auch für die Grundgesamtheit innerhalb des  Konfidenzintervalls liegt - die Chance ist also recht hoch, dass der Durchschnitt in der Grundgesamtheit genau innerhalb des Fehlerbereichs liegt.<br>
Dies bedeutet aber auch, dass, würde die Stichprobe 100 mal wiederholt, in fünf Fällen dies für die Grundgesamtheit nicht stimmen würde. Der Wert des Konfidenzniveaus wird in der Formel mit z angegeben. Um es in der Formel verwenden zu können, muss es quadriert werden.<br>
<br>
z-Werte für gängige Vertrauensintervalle:<br>
<table border="0">
<tr><td align="right" class="fsz_groesse_3">50&nbsp;%</td><td>&#x21D2;</td><td class="fsz_groesse_3">&nbsp;z&nbsp;=&nbsp;0,674</td></tr>
<tr><td align="right" class="fsz_groesse_3">75&nbsp;%</td><td>&#x21D2;</td><td class="fsz_groesse_3">&nbsp;z&nbsp;=&nbsp;1,15</td></tr>
<tr><td align="right" class="fsz_groesse_3">90&nbsp;%</td><td>&#x21D2;</td><td class="fsz_groesse_3">&nbsp;z&nbsp;=&nbsp;1,65</td></tr>
<tr><td align="right" class="fsz_groesse_3">95&nbsp;%</td><td>&#x21D2;</td><td class="fsz_groesse_3">&nbsp;z&nbsp;=&nbsp;1,96</td></tr>
<tr><td align="right" class="fsz_groesse_3">97,5&nbsp;%</td><td>&#x21D2;</td><td class="fsz_groesse_3">&nbsp;z&nbsp;=&nbsp;2,24</td></tr>
<tr><td align="right" class="fsz_groesse_3">99&nbsp;%</td><td>&#x21D2;</td><td class="fsz_groesse_3">&nbsp;z&nbsp;=&nbsp;2,58</td></tr>
</table>
Als Standardwert wird für gewöhnlich 95 % gewählt. Zur Bestimmung anderer als der hier genannten Werte gibt es in der entsprechenden Fachliteratur wie auch im Netz entsprechende Tabellen.
<br><br>

<b><u>Fehlerbereich (&#x3B5):</u></b><br>
Das griechische (kleine) Epsilon &#x3B5; steht für das lateinische Wort Error, also &quot;Irrtum&quot; im Sinne von &quot;Fehler&quot; und bezeichnet in der Formel den Fehlerbereich bzw. die gewählte Fehlertoleranz. Je kleiner dieser Fehlerbereich gesetzt wird, umso mehr steigt die Wahrscheinlichkeit, dass die Ergebnisse der Stichprobe den wahren Verhältnissen in der Grundgesamtheit entsprechen.<br>
&#x3B5 und die Stichprobengröße stehen dabei in einer Art antiproportionalem Verhältnis: Je größer die Fehlertoleranz, desto kleiner die benötigte Stichprobe.<br>
Gerade der tolerierbare Fehlerbereich wirkt sich also erheblich auf die Größe der erforderlichen Stichprobe aus. Eine Änderung von 10 % auf 1% bewirkt eine knappe Verhundertfachung der Stichprobengröße (vgl. Tabelle) und damit eine Erhöhung des Auswertungsaufwandes und der Kosten. Als konservativer Wert für den Fehlerbereich wird deshalb standardmäßig meist 5 % bestimmt. Auch &#x3B5; muss zur Verwendung in der Formel quadriert werden.
<br><br>
<table style="border:1px solid #000000;" width="100%">
<tr bgcolor=#c0c0c0><td align=center class="fsz_groesse_3"><b>Fehlerbereich</td><td class="fsz_groesse_3"><b>Konfidenzniveau</td><td class="fsz_groesse_3"><b>Mittelwert</td><td class="fsz_groesse_3"><b>Rücklaufquote</td><td class="fsz_groesse_3"><b>Stichprobengröße</td><td class="fsz_groesse_3"><b>Anzahl&nbsp;Fragebögen</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3"><font color="red">1 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3"><font color="red">9604</td><td align="right" class="fsz_groesse_3"><font color="red">48020</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3">2 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3">2401</td><td align="right" class="fsz_groesse_3">12005</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3">3 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3">1068</td><td align="right" class="fsz_groesse_3">5340</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3">4 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3">601</td><td align="right" class="fsz_groesse_3">3005</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3"><font color=green>5 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3"><font color=green>385</td><td align="right" class="fsz_groesse_3"><font color=green>1925</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3">6 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3">267</td><td align="right" class="fsz_groesse_3">1335</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3">7 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3">196</td><td align="right" class="fsz_groesse_3">981</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3">8 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3">151</td><td align="right" class="fsz_groesse_3">755</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3">9 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3">119</td><td align="right" class="fsz_groesse_3">595</td></tr>
<tr bgcolor="#eeeeee"><td align="right" class="fsz_groesse_3"><font color="red">10 %</td><td align="right" class="fsz_groesse_3">95 %</td><td align="right" class="fsz_groesse_3">50 %</td><td align="right" class="fsz_groesse_3">20 %</td><td align="right" class="fsz_groesse_3"><font color="red">98</td><td align="right" class="fsz_groesse_3"><font color="red">485</td></tr>
</table>
<br>

<b><u>Mittelwert der Grundgesamtheit (P):</u></b><br>
Bei neuen Erhebungen wird hier für gewöhnlich der Wert 50 % gewählt. Wurde bereits eine Erhebung vorgenommen, kann auch der Wert eingetragen werden, der sich aus der vorherigen Erhebung ergeben hat. Beispiel:<br>
Im Rahmen Ihres Studiums untersuchen Sie die Frage, ob die in der Stichprobe abgebildeten Merkmalsträger vor ihrem 18. Lebensjahr bereits illegale Drogen konsumiert haben. Da darüber hinsichtlich der von Ihnen definierten Grundgesamtheit noch nichts bekannt ist, tragen Sie den Wert 50 % ein.<br>
Es stellt sich heraus, dass 65 % der Befragten die Frage nach dem Drogenkonsum bejaht haben. Diese Befragung wiederholen Sie später mit der gleichen Grundgesamtheit. Nun können Sie den Wert 65 % als P einsetzen, was die Höhe der notwendigen Stichprobengröße verringert.<br>
P wird in der Formel nicht mit z.B. 50 angegeben, sondern in diesem Fall mit 0,5 und 65 % entsprechend mit 0,65 usw. P kann also im Prinzip zwischen 1 % und 100 % liegen.
<br><br>
<b><u>Q (1 &minus; P):</u></b><br>
Q ist zwar Element der Formel, jedoch wird dazu kein Wert eingegeben. Denn die Größe von Q ergibt sich aus der Größe von P. Was sehr einfach zu berechnen ist, denn Q = 1 &minus; P. Bevor die Formel aufgelöst werden kann, muss also zuerst Q bestimmt werden. Ist P z.B. 0,5 kann Q nur ebenfalls 0,5 sein, denn 1 &minus; 0,5 = 0,5. Wäre P 0,3 dann Q entsprechend 0,7. Q und P ergeben zusammen also immer 1.<br>
Wichtig ist, dass der tatsächliche Mittelwert (also P und damit auch Q) noch unbekannt ist und erst durch die Auswertung ermittelt werden soll. Darum handelt es sich bei P um einen Schätzwert, der so gelegt wird, dass das Produkt aus P &sdot; Q einen möglichst hohen Wert annimmt. Das ist bei 0,5 &sdot; 0.5 gegeben, denn das Ergebnis ist 0,25 (0,6 &sdot; 0,4 ergeben hingegen den geringeren Wert 0,24). Dies soll gewährleisten, dass selbst für den ungünstigsten Fall eine ausreichend hohe Stichprobengröße generiert wird. Denn mit wachsendem Produktwert von P &sdot; Q erhöht sich auch der Stichprobenumfang.
<br><br>

<b><u>Rücklaufquote (R):</u></b><br>
Die Rücklaufquote ist weder Teil der Formel, noch der Berechnung der Stichprobengröße selbst, sondern stellt hier eine Zusatzfunktion dar (ebenso der Zufallsgenerator bei endlichen Grundgesamtheiten). Insbesondere wenn mit zu verschickenden Fragebögen gearbeitet wird, kann sie jedoch wichtige Hinweise auf Aufwand / Kosten und überhaupt der Brauchbarkeit der Methodik geben. Denn es kann vorkommen, dass bei manchen Rücklaufquoten (die nur Schätzwerte aufgrund vorheriger Erfahrungen sind) mehr Fragebögen verschickt werden müssten, als es überhaupt Merkmalsträger in der Grundgesamtheit gibt. Das heißt, im Prinzip müsste eine Vollerhebung durchgeführt werden. In diesen Fällen können keine repräsentativitätssichernden reinen Zufallsstichproben gezogen werden, es sei denn, die Werte für P und &#x3B5 werden entsprechend geändert. Auch ist es möglich, auf die bekannte Faustformel n = 30 zurückzugreifen oder eben eine andere Erhebungsmethode zu wählen.<br>
Die erforderliche Anzahl an Fragebögen ist anhand der Stichprobengröße leicht zu berechnen: (n &divide; R) &sdot; 100. Man teilt also die Stichprobengröße durch die zu erwartende Rücklaufquote und multipliziert das Ergebnis mit 100. <br>
Für bestimmte zu erwartende Rücklaufquoten muss also eine bestimmte Höhe der Grundgesamtheit gegeben sein. Das nachfolgende Listing (Standardwerte vorausgesetzt) gibt dazu einen groben Überblick:
<br>
<br>
<u>Listing erforderlicher Grundgesamtheiten in Bezug auf die Rücklaufquote:</u>
<br>
Rücklaufquote <font color="red">30 %</font> = Grundgesamtheit muss mindestens <font color="red">0910</font> betragen.<br>
Rücklaufquote <font color="red">25 %</font> = Grundgesamtheit muss mindestens <font color="red">1160</font> betragen.<br>
Rücklaufquote <font color="red">20 %</font> = Grundgesamtheit muss mindestens <font color="red">1550</font> betragen.<br>
Rücklaufquote <font color="red">15 %</font> = Grundgesamtheit muss mindestens <font color="red">2190</font> betragen.<br>
Rücklaufquote <font color="red">10 %</font> = Grundgesamtheit muss mindestens <font color="red">3480</font> betragen.<br>
Rücklaufquote <font color="red">09 %</font> = Grundgesamtheit muss mindestens <font color="red">3900</font> betragen.<br>
Rücklaufquote <font color="red">08 %</font> = Grundgesamtheit muss mindestens <font color="red">4430</font> betragen.<br>
Rücklaufquote <font color="red">07 %</font> = Grundgesamtheit muss mindestens <font color="red">5120</font> betragen.<br>
Rücklaufquote <font color="red">06 %</font> = Grundgesamtheit muss mindestens <font color="red">6040</font> betragen.<br>
Rücklaufquote <font color="red">05 %</font> = Grundgesamtheit muss mindestens <font color="red">7330</font> betragen.<br>
<br>

<b><u>Auflösung der Formel per Hand bzw. Taschenrechner - Schritt-für-Schritt-Anleitung:</u></b><br>
Zu Übungszwecken kann es sinnvoll sein, die Formeln selbst einmal nachzurechnen, um ein besseres Verständnis für die Zusammenhänge der Werte zu entwickeln. Leider lassen sich viele Menschen (auch Studierende) von Formeln abschrecken, da sie auf den ersten Blick "kompliziert" erscheinen. Schaut man sie sich aber genauer an, so zeigt sich oft (aber nicht immer!), dass sie doch leichter zu lösen sind, als anfangs gedacht. Dies gilt auch für die Formel zur Berechnung der erforderlichen Stichprobengröße bei <i>endlichen</i> Grundgesamtheiten, also diese:
<br><br>

<table style="border:1px solid #000000;" width="95%">
<tr bgcolor="#eeeeee">
<td><center>
<table style="border:1px solid #000000;font-family:verdana;font-size:13px;" cellpadding="0" cellspacing="1">
<tr><td></td><td><center><b>N</td></tr>
<tr><td><b>n&nbsp;&#x2265;&nbsp;</td><td><hr></td></tr>
<tr><td></td><td>
<table cellpadding="0" cellspacing="0">
<tr>
<td valign="middle"><b>1&nbsp;&plus;&nbsp;</td><td align=center><b>(N&nbsp;&#x2212;&nbsp;1)&nbsp;&sdot;&nbsp;&#x3B5;&#x00B2;<hr>z&#x00B2;&nbsp;&sdot;&nbsp;P&nbsp;&sdot;&nbsp;Q</td>
</tr>
</table>
</td></tr>
</table>
</td>
</tr>
</table>
<br>
Was die einzelnen Elemente der Formel bedeuten, wissen wir bereits. Doch wie lässt sie sich lösen?<br>
Zunächst muss man sich im Klaren darüber sein, dass es sich im Prinzip um eine Bruchrechnung handelt, wobei der Nenner der ersten Bruchs selbst aus einem Bruch besteht. Das heißt also, dass, will man die Formel analysieren und lösen, man von hinten anfangen muss oder auch "bottom up".<br>
Zur Lösung setzen wir die Standardwerte voraus, also für z = 95 % = 1,96, für P = 50 % = 0,5, für &#x3B5; = 5 % = 0,05 und für N = 7500 (die RÜcklaufquote spielt hier keine Rolle und wird weggelassen).<br>
Wichtig zu beachten ist, dass P und &#x3B5; nicht als 50 bzw. 5 in die Formel einfließen, sondern als 0,5 und 0,05. Das heißt, 1 entspricht hier 100 %. 50 % von 1 ist bekanntlich 0,5 und 5 % von 1 entspricht 0,05.
Bevor man die Formel lösen kann, müssen jedoch zwei Schritte vorher durchgeführt werden:<br><br>
<u>Schritt 1:</u> Umwandlung von P und &#x3B5;.<br>
P ergibt sich daraus, dass 1 durch 100 geteilt und dann mit P multipliziert wird, also: 1 &divide; 100 &sdot; P.<br>
Wenn P 50 % beträgt, also: 1 &divide; 100 &sdot; 50.<br>
Mit &#x3B5 wird genauso verfahren, also: 1 &divide; 100 &sdot; &#x3B5;.<br>
Wenn &#x3B5; 5 % beträgt, also: 1 &divide; 100 &sdot; 5.

<br><br>
<u>Schritt 2:</u> Bestimmung von Q.<br>
Dies ist, wie bereits zu sehen war, einfach, denn Q = 1 &minus; P.<br>
Wenn P = 0,5 ist, also: 1 &minus; 0,5 = 0,5. Q entspricht also (ebenfalls) 0,5.

<br><br>
<u>Schritt 3:</u> Quadrierung der Werte.<br>
Mit Quadrierung ist gemeint, dass die Werte mit sich selbst multipliziert werden müssen. Das jeweilige Ergebnis wird dann in die Formel eingesetzt. Also:<br>
z = 1,96. Jetzt z mit z multiplizieren: 1,96 &sdot; 1,96 = 3,8416. z&#x00B2; entspricht also 3,8416.<br>
&#x3B5; = 0,05. Jetzt &#x3B5; mit &#x3B5; multiplizieren: 0,05 &sdot; 0,05 = 0,0025. &#x3B5;&#x00B2; entspricht also 0,0025.<br>
<br>
Mit den eingesetzten Werten sieht die Formel nun so aus:
<br><br>
<table style="border:1px solid #000000;" width=95%>
<tr bgcolor="#eeeeee">
<td><center>
<table style="border:1px solid #000000;font-family:verdana;font-size:13px;" cellpadding="0" cellspacing="1" bgcolor="#FFFFD7">
<tr><td></td><td><center><b>7500</td></tr>
<tr><td><b>n&nbsp;&#x2265;&nbsp;</td><td><hr></td></tr>
<tr><td></td><td>
<table cellpadding="0" cellspacing="0">
<tr>
<td valign="middle"><b>1&nbsp;&plus;&nbsp;</td><td align=center><b>(7500&nbsp;&#x2212;&nbsp;1)&nbsp;&sdot;&nbsp;0.0025<hr>3.8416&nbsp;&sdot;&nbsp;0.5&nbsp;&sdot;&nbsp;0.5</td>
</tr>
</table>
</tr>
</table>
</td>
</tr>
</table>



<br>
Jetzt kann mit der Lösung der Formel begonnen werden. Da es sich um Brüche handelt, kann dies zeilenweise geschehen. Begonnen wird mit der untersten Zeile, also mit
<br>
z&#x00B2;&nbsp;&sdot;&nbsp;P&nbsp;&sdot;&nbsp;Q
<br>
Mit den eingesetzten Werten sieht die Zeile also so aus:<br>
3,8416&nbsp;&sdot;&nbsp;0,5&nbsp;&sdot;&nbsp;0,5<br>
Dies sieht nun schon weit weniger "bedrohlich" aus und lässt sich auch leicht ausrechnen, das Ergebnis lautet 0,9604. Das war Zeile Nummer drei.<br>
Jetzt Zeile Nummer zwei (also der Zähler des zweiten Bruchs), die da lautet:<br>
(N&nbsp;&#x2212;&nbsp;1)&nbsp;&sdot;&nbsp;&#x3B5;&#x00B2;<br>
Entgegen der Regel wird hier - weil N&nbsp;&#x2212;&nbsp;1 in einer Klammer steht - zuerst die Strichrechnung ausgeführt, was ziemlich einfach ist. Denn wir wissen, dass N für 7500 steht, und 7500 &minus; 1 = 7499. Dieses Ergebnis wird nun mit &#x3B5;&#x00B2; multipliziert, also: 7499 &sdot; 0,0025 = 18,7475. Dieses Ergebnis der zweiten Zeile teilen wir nun durch das Ergebnis der dritten Zeile, also:<br>
18,7475 &divide; 0,9604 = 19,520512286547271970012494793836<br>
Natürlich dürfen wir die 1 &plus; vor dem Bruch nicht vergessen, also: 19,520512286547271970012494793836 &plus; 1 = 20,520512286547271970012494793836<br>
Dieses Ergebnis stellt jetzt den Nenner des oberen Bruches dar. Der Zähler dieses Bruches ist N, von dem wir wissen, dass der Wert 7500 beträgt. Gerechnet wird also:<br>
7500 &divide; 20,520512286547271970012494793836 = 365,4879515321267106084362108596<br>
Damit sind wir auch schon fast fertig. Wie zu sehen, kommt bei dem Ergebnis keine ganze Zahl heraus. In diesen Fällen wird das Ergebnis <i>immer</i> aufgerundet, egal ob hinter dem Komma eine 5 oder eine 2 steht - denn man kann ebenso wenig an 0,5 Personen einen Fragebogen schicken, wie an 0,2 Personen.<br>
Die nächsthöhere Ganzzahl ist 366. Somit lautet auch das Ergebnis, dass die Mindest-Stichprobengröße 366 beträgt.<br>
Fertig!

</span></span>
</td>
</tr>
</table>
';
// ------------------------------------------- Textausgabe Werte -- ENDE



if (!($verz)) {
echo '<span style="font-family:verdana;font-size:30px;">
<br>
<center>
<b>Berechnung der erforderlichen Mindest-Stichprobengröße für unendliche und endliche Grundgesamtheiten</b>
<br><br>
</center>
</span>';
}
?>

<div class="fsz_groesse_3">

<hr>
<span style="font-family:verdana;font-size:9px;"><center>Realisierung und Bereitstellung durch Dr. Uwe Janatzek, M.A.<br>
(Dieser Rechner wurde ursprünglich für die Lehrveranstaltung 3 - Vertiefung wissenschaftlicher Methoden - im Rahmen der Propädeutik-Seminare [B.A.-Studiengänge] an der Evangelischen Hochschule Bochum erstellt.)</center>
<br><br>
Sinn und Zweck des Scripts:
Dieses Script dient der Ermittlung der erforderlichen Stichprobengröße bei endlichen und unendlichen Grundgesamtheiten. Dafür wird die Standardformel herangezogen. Zusätzlich enthält das Script entsprechende Erläuterungen zu den Werten und der Berechnungsfolge. Weiterhin ist ein Zufallsgenerator enthalten, der die erforderliche Anzahl an Zufallsnummern aus der Grundgesamtheit zieht, unter Berücksichtigung der Rücklaufquote bei der Verwendung von Fragebogenverfahren (<i>nur für endliche Grundgesamtheit</i>).
<br><br>
</span>

<br><center>
<table style="border:1px solid #000000;" width="100%" cellspacing="0" cellpadding="0">
<tr style="font-family:verdana;font-size:16px;font-weight:bold" bgcolor="#c0c0c0">
  <td width="50%" class="fsz_groesse_3"><center>Für unendliche Grundgesamtheit</td><td class="fsz_groesse_3"><center>Für endliche Grundgesamtheit</td></tr>
<tr style="font-family:verdana;font-size:13px;">
<td <?php echo $onmouse_ug; ?> valign="top" bgcolor="<?php echo $bgug; ?>" class="fsz_groesse_3">
<table>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Konfidenzniveau:&nbsp;
</td>
<form action="<?php echo $addr; ?>" name="ug" method="post">
<td class="fsz_groesse_2"><b>
<select name="z" style="width:68px;">
<option value="0.674" <?php if (($z) == 0.674) { echo 'selected'; } ?>>50 %</option>
<option value="1.15" <?php if (($z) == 1.15) { echo 'selected'; } ?>>75 %</option>
<option value="1.65" <?php if (($z) == 1.65) { echo 'selected'; } ?>>90 %</option>
<option value="1.96" <?php if (($z) == 1.96) { echo 'selected'; } ?>>95 %</option>
<option value="2.24" <?php if (($z) == 2.24) { echo 'selected'; } ?>>97,5 %</option>
<option value="2.58" <?php if (($z) == 2.58) { echo 'selected'; } ?>>99 %</option>
</select> (z = <?php echo $z; ?>)
</td>
</tr>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Mittelwert  der  Grundgesamtheit:&nbsp;
</td>
<td class="fsz_groesse_2"><b>
<select name="p" style="width:68px;">
<option value="0.05" <?php if (($p) == 0.05) { echo 'selected'; } ?>>5 %</option>
<option value="0.1" <?php if (($p) == 0.1) { echo 'selected'; } ?>>10 %</option>
<option value="0.15" <?php if (($p) == 0.15) { echo 'selected'; } ?>>15 %</option>
<option value="0.2" <?php if (($p) == 0.2) { echo 'selected'; } ?>>20 %</option>
<option value="0.25" <?php if (($p) == 0.25) { echo 'selected'; } ?>>25 %</option>
<option value="0.3" <?php if (($p) == 0.3) { echo 'selected'; } ?>>30 %</option>
<option value="0.35" <?php if (($p) == 0.35) { echo 'selected'; } ?>>35 %</option>
<option value="0.4" <?php if (($p) == 0.4) { echo 'selected'; } ?>>40 %</option>
<option value="0.45" <?php if (($p) == 0.45) { echo 'selected'; } ?>>45 %</option>
<option value="0.5" <?php if (($p) == 0.5) { echo 'selected'; } ?>>50 %</option>
<option value="0.55" <?php if (($p) == 0.55) { echo 'selected'; } ?>>55 %</option>
<option value="0.6" <?php if (($p) == 0.6) { echo 'selected'; } ?>>60 %</option>
<option value="0.65" <?php if (($p) == 0.65) { echo 'selected'; } ?>>65 %</option>
<option value="0.7" <?php if (($p) == 0.7) { echo 'selected'; } ?>>70 %</option>
<option value="0.75" <?php if (($p) == 0.75) { echo 'selected'; } ?>>75 %</option>
<option value="0.8" <?php if (($p) == 0.8) { echo 'selected'; } ?>>80 %</option>
<option value="0.85" <?php if (($p) == 0.85) { echo 'selected'; } ?>>85 %</option>
<option value="0.9" <?php if (($p) == 0.9) { echo 'selected'; } ?>>90 %</option>
<option value="0.95" <?php if (($p) == 0.95) { echo 'selected'; } ?>>95 %</option>
</select> (P = <?php echo $p; ?>)
</td>
</tr>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Fehlerbereich:&nbsp;
</td>
<td class="fsz_groesse_2"><b>
<select name="e" style="width:68px;">
<option value="0.01" <?php if (($e) == 0.01) { echo 'selected'; } ?>>1 %</option>
<option value="0.02" <?php if (($e) == 0.02) { echo 'selected'; } ?>>2 %</option>
<option value="0.03" <?php if (($e) == 0.03) { echo 'selected'; } ?>>3 %</option>
<option value="0.04" <?php if (($e) == 0.04) { echo 'selected'; } ?>>4 %</option>
<option value="0.05" <?php if (($e) == 0.05) { echo 'selected'; } ?>>5 %</option>
<option value="0.06" <?php if (($e) == 0.06) { echo 'selected'; } ?>>6 %</option>
<option value="0.07" <?php if (($e) == 0.07) { echo 'selected'; } ?>>7 %</option>
<option value="0.08" <?php if (($e) == 0.08) { echo 'selected'; } ?>>8 %</option>
<option value="0.09" <?php if (($e) == 0.09) { echo 'selected'; } ?>>9 %</option>
<option value="0.1" <?php if (($e) == 0.1) { echo 'selected'; } ?>>10 %</option>
</select> (&#x3B5; = <?php echo $e; ?>)
</td>
</tr>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Geschätzte Rücklaufquote in %:&nbsp;
</td>
<td class="fsz_groesse_2"><b>
<input type="text" name="ruecklauf" value="<?php echo $ruecklauf; ?>" onFocus="this.select()" maxlength=2 style="color:#007F00;width:62px;" title="Nur Zahlwerte ohne Punkt oder Komma eingeben!">
</td>
</tr>
<tr><td class="fsz_groesse_2">&nbsp;</td><td class="fsz_groesse_2">&nbsp;</td></tr>
</table>
<table height=100% width="100%" border="0">
<tr><td valign=bottom align=center class="fsz_groesse_2">
<input type="submit" name="ug" value="Stichprobengröße berechnen" title="Hier klicken um die Berechnung durchzuführen." style="cursor:pointer;">
</td></tr>
</table>
</form>
</td>
<td <?php echo $onmouse_eg; ?> valign="top"  bgcolor=<?php echo $bgeg; ?> class="fsz_groesse_2">
<table>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Konfidenzniveau:&nbsp;
</td>
<form action="<?php echo $addr; ?>" name="eg" method="post">
<td class="fsz_groesse_2"><b>
<select name="z" style="width:68px;">
<option value="0.674" <?php if (($z) == 0.674) { echo 'selected'; } ?>>50 %</option>
<option value="1.15" <?php if (($z) == 1.15) { echo 'selected'; } ?>>75 %</option>
<option value="1.65" <?php if (($z) == 1.65) { echo 'selected'; } ?>>90 %</option>
<option value="1.96" <?php if (($z) == 1.96) { echo 'selected'; } ?>>95 %</option>
<option value="2.24" <?php if (($z) == 2.24) { echo 'selected'; } ?>>97,5 %</option>
<option value="2.58" <?php if (($z) == 2.58) { echo 'selected'; } ?>>99 %</option>
</select> (z = <?php echo $z; ?>)
</td>
</tr>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Mittelwert  der  Grundgesamtheit:&nbsp;
</td>
<td class="fsz_groesse_2"><b>
<select name="p" style="width:68px;">
<option value="0.05" <?php if (($p) == 0.05) { echo 'selected'; } ?>>5 %</option>
<option value="0.1" <?php if (($p) == 0.1) { echo 'selected'; } ?>>10 %</option>
<option value="0.15" <?php if (($p) == 0.15) { echo 'selected'; } ?>>15 %</option>
<option value="0.2" <?php if (($p) == 0.2) { echo 'selected'; } ?>>20 %</option>
<option value="0.25" <?php if (($p) == 0.25) { echo 'selected'; } ?>>25 %</option>
<option value="0.3" <?php if (($p) == 0.3) { echo 'selected'; } ?>>30 %</option>
<option value="0.35" <?php if (($p) == 0.35) { echo 'selected'; } ?>>35 %</option>
<option value="0.4" <?php if (($p) == 0.4) { echo 'selected'; } ?>>40 %</option>
<option value="0.45" <?php if (($p) == 0.45) { echo 'selected'; } ?>>45 %</option>
<option value="0.5" <?php if (($p) == 0.5) { echo 'selected'; } ?>>50 %</option>
<option value="0.55" <?php if (($p) == 0.55) { echo 'selected'; } ?>>55 %</option>
<option value="0.6" <?php if (($p) == 0.6) { echo 'selected'; } ?>>60 %</option>
<option value="0.65" <?php if (($p) == 0.65) { echo 'selected'; } ?>>65 %</option>
<option value="0.7" <?php if (($p) == 0.7) { echo 'selected'; } ?>>70 %</option>
<option value="0.75" <?php if (($p) == 0.75) { echo 'selected'; } ?>>75 %</option>
<option value="0.8" <?php if (($p) == 0.8) { echo 'selected'; } ?>>80 %</option>
<option value="0.85" <?php if (($p) == 0.85) { echo 'selected'; } ?>>85 %</option>
<option value="0.9" <?php if (($p) == 0.9) { echo 'selected'; } ?>>90 %</option>
<option value="0.95" <?php if (($p) == 0.95) { echo 'selected'; } ?>>95 %</option>
</select> (P = <?php echo $p; ?>)
</td>
</tr>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Fehlerbereich:&nbsp;
</td>
<td class="fsz_groesse_2"><b>
<select name="e" style="width:68px;">
<option value="0.01" <?php if (($e) == 0.01) { echo 'selected'; } ?>>1 %</option>
<option value="0.02" <?php if (($e) == 0.02) { echo 'selected'; } ?>>2 %</option>
<option value="0.03" <?php if (($e) == 0.03) { echo 'selected'; } ?>>3 %</option>
<option value="0.04" <?php if (($e) == 0.04) { echo 'selected'; } ?>>4 %</option>
<option value="0.05" <?php if (($e) == 0.05) { echo 'selected'; } ?>>5 %</option>
<option value="0.06" <?php if (($e) == 0.06) { echo 'selected'; } ?>>6 %</option>
<option value="0.07" <?php if (($e) == 0.07) { echo 'selected'; } ?>>7 %</option>
<option value="0.08" <?php if (($e) == 0.08) { echo 'selected'; } ?>>8 %</option>
<option value="0.09" <?php if (($e) == 0.09) { echo 'selected'; } ?>>9 %</option>
<option value="0.1" <?php if (($e) == 0.1) { echo 'selected'; } ?>>10 %</option>
</select> (&#x3B5; = <?php echo $e; ?>)
</td>
</tr>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Populationsgröße / Grundgesamtheit:&nbsp;
</td>
<td class="fsz_groesse_2"><b>
<input type="text" name="N" value="<?php echo $N; ?>" onFocus="this.select()" maxlength=7 style="color:#0000ff;width:62px;" title="Nur Zahlwerte ohne Punkt oder Komma eingeben!"> (N)
</td>
</tr>
<tr>
<td align="right" class="fsz_groesse_2"><b>
Geschätzte Rücklaufquote in %:&nbsp;
</td>
<td class="fsz_groesse_3">
<input type="text" name="ruecklauf" value="<?php echo $ruecklauf; ?>" onFocus="this.select()" maxlength=2 style="color:#007F00;width:62px;" title="Nur Zahlwerte ohne Punkt oder Komma eingeben!">
</td>
</tr>
</table>
<table height=100% width="100%" border="0">
<tr><td valign=bottom class="fsz_groesse_3">
<center>
<input type="submit" name="eg" value="Stichprobengröße berechnen" title="Hier klicken um die Berechnung durchzuführen." style="cursor:pointer;">
</td>
</tr>
</table>
</form>

</td>
</tr>
</table>
<?php
if (($ug) OR ($eg)) {
  echo '<br><table style="border:1px solid #000000;" width="100%"><tr bgcolor="#c0c0c0"><form action="'.$addr.'" method="post"><td><center><input type="submit" name="stw" value="Felder auf Standardwerte zurücksetzen" title="Hier klicken um die Werte auf Standard zurückzusetzen." style="cursor:pointer;"></center></td></form></tr></table>';
}
?>
<br>

<?php

if (!($ug) && !($eg)) {

echo '
<table style="border:1px solid #000000;" width=95%>
<tr bgcolor="#eeeeee">
<td width="50%"><center>
<table style="border:1px solid #000000;font-family:verdana;font-size:13px;">
<tr>
<td valign="middle"><b>n&nbsp;&#x2265;&nbsp;z&#x00B2;&nbsp;&sdot;&nbsp;</td><td align=center><b>P&nbsp;&sdot;&nbsp;Q<hr>&#x3B5;&#x00B2;</td>
</tr>
</table>
</td>
<td width="50%"><center>
<table style="border:1px solid #000000;font-family:verdana;font-size:13px;" cellpadding="0" cellspacing="1">
<tr><td></td><td><center><b>N</td></tr>
<tr><td><b>n&nbsp;&#x2265;&nbsp;</td><td><hr></td></tr>
<tr><td></td><td>
<table cellpadding="0" cellspacing="0">
<tr>
<td valign="middle"><b>1&nbsp;&plus;&nbsp;</td><td align=center><b>(N&nbsp;&#x2212;&nbsp;1)&nbsp;&sdot;&nbsp;&#x3B5;&#x00B2;<hr>z&#x00B2;&nbsp;&sdot;&nbsp;P&nbsp;&sdot;&nbsp;Q</td>
</tr>
</table>
</td></tr>
</table>
</td>
</tr>
</table>
';

echo $text;

} else {

$q=1 - $p;

if (($eg)) {
echo '
<table style="border:1px solid #000000;" width="100%">
<tr bgcolor="#eeeeee">
<td width="50%" style="font-family:verdana;font-size:13px;"><center>
<table style="border:1px solid #000000;font-family:verdana;font-size:13px;">
<tr>
<td valign="middle"><b>n&nbsp;&#x2265;&nbsp;z&#x00B2;&nbsp;&sdot;&nbsp;</td><td align=center><b>P&nbsp;&sdot;&nbsp;Q<hr>&#x3B5;&#x00B2;</td>
</tr>
</table>
(Q = 1 &#x2212; P)
</td>




<td width="25%" style="font-family:verdana;" class="fsz_groesse_3"><center>
<table style="border:1px solid #000000;font-family:verdana;" cellpadding="0" cellspacing="1" bgcolor="#FFFFD7" class="fsz_groesse_3">
<tr><td class="fsz_groesse_3"></td><td><center><b>N</td></tr>
<tr><td class="fsz_groesse_3"><b>n&nbsp;&#x2265;&nbsp;</td><td class="fsz_groesse_3"><hr></td></tr>
<tr><td class="fsz_groesse_3"></td><td>
<table cellpadding="0" cellspacing="0">
<tr>
<td valign="middle" class="fsz_groesse_3"><b>1&nbsp;&plus;&nbsp;</td><td align=center class="fsz_groesse_3"><b>(N&nbsp;&#x2212;&nbsp;1)&nbsp;&sdot;&nbsp;&#x3B5;&#x00B2;<hr>z&#x00B2;&nbsp;&sdot;&nbsp;P&nbsp;&sdot;&nbsp;Q</td>
</tr>
</table></td>
</tr>
</table>
(Q = 1 &#x2212; P)
</td>

<td width="25%" style="font-family:verdana;" class="fsz_groesse_3"><center>
<table style="border:1px solid #000000;font-family:verdana;" cellpadding="0" cellspacing="1" bgcolor="#FFFFD7" class="fsz_groesse_3">
<tr><td class="fsz_groesse_3"></td><td class="fsz_groesse_3"><center><b>'.$N.'</td></tr>
<tr><td class="fsz_groesse_3"><b>n&nbsp;&#x2265;&nbsp;</td><td class="fsz_groesse_3"><hr></td></tr>
<tr><td></td><td>
<table cellpadding="0" cellspacing="0">
<tr>
<td valign="middle" class="fsz_groesse_3"><b>1&nbsp;&plus;&nbsp;</td><td align=center class="fsz_groesse_3"><b>('.$N.'&nbsp;&#x2212;&nbsp;1)&nbsp;&sdot;&nbsp;'. pow($e,2).'<hr>'.pow($z,2).'&nbsp;&sdot;&nbsp;'.$p.'&nbsp;&sdot;&nbsp;'.$q.'</td>
</tr>
</table>
</td>

</tr>
</table>
(Q = 1 &#x2212; '.$p.')
</td>
</tr>
</table></td>
</tr>
</table>
';
}

if (($ug)) {
echo '
<table style="border:1px solid #000000;" width="100%">
<tr bgcolor="#eeeeee">
<td width="25%" style="font-family:verdana;" class="fsz_groesse_3"><center>
<table style="border:1px solid #000000;font-family:verdana;" bgcolor="#FFFFD7">
<tr>
<td valign="middle"><b>n&nbsp;&#x2265;&nbsp;z&#x00B2;&nbsp;&sdot;&nbsp;</td><td align=center><b>P&nbsp;&sdot;&nbsp;Q<hr>&#x3B5;&#x00B2;</td>
</tr>
</table>
(Q = 1 &#x2212; P)
</td>

<td width="25%" style="font-family:verdana;" class="fsz_groesse_3"><center>
<table style="border:1px solid #000000;font-family:verdana;" bgcolor="#FFFFD7" class="fsz_groesse_3">
<tr>
<td valign="middle" class="fsz_groesse_3"><b>n&nbsp;&#x2265;&nbsp;'.pow($z,2).'&nbsp;&sdot;&nbsp;</td><td align=center><b>'.$p.'&nbsp;&sdot;&nbsp;'.$q.'<hr>'.pow($e,2).'</td>
</tr>
</table>
(Q = 1 &#x2212; P)
</td>


<td width="50%" style="font-family:verdana;" class="fsz_groesse_3"><center>
<table style="border:1px solid #000000;font-family:verdana;" cellpadding="0" cellspacing="1" class="fsz_groesse_3">
<tr><td></td><td class="fsz_groesse_3"><center><b>N</td></tr>
<tr><td class="fsz_groesse_3"><b>n&nbsp;&#x2265;&nbsp;</td><td><hr></td></tr>
<tr><td class="fsz_groesse_3"></td><td>
<table cellpadding="0" cellspacing="0">
<tr>
<td valign="middle" class="fsz_groesse_3"><b>1&nbsp;&plus;&nbsp;</td><td align=center class="fsz_groesse_3"><b>(N&nbsp;&#x2212;&nbsp;1)&nbsp;&sdot;&nbsp;&#x3B5;&#x00B2;<hr>z&#x00B2;&nbsp;&sdot;&nbsp;P&nbsp;&sdot;&nbsp;Q</td>
</tr>
</table></td>
</tr>
</table>
(Q = 1 &#x2212; P)
</td>



</tr>
</table>
</td>
</tr>
</table></td>
</tr>
</table>
';
}

}

if (($z)!= 1.96 OR ($p) != 0.5 OR ($e) != 0.05 OR ($ruecklauf) != 20) {

echo '<br><table style="border:1px solid #000000;" width="100%"><tr bgcolor="#c0c0c0"><form action="'.$addr.'" method="post"><td><center><input type="submit" name="stw" value="Felder auf Standardwerte zurücksetzen" title="Hier klicken um die Werte auf Standard zurückzusetzen." style="cursor:pointer;"></center></td></form></tr></table>';

}

echo '<br><br></center>';

if (isset($ug)) {

 $q=1 - $p;

 $ist=ceil(pow($z,2) * (($p *$q) / pow($e,2)));
 $anzahl_frgb=ceil(($ist / $ruecklauf) * 100);
 echo "<div class=\"fsz_groesse_3\"><hr><b>Erforderliche Stichprobengröße für unendliche Grundgesamtheit: <font color=\"red\">$ist</font></b><hr></div>";
 echo "Bei einer angenommenen Rücklaufquote von <b><font color=\"#007F00\">$ruecklauf</font></b> % müssen mindestens <b><font color=\"red\">$anzahl_frgb</font></b> Fragebögen verschickt werden, um die erforderliche Stichprobengröße von <b><font color=\"red\">$ist</font></b> zu erfüllen.<hr>";
 echo $text;
}


if (isset($eg)) {
 $q=1 - $p;
 $ist=ceil($N / (1 + (($N - 1) * pow($e,2)) / (pow($z,2) * $p * $q)));
}


if (($ug) OR ($eg)) {

$anzahl_frgb=ceil(($ist / $ruecklauf) * 100);
$zaehler=1;

if (($eg)) {
$anzahl_frgb=ceil(($ist / $ruecklauf) * 100);

echo "<hr><b>Erforderliche Stichprobengröße für endliche Grundgesamtheit: <font color=\"red\">$ist</font></b><hr>";

if (($anzahl_frgb) < $N) {
echo "Bei einer angenommenen Rücklaufquote von <b><font color=#007F00>$ruecklauf</font></b> % und einer Grundgesamtheit von <b><font color=\"#0000ff\">$N</font></b> müssen mindestens <b><font color=\"red\">$anzahl_frgb</font></b> Fragebögen verschickt werden, um die erforderliche Stichprobengröße von <b><font color=\"red\">$ist</b> zu erfüllen.<hr><br><center><u>Zufallsgenerator</u>:</font></center><br>";
echo '<span style="font-family:verdana;font-size:11px;">
Der Zufallsgenerator zieht die erforderlichen Elemente in der notwendigen Stichprobengröße automatisch aus der Grundgesamtheit. Vorausgesetzt wird dabei, dass die Elemente / Merkmalsträger der Grundgesamtheit einfach durchnumeriert werden.<br>
Der Generator zieht überdies auch die Anzahl an Merkmalsträgern aus der Grundgesamtheit, die erforderlich ist, um die geschätzte Rücklaufquote bei Fragebogenversand zu erfüllen.<br>
Beide Listings werden jeweils untereinander angezeigt: Nur die Anzahl der Merkmalsträger, die laut minimal erforderlicher Stichprobengröße erforderlich ist mit gelbem Hintergrund, das Listing für die notwendige Anzahl an Fragebogenempfängern mit grünem Hintergrund. Das linke Listing ist dabei jeweils durchnumeriert, das mittlere Listing entspricht einem einfachen Zeilen-Listing ohne Numerierung und das rechte Listing einem semikolon-separierten Datensatz. Das mittlere und rechte Listing kann als Datensatz zum Import in weitere Auswertungssoftware verwendet werden.
<span><br><br>';
} else {

echo "<br><br><b><font color=\"red\">FEHLER:</font></b> Die Anzahl der notwendig zu verschickenden Fragebögen von $anzahl_frgb ist größer als die Grundgesamtheit von $N!<br>
<b><font color=\"red\">Hinweis:</font></b> Der Zufallsgenerator wurde automatisch korrigiert und hat nun lediglich die erforderlichen Stichprobenelemente ($ist) aus der Grundgesamtheit ($N) gezogen!<br><br>
Bei geringeren Grundgesamtheiten empfiehlt es sich, entweder auf die Faustformel N=30 zurückzugreifen, den Wert für e (Fehlerbereich) zu ändern oder eine andere Form der Stichprobenwahl zu verwenden.
Das nachfolgende Listing dient zur groben Orientierung.<br>
(Vorausgesetzt wurden für das Listung die Standardwerte e = 5 %, P = 50 %, z = 95 %.)

<br><br>
<u>Listing erforderlicher Grundgesamtheiten in Bezug auf die Rücklaufquote</u>:
<bR><br>
Rücklaufquote 30 % = Grundgesamtheit muss mindestens 0910 betragen.<br>
Rücklaufquote 25 % = Grundgesamtheit muss mindestens 1160 betragen.<br>
Rücklaufquote 20 % = Grundgesamtheit muss mindestens 1550 betragen.<br>
Rücklaufquote 15 % = Grundgesamtheit muss mindestens 2190 betragen.<br>
Rücklaufquote 10 % = Grundgesamtheit muss mindestens 3480 betragen.<br>
Rücklaufquote 09 % = Grundgesamtheit muss mindestens 3900 betragen.<br>
Rücklaufquote 08 % = Grundgesamtheit muss mindestens 4430 betragen.<br>
Rücklaufquote 07 % = Grundgesamtheit muss mindestens 5120 betragen.<br>
Rücklaufquote 06 % = Grundgesamtheit muss mindestens 6040 betragen.<br>
Rücklaufquote 05 % = Grundgesamtheit muss mindestens 7330 betragen.<br>
<br><br>
<hr><center><br><u>Zufallsgenerator</u>:</center><br>
";
$anzahl_frgb=$ist;
}


while (($zaehler) <= ($anzahl_frgb +1)) {
$zf=mt_rand(0, $N);
 if (!($schonda[$zf])) {
      $schonda[$zf]=$zf;
      $zaehler++;
 }
}

sort($schonda);
$zaehler=1;

echo '<center><table style="border:0px;font-family:verdana;font-size:10px;" width="95%">';
echo '<tr bgcolor="#eeeeee" style="font-family:verdana;font-size:12px;">
<td><b><center>'.$ist.' Zufalls-Merkmalsträger numeriert</td><td><b><center>'.$ist.' Zufalls-Merkmalsträger Zeilen-Listing</td><td><b><center>'.$ist.' Zufalls-Merkmalsträger Semikolon-Separation</td>
</tr>';

echo '<tr><td width="33%"><textarea rows="'.$ist.'" style="width:100%;height:100%;font-family:verdana;font-size:11px;color:#0000ff;background-color:#FFFFD7;" onFocus="this.select()">';


while (($zaehler) < ($ist) + 1) {

   echo "Nr. ".$zaehler.' - Element Grundgesamtheit: '.$schonda[$zaehler]."\n";

$zaehler++;
}

echo "</textarea></td>";


echo '<td width="33%"><center><textarea rows="'.$ist.'" border="0" style="width:100%;height:100%;font-family:verdana;font-size:11px;color:#0000ff;background-color:#FFFFD7;" onFocus="this.select()">';
$zaehler=1;
while (($zaehler) < ($ist) + 1) {

   echo $schonda[$zaehler]."\n";

$zaehler++;
}

echo "</textarea></td>";


echo '<td valign="top" width="34%" align="left"><center><textarea rows="'.$ist.'"  style="width:100%;height:100%;font-family:verdana;font-size:11px;color:#0000ff;background-color:#FFFFD7;" onFocus="this.select()">';
$zaehler=1;
while (($zaehler) < ($ist) + 1) {

   echo $schonda[$zaehler].";";

$zaehler++;
}

echo "</textarea></td></center>";


echo '</tr>';
echo '<tr bgcolor="#eeeeee" style="font-family:verdana;font-size:12px;">
<td><b><center>'.$anzahl_frgb.' Zufalls-Fragebogenempfänger numeriert</td><td><b><center>'.$anzahl_frgb.' Zufalls-Fragebogenempfänger Zeilen-Listing</td><td><b><center>'.$anzahl_frgb.' Zufalls-Fragebogenempfänger Semikolon-Separation</td>
</tr>';
echo '<tr>';

echo '<td width="33%"><textarea rows="'.$anzahl_frgb.'" style="width:100%;height:100%;font-family:verdana;font-size:11px;color:#000000;background-color:#C6FFC6;" onFocus="this.select()">';
$zaehler=1;
while (($zaehler) < ($anzahl_frgb) + 1) {

   echo "Nr. ".$zaehler.' - Element Grundgesamtheit: '.$schonda[$zaehler]."\n";

$zaehler++;
}

echo "</textarea></td>";


echo '<td width="33%"><center><textarea rows="'.$anzahl_frgb.'" border="0" style="width:100%;height:100%;font-family:verdana;font-size:11px;color:#000000;background-color:#C6FFC6;" onFocus="this.select()">';
$zaehler=1;
while (($zaehler) < ($anzahl_frgb) + 1) {

   echo $schonda[$zaehler]."\n";

$zaehler++;
}

echo "</textarea></td>";


echo '<td valign="top" width="34%" align="left"><center><textarea rows="'.$anzahl_frgb.'"  style="width:100%;height:100%;font-family:verdana;font-size:11px;color:#000000;background-color:#C6FFC6;" onFocus="this.select()">';
$zaehler=1;
while (($zaehler) < ($anzahl_frgb) + 1) {

   echo $schonda[$zaehler].";";

$zaehler++;
}

echo "</textarea></td></tr></table></center>
";
echo $text;
}
}
?>

</span>
<span style="font-family:verdana;font-size:11px;">
<br><br>
<hr>
<br>
<b>Nutzungsbedingungen</b><br>
Dieser Online-Rechner zur Berechnung der erforderlichen Mindest-Stichprobengröße für unendliche und endliche Grundgesamtheiten ist für nicht-kommerzielle, insbesondere für Lehr- und Lernzwecke freigegeben!<br>
Unter der Bedingung, dass die Hinweise auf den Urheber weder in den Meta-Tags noch sonst irgendwo im Quelltext verändert, verdeckt oder entfernt werden und die Nutzung ausschließlich nicht-kommerziell erfolgt, darf jede Person das hier zum Download angebotene Script frei verwenden, auch auf der eigenen Seite installieren und den eigenen Nutzern zur Verfügung stellen. Das Script darf auch hinsichtlich seiner Funktionalität (ebenfalls unter weiterer Nennung der ursprünglichen Urheberschaft, erweitert um die vorgenommenen Änderungen und der Nennung der Person, die Änderungen / Erweiterungen vorgenommen hat, wenn gewünscht) verbessert oder erweitert werden, ebenfalls darf es an das eigene Seiten-Design angepasst werden.<br>
Die Nutzung des Scripts erfolgt - gleichwohl Sicherungsfunktionen gegen Missbrauch einprogrammiert wurden - auf eigene Gefahr, für die Richtigkeit der Ergebnisse wird keine Haftung übernommen, auch in jeglicher anderer Hinsicht wird eine Haftung ausgeschlossen.<br>
Bei Nutzung muss das Script durch den Nutzer ebenfalls zum Download angeboten werden. Die hier niedergelegten Nutzungsbedingungen dürfen nicht geändert werden. Die Urheberangaben dürfen nicht gegen die Nutzerdaten ausgetauscht werden.<br>
Wer diese üblichen Nutzungsbedingungen akzeptiert, kann das Script hier downloaden:<br>
<br>
<br>
<b>Hinweis:</b> Das Script wurde in PHP programmiert. Damit es auf anderen Servern lauffähig ist, muss dort zwingend PHP installiert sein. Da auf möglichst weitreichende Abwärtkompatibilität geachtet wurde, reicht PHP in der Version 4.3 aus.
<br><br>



</span>
</body>
</html>
