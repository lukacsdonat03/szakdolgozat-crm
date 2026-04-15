# CRM rendszer

Ez a projekt egy Yii2 alapú CRM rendszer, amely PHP 8.3 környezetben készült.  
A rendszer lokális futtatásra WampServer használata javasolt.

---

## ⚙️ Követelmények

- PHP 8.3
- WampServer (Apache + MySQL)
- MySQL 8.x
- Böngésző
- Visual Studio Code (ajánlott)

---

## 🗄️ Adatbázis létrehozása

Az adatbázis létrehozása az alábbi SQL paranccsal történik:

CREATE DATABASE crm CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

A projekt tartalmaz egy SQL dump fájlt, amely az adatbázis szerkezetét és az alapadatokat is tartalmazza.  
Ezt phpMyAdmin segítségével kell importálni.

Elérés:
http://localhost/phpmyadmin

---

## 🚀 Telepítés

### 1. PHP 8.3 telepítése

Letöltés:  
https://www.php.net/downloads.php?os=windows&osvariant=windows-downloads&version=8.3

Telepítés lépései:
- Csomag kicsomagolása (pl. C:\Program Files\php)
- Elérési út hozzáadása a PATH változóhoz
- Ellenőrzés:
php -v

---

### 2. WampServer telepítése

Letöltés:  
https://wampserver.aviatechno.net/

Telepítés után:
- projekt bemásolása:
C:\wamp64\www\crm

- MySQL 8.x verzió használata javasolt

---

### 3. Virtuális host beállítása

Nyisd meg:
http://localhost/

→ Add Virtual Host

Beállítás:
- Domain: crm.lhost
- Elérési út:
c:/wamp64/www/crm/

Ezután:
- WampServer újraindítása  
vagy  
- DNS restart (Wamp ikon → Tools → Restart DNS)

---

## 🌐 Elérés

A rendszer az alábbi címen érhető el:

http://crm.lhost/

---

## 🔐 Teszt felhasználók

A rendszer használatához bejelentkezés szükséges.

Elérhető fiókok:
- admin
- munkatars
- ceo
- penzugy

Jelszó minden felhasználóhoz:
teszt2026

---

## ⚠️ Hibaelhárítás

Ha a projekt nem indul:

- Ellenőrizd, hogy fut-e:
  - Apache
  - MySQL

- Ellenőrizd a config/db.php fájlt:
  - adatbázis név
  - felhasználónév
  - jelszó

---

## ℹ️ Megjegyzés

Ha a WampServer nem tartalmazza a szükséges PHP vagy MySQL verziót,  
azok külön telepíthetők a hivatalos WampServer add-on csomagokkal.

---

## 📌 Összegzés

A fenti lépések végrehajtásával a rendszer lokálisan futtatható és teljes funkcionalitással kipróbálható.