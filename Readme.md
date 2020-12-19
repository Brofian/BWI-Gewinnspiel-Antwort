Hinweis
---
Diese Lösung baut auf einem beliebig erweiterbaren Design auf. 
Man ist also zum Beispiel nicht auf die Anzahl der Geräte oder Transporter beschränkt, sondern kann diese beliebig in der index.php anpassen.

Der Code des `master`-Branches ist englisch (Ausgenommen der Hardware-Bezeichnungen).
Für eine komplette, deutsche Übersetzung gibt es den `german`-Branch.


Ausführung
---
Für die Ausführung des Codes stehen zwei Möglichkeiten zur Verfügung:
1) Ist auf dem aktuellen Rechner / Server PHP installiert, kann das Programm über die Kommandozeile mit  `php pfad/zum/projekt/index.php` gestartet werden
2) Sollte das Programm auf einem Webserver installiert sein, kann durch das aufrufen der index.php im Browser das Programm gestartet werden
    - Beispielsweise kann das Programm Xampp installiert und die Dateien darin im Ordner `htdocs` abgelegt werden. Das Programm kann dann im Browser unter `localhost` aufgerufen werden

Hinweis: Die Ansicht im Browser enthält mehr Details, während sich die CLI-Ansicht auf das Ergebnis beschränkt

Achtung: Für die korrekte Ausführung des Codes ist mindestens PHP 7.1 erforderlich 



Wahl des Algorythmus
---
Der von mir gewählte Algorythmus besteht aus zwei Stufen:

1) Befüllen der Transporter mit der Hardware mit dem besten Gewicht-Nutzwert-Verhältnis

2) Austauschen einzelner Hardware Geräte um den verbleibenden Platz zu nutzen




Vorgehensweise
---

1) Für jede Hardware wird ein Effizienzwert ausgerechnet:
    - Nutzwert / Gewicht in g 
2) Die Hardware wird nach Effizienz sortiert

3) Die Transporter werden mit möglichst viel effizienter Hardware beladen

4) Jeder Transporter prüft, ob genug Platz vorhanden ist, ein Gerät mit einem schwereren Auszutauschen, das einen höheren Nutzwert besitzt
    - Es wird auf einen 1:1 und einen 1:2 Tausch geprüft

5) Schritt 4 wird wiederholt, bis keine Änderungen mehr gemacht werden




Dateien
---
- index.php
    - Haupt-Datei, Einstiegspunkt und deklariert die Variablen
- scripts/compute.php
    - Enthält den Algorythmus zum Befüllen der Transporter
- scripts/output-browser.php
    - Enthält das PHTML, welches bei einem Aufruf über den Browser ausgegeben wird
- scripts/output-cli.php
    - Enthält die Ausgabe der Lösung für einen Aufruf über die Kommandozeile
- src/Hardware.php
    - Die Klasse für ein Hardware Gerät
- src/Transporter.php 
    - Die Klasse für einen Transporter
