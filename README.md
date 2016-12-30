# Brodogradilište

# Edin Begić, 16701

# Kratak opis

Virtuelni prikaz brodogradilišta na kome će kupci imati opciju naručivanja određenih modela brodova.

# I  - Šta je urađeno? Spirala 1
 Dodao webstranice Pocetna, Narudzba, Kontakt na kome je ispoštovan responzivni dizajn i grid-view prikaz. 
 Na svakoj od ovih stranica postoji html forme na kojoj korisnik unosi određene svoje podatke.
 Implementiran je media querry na početnoj stranici tako da je prikaz optimalan i za telefone uže od 700px.
 Postavljene skice za sve podstranice koje će moja webstranica posjedovati.
# Spirala 2
 Dodao stranicu Katalog na kojoj se nalazi prikaz dostupnih modela za brodove, pri tome za prikaz je korištena
 galerija. 
 Dodao za svaku stranicu javascript fajlove, preko koje je ispoštovana sva validacija u html formama na svim stranicama.
 U main.js se poziva Ajax te se ostale stranice ucitavaju kao podstranice main.html stranice.
# Spirala 3
- Dodao stranicu Registracija na kome posjetitelji imaju opciju registrovanja. 
- Registrovani clanovi se dijele na administratora i obcnih korisnika. 
- Obicni korisnici u odnosu na posjetitelje imaju opciju (nakon prijave) da download-aju PDF izvjestaj sa stranice. 
- Administrator ima mogucnost download-ovanja CSV izvjestaja, kojeg moze preuzeti sa Katalog.php podstranice. 
- Na istoj stranici administrator moze mijenjati pojedine modele (naziv,cijenu), obrisati model, te ako zeli dodati novi model. 
- U dodatne privilegije administratora ukljucuje se i Dashboard vidljiv adminu. 
- Na njemu su izlistani podaci za sve registrovane clanove, sve napisane komentare, sve dodane modele, te narudzbe koje su poslane.
- Na dashboardu admin moze brisati pojedine elemente, odnosno mijenjati neke atribute elemenata.
- Odrađena ja sva validacija submit-anih podataka kako u JS-u tako i u PHP-u. 
- To ukljucuje i dashboard a i glavni dio stranice. XSS je sprijecen koristeci htmlentities funkciju. 
- Implementirano je pretrazivanje na stranici. Search polje 
 se nalazi na main.php gdje sve vrste korisnika unose kljucnu rijec na osnovu koje se izlistaju modeli (njihovi nazivi i
 cijene) koje sadrze tu rijec (slovo) u svom opisu. 
- Klikom na dugme pretrazi otvara se Katalog.php na kome bivaju izlistani modeli koji su bili predlozeni u search sugestijama.
# II  - Šta nije urađeno? Spirala 1
 Nisu implementirani media querry-iji na ostale dvije stranice.
 Nisu postavljene skice za prikaz na telefonu.
# Spirala 2
 Nije implementiran drop-down meni.
# Spirala 3
 Sve je implementirano.
 
# III - Bug-ovi koje ste primijetili ali niste stigli ispraviti, a znate rješenje (opis rješenja)
# IV  - Bug-ovi koje ste primijetili ali ne znate rješenje
# V  - Lista fajlova u formatu NAZIVFAJLA - Opis u vidu jedne rečenice šta se u fajlu nalazi 

 **Testni podaci**
- izvjestaj.csv - izvjestaj u csv formatu generisane za modele brodova
- pdfIzvjestaj.pdf - PDF izvjestaj za testne podatke u XML file-ovima
 **PHP file-ovi**

- **csvIzvjestaj.php** -Skriptu koju pozivam s katalog.php da bi se generisao csv izvjestaj
- **dashboard.php** - Pocetna stranica dashboard-a kome ima pristup samo admin (izlistane sve spašene narudžbe)
- **katalog.php** - stranica na kome su prikazani svi modeli brodova (admin moze dodavati,brisati,mijenjati modele)
- **komentari.php** - podstranica dashboarda na kome admin ima mogućnost izmjene ili brisanja
 				već postojećih komentara
- **kontakt.php** - stranica na kome se nalaze kontakt informacije o brodogradilistu, korisnik
 				može slati neki svoj komentar
- **main.php** - pocetna stranica projekta, na njoj se nalazi prijava korisnickog racuna,
 			search polje i pdf izvjestaj (ukoliko je logovan korisnik)
- **modeli.php** - podstranica dashboarda na kome admin ima mogućnost izmjene ili brisanja
 			već postojećih modela
- **narudzba.php** - stranica na kojoj korisnici (ne moraju biti logovani) mogu slati narudzbe
 			   za željenu vrstu broda
- **odjva.php** - na svakoj stranici postoji traka ispod navbar-a, koja se prikazuje kad je korisnik
 		    logovan, klikom na dugme odjava poziva se ova skripta koja završava sesiju
 		    korisnika
- **pdfIzvjestaj.php** - Skriptu koju pozivam s main.php da bi se generisao pdf izvjestaj (koristio
 					sam fpdf biblioteku)
- **pretraga.php** - skripta koja se poziva kroz javascript file, tj. main.js kako bi se pokrenula
 				pretraga po kljucnoj rijeci
- **prijava.php** - skripta koja se poziva kada korisnik na main.php unese svoj username i password
 			  te se u njoj pokreće sesija za tog korisnika i vraća na prethodnu stranicu
- **provjeraAutorizacije.php**- skriptu koju pozivam kad god mi je potrebna provjera da li je
 						  korisnik koji zeli pristupiti stranici admin , ukoliko nije vraća	
 						  na prethodnu stranicu
- **registracija.php** - stranica na kojoj se posjetitelji stranice mogu registrovati,
 					kada su logovani ne mogu pristupiti ovoj stranici
- **registrovaniClanovi.php**  - podstranica dashboarda na kome admin ima mogućnost izmjene ili
 							brisanja već postojećih korisnika
- **slanjeKomentara.php** - skripta koja se aktivira submitanjem komentara s kontakt.php i u kojoj
 					  se spašava novi komentar u XML doc komentari.xml
- **slanjeModela.php** - stranica koja se prikaže kada admin u katalog.php odluci dodati/izmijeniti model
- **slanjeNarudzbe.php** - skripta koja se aktivira submitanjem narudzbe s narudzba.php i u kome
 					 se spašava nova narudzba u XML doc Narudzbe.xml
- **slanjeRegistracije.php** - skripta koja se aktivira submitanjem registracije s registracija.php i u kome
 					 se spašava nova registracija u XML doc korisnici.xml
- **spasiModel.php** - skripta koja se aktivira kada se admin odluci dodati novi model ili izmjeniti postojeći
 				 u slanjeModela.php te nove informacije spašava u modeli.xml
- **validacija.php** - skripta u kojoj se nalaze funkcije za validaciju svih input polja na ovom site-u
 
 **CSS file-ovi** 

- **main.css** - odgovarajući css fajl za početnu podstranicu
- **kontakt.css** - odgovarajući css fajl za kontakt podstranicu
- **narudzba.css** - odgovarajući css fajl za narudzba podstranicu
- **header.css** - zajednicki css fajl u kojem je definisano ponašanje menija (ne ukljucuje dasboard) 
- **katalog.css** - zajednicki css fajl za katalog podstranicu i slanjeModela.php
- **registracija.css** - odgovarajući css fajl za registracija podstranicu 
- **dashboard.css** - zajednicki css fajl za dashboard.php, modeli.php, komentari.php i registrovaniClanovi.php
 
 **JS file-ovi**
 
- **main.js** - odgovarajući javascript fajl za pocetnu stranicu (funkcije za validaciju, poziv ajax-a za search)
- **narudzba.js** - odgovarajući javascript fajl za narudzba podstranicu (funkcije za validaciju)
- **katalog.js** - odgovarajući javascript fajl za katalog podstranicu (funkcije za validaciju)
- **kontakt.js** - odgovarajući javascript fajl za kontakt podstranicu (funkcije za validaciju)
- **registracija.js** - odgovarajući javascript fajl za registracija podstranicu (funkcije za validaciju)

 **XML file-ovi**
 
- **komentari.xml** - u ovom file-u se čuvaju svi komentari koji su poslani s kontakt.php stranice (i dashboard-a)
- **korisnici.xml** - u ovom file-u se čuvaju svi registrovani članovi koji su reg-ovani na registracija.php (i dashboard-u)
- **modeli.xml** - u ovom file-u se čuvaju svi modeli koje je admin dodao na katalog.php stranici (i dashboard-u)
- **Narudzbe.xml** - u ovom file-u se čuvaju sve narudzbe koje su posjetitelji submit-ali s narudzba.php stranice

 **FPDF folder**

- U ovom folderu se nalaze file-ovi za pokretanje FPDF biblioteke, kako bi se mogao generisati .pdf izvjestaj za stranicu 

 **Pictures folder**
 
- **contact.jpg** - background-image za svaku podstranicu
- **jahta2.jpg**, **katamaran2.jpg**, **trajekt2.jpg** - slike korištene za prikaz modela
- **brodRatni.jpg** - slika koristena za svaki novi dodani model
- **logo_brod.jpg** - logo webstranice
- **more.png** - background-image za status label admin-a i korisnika kada su online
- **lupa.png** - slika korištena u search polju

 **Skice folder**
- **cijenovnik.png**,**kontakt.png**,**narudzba.png**,**pocetna.png**,**zahtjev.png** - skice napravljene za podstranice
katalog.html - Podstranica na kojoj korisnik ima priliku pregledati slike dostupnih modela brodova, pri čemu je prikaz
uspostavljen kao galerija slika, što je traženo u spirali 2

