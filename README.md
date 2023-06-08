# Voedselbank-Maaskantje

Voedselbank-Maaskantje is een webtoepassing ontworpen om een voedselbank operatie te beheren. Het is gebouwd met PHP en interacteert met een MySQL-database.

## Aan de slag

Om te beginnen met het project, clone het repository en stel een lokale ontwikkelomgeving in. 

Je hebt nodig:

- PHP
- MySQL
- Een webserver (zoals Apache)

Het hoofdtoegangspunt van de applicatie is `index.php`.

## Functies

De applicatie biedt verschillende functies, zoals hieronder beschreven:

- **Overzicht van Producten (`alleproducten.php`)**: Deze pagina biedt een overzicht van alle producten in de voorraad van de voedselbank. Het bevat een tabel met de product-ID, naam, beschrijving, categorie, voorraad en EAN-nummer【11†bron】.

- **Overzicht van Werknemers (`allewerknemers.php`)**: Deze pagina biedt een overzicht van alle werknemers die werken bij de voedselbank. Het vermeldt hun ID en naam【23†bron】.

- **Configuratie (`config.php`)**: Dit bestand stelt een verbinding op met de MySQL-database. U moet de instellingen (servernaam, gebruikersnaam, wachtwoord) aanpassen aan uw lokale ontwikkelomgeving【17†bron】.

- **Navigatie (`navigation.php`)**: Dit bestand biedt een navigatiebalk voor de toepassing. Het bevat links naar de startpagina, productoverzicht en meer. Het controleert ook of een gebruiker is ingelogd en biedt op basis van hun rol extra opties【31†bron】.

## Configuratie

In het `config.php` bestand, moet je de variabelen `$servername`, `$username` en `$password` instellen om overeen te komen met je lokale MySQL serverconfiguratie.

## Bijdragen

Bijdragen zijn welkom! Gelieve het repository te forken en veranderingen aan te brengen zoals je wilt. Als je ideeën hebt, open dan een issue en vertel ons wat je denkt.

## Erkenningen

Dit project is ontwikkeld en wordt onderhouden door [Bodilukepoels](https://github.com/Bodilukepoels).