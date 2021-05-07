# CallmeBot
Beschreibung des Moduls.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Senden einer Nachricht aus IP-Symcon über den CallMeBot Dienst an die eigene WhatsApp Nummer.

### 2. Vorraussetzungen

- IP-Symcon ab Version 5.5
- CallMeBot registration und API Key

### 3. Software-Installation

* Alternativ über das Module Control folgende URL hinzufügen:
       `https://github.com/Housemann/CallMeBot`

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'CallmeBot'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Name          | Beschreibung
------------- | ------------------
API Key       | API Key denn man von CallMeBot bekommt
Handynummer   | Eigene Handynummer

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

#### Statusvariablen

Name     | Typ     | Beschreibung
-------- | ------- | ------------
Rückgabe | String  | Rückgabe der API
       |         |


### 6. WebFront

Anzeige ob die Nachricht gesendet wurde.

### 7. PHP-Befehlsreferenz

Funktion zum senden einer Nachricht für die API und Nummer, die im Formular hinterlegt sind.
```php
CMB_SendToWhatsApp($Instance, string $Message);
```