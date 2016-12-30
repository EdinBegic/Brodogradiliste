<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/header.css">
    <link rel="stylesheet" type="text/css" href="lib/css/narudzba.css">
    <script type="text/javascript" src="lib/javascript/narudzba.js"></script>

    <title>Narudžba</title>
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
    <div class="kolona-2 meni_aktivan" id="drugiButton">
        <ul>
            <li id="drugi">
                <a href="#" class="meni_link" ><b>Narudžba</b> </a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="treciButton">
        <ul>
            <li id="treci">
                <a href="kontakt.php" class="meni_link" ><b>Kontakt</b></a>
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
if(!file_exists("lib/xml/Narudzbe.xml")) // Ukoliko ne postoji fajl, kreiraj novi
{
    $narudzbe = new SimpleXMLElement("<Narudzbe></Narudzbe>");
    header("Content-type: text/xml");
    $narudzbe->asXML("lib/xml/Narudzbe.xml");
    header("Location: narudzba.php");
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

        echo "<div class='row' id='trakaOnline' >";
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
    <div class="kolona-12" id="order">
        <h1 id="ord">Narudžba</h1>
    </div>
</div>
<div id="ispodMenija">
<form action="slanjeNarudzbe.php" method="post">
<div class="row" id="ime_red">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="ime_kolona1">
            <label for="fname">Ime:</label>
        </div>
        <div class="kolona-3" id="ime_kolona2">
            <input type="text" id="fname" name="ime" oninput="validacijaIme()" oninvalid="validacijaPrezime()" required autofocus>
        </div>
</div>
    <div class="row" id="prezime_red">
            <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="prezime_kolona1">
            <label for="lname">Prezime:</label>
            </div>
        <div class="kolona-3" id="prezime_kolona2">
            <input type="text" id="lname" name="prezime" oninput="validacijaPrezime()" oninvalid="validacijPrezime()" required>
        </div>
    </div>
    <div class="row" id="email_red">
            <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="email_kolona1">
            <label for="Email">Email:</label>
        </div>
        <div class="kolona-3" id="email_kolona2">
            <input type="text" id="Email" name ="email" oninput="validacijaEmail()" oninvalid="validacijaEmail()" required>
        </div>
    </div>
    <div class="row" id="broj_red">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="broj_kolona1">
            <label for="broj">Telefon:</label>
            </div>
        <div class ="kolona-3" id="broj_kolona2">
            <input type="text" id="broj" name="broj"  oninput="validacijaTelefon()" oninvalid="validacijaTelefon()" required>
        </div>
    </div>
    <div class="row" id="tip_broda_red">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="tip_broda_kolona1">
            <label for="tip_broda">Tip broda:</label>
            </div>
        <div class="kolona-3" id="tip_broda_kolona2">
                <select id="tip_broda" name="tipBroda" class="styled-select blue semi-square">
                    <option value="Jahta">Jahta</option>
                    <option value="Katamaran">Katamaran</option>
                    <option value="Trajekt">Trajekt</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row" id="posalji_red">
        <div class="kolona-12" id="posalji_kolona1">
            <input type="submit" value="Pošalji" id="dugmeZaSlanje">
        </div>
    </div>
</form>
</div>
</body>
</html>