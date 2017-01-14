<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/header.css">
    <link rel="stylesheet" type="text/css" href="lib/css/main.css">


     <title>Virtuelno Brodogradilište</title>
</head>


<body>

    <div class="row" id="vrh">
            <div class="kolona-12">
                <img id="logo" src="Pictures/logo_brod.jpg" alt="Nije se mogla ucitati slika">
            </div>
        <div class="kolona-2 meni_aktivan" id="prviButton">
                 <ul>
                     <li id="prvi">
                         <a href="#" class="meni_link" > <b>Početna</b></a>
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

if(isset($_SESSION['username']))
{
    if($_SESSION['username'] == 'admin')
    {
        // Kreiraj dashboard podstranicu za admina
        echo '<script language="javascript">';
        echo "document.getElementById('stanjeButton').innerHTML = '<a><b>Dashboard</b></a>';";
        echo "document.getElementById('sesti').style.backgroundColor ='black';";
        echo '</script>';

        // Prikaz interfejsa za admina kad je admin logovan
        echo "<div id='trakaOnline' class='row' >";
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
        // Prikaz interfejsa za registrovanog korisnika kad je logovan
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
  <div class="podstranica" id="podstr">
    <div class="row" id="ispod_headera">
        <div class="kolona-12" id="about">
            <h1 id="oBrodogradilistu">O brodogradilištu</h1>
        </div>
    </div>
    <div id="IspodMenija">
    <div class="row" id="glavni_dio">
        <div class="kolona-12">
            <p>
                Dobrodošli u virtuelni prikaz brodogradilišta. Na ovoj webstranici korisnici imaju mogućnost
                narudžbe raznih vrsta brodova iz bogatog kataloga, kojeg možete preuzeti kao cijenovnik.
                Za sve potrebne informacije kako nas kontaktirati, molimo vas provjerite Kontakt tabu.
            </p>
        </div>
    </div>
    <div class="row pretraga">
        <div class="kolona-12">
            <h1>Pronadjite željeni model broda</h1>
        </div>
    </div>
        <div class="pretraga1">
            <form action="katalog.php" method="get" id="f1">
            <div class="kolona-4">&nbsp;</div>
            <div class="kolona-4" style="text-align: center">
                <div class="pretraga2">
                <input type="search" id="pretraga" placeholder="Unesite rijec(i) za pretragu" name="pretraga">
                </div>
                <div id="uzivoPretraga" class="row"></div>
            </div>
                <div class="kolona-2" style="text-align: left">
                    <input id="dugmePretraga" style='font-size: 120%; border-radius: 4px;' type="submit"  value="Pretrazi">
                </div>

                <div class="kolona-3">&nbsp;</div>
            </form>
        </div>


        <?php
        if(isset($_SESSION['username'])) {

            if($_SESSION['username'] == 'admin')
            {
                echo '<div class="row" id="izvjestaj">';
                echo '<div class="kolona-12" id="pdfLabel">';
                echo '<p><h2>Sacuvajte podatke iz XML-a u bazu<h2></p>';
                echo '</div>';
                echo '<div class="kolona-12" id="pdfDokument">';
                echo '<form method="post" action="xmlImport.php">';
                echo '<input type="hidden" name="importujXML" value="1">';
                echo '<input type="submit" id="dugmePDF" style="font-size: 120%" value="Importuj podatke">';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
            echo '<div class="row" id="izvjestaj">';
            echo '<div class="kolona-12" id="pdfLabel">';
            echo '<p><h2>Izvještaj o web stranici zapisan u PDF-u<h2></p>';
            echo '</div>';
            echo '<div class="kolona-12" id="pdfDokument">';
            echo '<form method="post" action="pdfIzvjestaj.php">';
            echo '<input type="hidden" name="kreirajPdf" value="1">';
            echo '<input type="submit" id="dugmePDF" style="font-size: 120%" value="Preuzmi izvjestaj">';
            echo '</form>';
            echo '</div>';
            echo '</div>';

        }
        ?>
        <div class="row" id="formaPrijava">
            <div class="kolona-12">Prijava korisnika</div>
        </div>
        <form method="post" action="prijava.php">
            <div class="row" id="formaZaPrijavuUser">
                <div class="kolona-3">&nbsp;</div>
                <div class="kolona-3" id="userLabel"><b>Username:</b></div>
                <div class="kolona-3" id="userPolje"><input id="fname" type="text" name="username" required autofocus oninput="validacijaUser()" oninvalid="validacijaUser()"></div>
            </div>
            <div class="row" id="formaZaPrijavuPass">
                <div class="kolona-3">&nbsp;</div>
                <div class="kolona-3" id="passLabel"><b>Password:</b></div>
                <div class="kolona-3" id="passPolje"><input id="lname" type="password" name="password" required oninput="validacijaPassword()" oninvalid="validacijaPassword()"> </div>
            </div>
            <div class="row" id="formaZaPrijavuSubmit">
                <div class="kolona-12" id="prijaviButtonKolona"><input id="dugmeZaSlanje"type="submit" value="Prijavi se"></div>
            </div>
        </form>
  </div>
</div>
<?php
if(isset($_SESSION['username']))
{
    echo '<script language="javascript">';
    echo "document.getElementById('formaPrijava').style.display = 'none';";
    echo "document.getElementById('formaZaPrijavuUser').style.display = 'none';";
    echo "document.getElementById('formaZaPrijavuPass').style.display = 'none';";
    echo "document.getElementById('formaZaPrijavuSubmit').style.display = 'none';";
    echo '</script>';
}

?>
    <script type="text/javascript" src="lib/javascript/main.js"></script>

</body>

</html>