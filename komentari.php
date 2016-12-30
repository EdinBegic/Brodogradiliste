<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/dashboard.css">

    <title>Dashboard-Komentari</title>
</head>
<body>
<?php
require 'provjeraAutorizacije.php';
require 'validacija.php';
if(!file_exists("lib/xml/komentari.xml"))
{
    $kom = new SimpleXMLElement("<komentari></komentari>");
    header("Content-type: text/xml");
    $kom->asXML("lib/xml/komentari.xml");
    header("Location: komentari.php");
    exit();
}
else {
    $kom = simplexml_load_file("lib/xml/komentari.xml");
    foreach ($kom->children() as $komentar) {
        $str = 'opt_' . $komentar->id;

        if (isset($_REQUEST[$str])) {
            if ($_REQUEST[$str] == 'OBRISI') // funkcija brisanja
            {
                $dom = dom_import_simplexml($komentar);
                $dom->parentNode->removeChild($dom);
                $kom->asXML('lib/xml/komentari.xml');
            } elseif ($_REQUEST[$str] == 'IZMIJENI') // funkcija izmjene
            {
                $_SESSION['izmijeni'] = "on";
                $_SESSION['polje'] = $komentar->id + 0;
            } elseif ($_REQUEST[$str] == 'SPASI') {
                // Da li je zaista poslan request?
                if (isset($_REQUEST['email']) && isset($_REQUEST['tekst'])) {
                    // Provjera da li su submit-ani podaci prazni
                    if (!praznoPolje($_REQUEST['email']) && !praznoPolje($_REQUEST['tekst'])) {
                        //Validacija podataka
                        if (!validacijaEmail($_REQUEST['email'])) {
                            echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
                            break;
                        }
                        if (!validacijaKomentar($_REQUEST['tekst'])) {
                            echo "<script type='text/javascript'>alert('Komentar ne moze bit duzi od 100 karaktera');</script>";
                            break;
                        }
                        // Potrebno je obezbijediti zastitu od XSS-a
                        $komentar->email = xssPrevencija($_REQUEST['email']);
                        $komentar->tekst = xssPrevencija($_REQUEST['tekst']);
                        $kom->asXML('lib/xml/komentari.xml');
                    } else {
                        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
                    }
                }
            }
        }
    }
}

?>
<div class="row">
    <div class="kolona-3">
        <h1>Dashboard</h1>
    </div>
</div>
<div class="row">
    <div class="kolona-11">
        <ul>
            <li><a  href="dashboard.php">Narudzbe</a></li>
            <li><a  href="registrovaniClanovi.php">Korisnici</a></li>
            <li><a class="active" href="#">Komentari</a></li>
            <li><a href="modeli.php">Modeli</a></li>
        </ul>
    </div>
    <div class="kolona-1">
        <ul>
            <li style="background-color: #4CAF50">
                <a href="main.php">Pocetna</a>
            </li>
        </ul>
    </div>
</div>

<?php
if(!file_exists("lib/xml/komentari.xml"))
{
 }
else
{
    $komentari = simplexml_load_file("lib/xml/komentari.xml");
    echo "<div class='row'>";
    echo "<div class='kolona-12'>";
    echo "<form action='komentari.php' method='get'>";
    echo "<table id='tabela'>";
    echo "<tr><th>ID</th><th>EMAIL</th><th>KOMENTAR</th><th>OPCIJA 1</th><th>OPCIJA 2</th></tr>";

    foreach ($komentari->children() as $komentar)
    {

        if(isset($_SESSION['izmijeni']))
        {
            if($_SESSION['polje'] == ($komentar->id + 0) && $_SESSION['izmijeni'] == 'on')
            {
                echo "<tr>";
                echo "<td>$komentar->id</td>";
                echo "<td><input type='text' name='email' value='$komentar->email'></td>";
                echo "<td><input type='text' name='tekst' value='$komentar->tekst'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $komentar->id . "' value='SPASI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $komentar->id . "' value='OBRISI'></td>";
                echo "</tr>";
                $_SESSION['izmijeni'] = 'off';
            }
            else
            {
                echo "<tr>";
                echo "<td>$komentar->id</td>";
                echo "<td>$komentar->email</td>";
                echo "<td>$komentar->tekst</td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $komentar->id . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $komentar->id . "' value='OBRISI'></td>";
                echo "</tr>";
            }
        }
        else {

            echo "<tr>";
            echo "<td>$komentar->id</td>";
            echo "<td>$komentar->email</td>";
            echo "<td>$komentar->tekst</td>";
            echo "<td style='text-align: center'><input class='dugme' type='submit' name='opt_" . $komentar->id . "' value='IZMIJENI'></td>";
            echo "<td style='text-align: center'><input class='dugme' type='submit' name='opt_" . $komentar->id . "' value='OBRISI'></td>";
            echo "</tr>";


        }
    }
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</form>";
}

?>

</body>
</html>
