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
- scripts/output.php
    - Enthält das PHTML, welches am Ende ausgegeben wird
- src/Hardware.php
    - Die Klasse für ein Hardware Gerät
- src/Transporter 
    - Die Klasse für einen Transporter
