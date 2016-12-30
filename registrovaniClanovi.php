<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/dashboard.css">

    <title>Dashboard-Clanovi</title>
</head>
<body>
<?php
require 'provjeraAutorizacije.php';
require 'validacija.php';
if(!file_exists("lib/xml/korisnici.xml"))
{
    $kor = new SimpleXMLElement("<korisnici></korisnici>");
    header("Content-type: text/xml");
    $kor->asXML("lib/xml/korisnici.xml");
    header("Location: registrovaniClanovi.php");
    exit();
}
else {
    $kor = simplexml_load_file("lib/xml/korisnici.xml");
    foreach ($kor->children() as $korisnik) {
        if ($korisnik->priv == 1)
            continue;
        $str = 'opt_' . $korisnik->id;

        if (isset($_REQUEST[$str])) {
            if ($_REQUEST[$str] == 'OBRISI') // funkcija brisanja
            {
                $dom = dom_import_simplexml($korisnik);
                $dom->parentNode->removeChild($dom);
                $kor->asXML('lib/xml/korisnici.xml');
            } elseif ($_REQUEST[$str] == 'IZMIJENI') // funkcija izmjene
            {
                $_SESSION['izmijeni'] = "on";
                $_SESSION['polje'] = $korisnik->id + 0;
            } elseif ($_REQUEST[$str] == 'SPASI') {
                if (isset($_REQUEST['username']) && isset($_REQUEST['email'])) {
                    if (!praznoPolje($_REQUEST['username']) && !praznoPolje($_REQUEST['email'])) {
                        if (!validacijaUsername($_REQUEST['username'])) {
                            echo "<script type='text/javascript'>alert('Username se moze sastojati samo od alfanumerickih znakova duzine od 2 do 18 karaktera');</script>";
                            break;
                        }
                        if (!validacijaEmail($_REQUEST['email'])) {
                            echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
                            break;
                        }
                        if (!jedinstvenostUsername($_REQUEST['username'])) {
                            echo "<script type='text/javascript'>alert('Postoji korisnik s takvim username-om');</script>";
                            break;
                        }
                        $korisnik->username = xssPrevencija($_REQUEST['username']);
                        $korisnik->email = xssPrevencija($_REQUEST['email']);
                        $kor->asXML('lib/xml/korisnici.xml');
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
            <li><a class="active" href="#">Korisnici</a></li>
            <li><a href="komentari.php">Komentari</a></li>
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
if(!file_exists("lib/xml/korisnici.xml"))
{
 }
else
{
    $korisnici = simplexml_load_file("lib/xml/korisnici.xml");
    echo "<div class='row'>";
    echo "<div class='kolona-12'>";
    echo "<form action='registrovaniClanovi.php' method='get'>";
    echo "<table id='tabela'>";
    echo "<tr><th>ID</th><th>USERNAME</th><th>EMAIL</th><th>OPCIJA 1</th><th>OPCIJA 2</th></tr>";

    foreach ($korisnici->children() as $korisnik)
    {
        if($korisnik->priv == 1)
            continue;
        if(isset($_SESSION['izmijeni']))
        {
            if($_SESSION['polje'] == ($korisnik->id + 0) && $_SESSION['izmijeni'] == 'on')
            {
                echo "<tr style='text-align: center'>";
                echo "<td>$korisnik->id</td>";
                echo "<td><input type='text' name='username' value='$korisnik->username'></td>";
                echo "<td><input type='text' name='email' value='$korisnik->email'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $korisnik->id . "' value='SPASI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $korisnik->id . "' value='OBRISI'></td>";
                echo "</tr>";
                $_SESSION['izmijeni'] = 'off';
            }
            else
            {
                echo "<tr style='text-align: center'>";
                echo "<td>$korisnik->id</td>";
                echo "<td>$korisnik->username</td>";
                echo "<td>$korisnik->email</td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $korisnik->id . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $korisnik->id . "' value='OBRISI'></td>";
                echo "</tr>";
            }
        }
        else {
            if($korisnik->priv == 0)
            {
                echo "<tr style='text-align: center'>";
                echo "<td>$korisnik->id</td>";
                echo "<td>$korisnik->username</td>";
                echo "<td>$korisnik->email</td>";
                echo "<td style='text-align: center'><input type='submit'  class='dugme' name='opt_" . $korisnik->id . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme'   name='opt_" . $korisnik->id . "' value='OBRISI'></td>";
                echo "</tr>";
            }

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
