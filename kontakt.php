<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/header.css">
    <link rel="stylesheet" type="text/css" href="lib/css/kontakt.css">
    <script type="text/javascript" src="lib/javascript/kontakt.js"></script>

    <title>Kontakt</title>
</head>
<body>
<div class="row" id="vrh">
    <div class="kolona-12">
        <img id="logo" src="Pictures/logo_brod.jpg" alt="Nije se mogla ucitati slika">
    </div>
    <div class="kolona-2 meni" id="prviButton">
        <ul>
            <li id="prvi">
                <a href="main.php" class="meni_link" > <b>Početna</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="drugiButton">
        <ul>
            <li id="drugi">
                <a href="narudzba.php" class="meni_link" ><b>Narudžba</b> </a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni_aktivan" id="treciButton">
        <ul>
            <li id="treci">
                <a href="#" class="meni_link" ><b>Kontakt</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="cetvrtiButton">
        <ul>
            <li id="cetvrti">
                <a href="katalog.php" class="meni_link" ><b>Katalog</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="petiButton">
        <ul>
            <li id="peti">
                <a href="registracija.php" class="meni_link" ><b>Registracija</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="sestiButton">
        <ul>
            <li id="sesti">
                <a class="meni_link" id="stanjeButton" href="dashboard.php">&nbsp; </a>
            </li>
        </ul>
    </div>
</div>
<?php
session_start();
if(!file_exists("lib/xml/komentari.xml")) // Ukoliko ne postoji fajl, kreiraj novi
{
    $komentari = new SimpleXMLElement("<komentari></komentari>");
    header("Content-type: text/xml");
    $komentari->asXML("lib/xml/komentari.xml");
    header("Location: kontakt.php");
    exit();
}
if(isset($_SESSION['username']))
{
    if($_SESSION['username'] == 'admin')
    {
        // Kreiraj dashboard podstranicu za admina
        echo '<script language="javascript">';
        echo "document.getElementById('stanjeButton').innerHTML = '<a><b>Dashboard</b></a>';";
        echo "document.getElementById('sesti').style.backgroundColor ='black';";
        echo '</script>';

        echo "<div class='row' id='trakaOnline' '>";
        echo "<div class='altKolona-2' style='text-align: center; background-color: lightgreen; border-radius: 10px'>";
        echo "Dobro došao ".$_SESSION['username'];
        echo "<form action='odjava.php' method='post'>";
        echo "<button type='submit' name='odjava'>Odjavi se</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    else
    {
        echo "<div class='row' id='trakaOnline' >";
        echo "<div class='altKolona-2' style='text-align: center; background-color: yellow; border-radius: 10px'>";
        echo "Dobro došao ".$_SESSION['username'];
        echo "<form action='odjava.php' method='post'>";
        echo "<button type='submit' name='odjava'>Odjavi se</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";

    }
}
?>
<div class = "row" id="ispod_headera">
    <div class="kolona-12" id="contact-us">
        <h1 id="kont">Kontakt</h1>
    </div>
</div>
<div class="row" id="glavni_dio">

    <div class="kolona-6" id="lijevi_dio">
        <h1 id="Lokacija">Lokacija</h1>
        <p id="neum">
            Neum, Federacija BiH, BiH</p>
        <p id="safet">
            Ulica Safeta Isovića, br. 23
        </p>
        <p>
            &nbsp;
        </p>
    </div>
    <div class="kolona-6" id="desni_dio">
        <h1 id="Kontakt-info">
            Kontakt informacije
        </h1>
        <p id="br-telefona">
            Broj telefona: +387 62 111 111
        </p>
        <p id="fax">
            Fax: 123 456
        </p>
        <p id="email">
            email: ebegic2@etf.unsa.ba
        </p>
    </div>
</div>
<div class="row" id="donji_dio">
    <div class="kolona-12" id="kolona_pitanje">
        <h1>Imate pitanja?</h1>
        <p>Ukoliko imate neka pitanja, možete ostaviti email adresu ili broj telefona, a mi ćemo vas u dogledno vrijeme kontaktirati.</p>
    </div>
</div>
<form action="slanjeKomentara.php" method="post">
<div class="row" id ="pomoc_forma">

        <div class="kolona-4">&nbsp;</div>
        <div class="kolona-3" id="unosPolje">
        <input type="text" id="fname" name="email" placeholder="Email" oninput="validacijaEmail()" oninvalid="validacijaEmail()" autofocus required>
        </div>
 </div>
    <div class="row" id ="pomoc_forma2">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-6" id="koment">
            <textarea id="komentar" name="tekst" rows="6" placeholder="Napisite svoj komentar" oninput="validacijaKomentar()" oninvalid="validacijaKomentar()" autofocus required></textarea>
        </div>
    </div>
<div class ="row" id ="proslijediInfo">
    <div class="kolona-2">&nbsp;</div>
     <div class="kolona-2">&nbsp;</div>
    <div class="kolona-4" id="proslijediArgument">
        <input id="dugmeZaSlanje" type="submit" value="Pošalji">
    </div>
</div>
</form>



</body>
</html>