<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/dashboard.css">

    <title>Dashboard</title>
</head>
<body>

<?php
    require 'provjeraAutorizacije.php';
    require 'validacija.php';
    if(!file_exists("lib/xml/Narudzbe.xml"))
    {
        $nar = new SimpleXMLElement("<Narudzbe></Narudzbe>");
        header("Content-type: text/xml");
        $nar->asXML("lib/xml/Narudzbe.xml");
        header("Location: dashboard.php");
        exit();
    }
    else {
        $nar = simplexml_load_file("lib/xml/Narudzbe.xml");
        foreach ($nar->children() as $narudzba) {
            $str = 'opt_' . $narudzba->id;

            if (isset($_REQUEST[$str])) {
                if ($_REQUEST[$str] == 'OBRISI') // funkcija brisanja
                {
                    $dom = dom_import_simplexml($narudzba);
                    $dom->parentNode->removeChild($dom);
                    $nar->asXML('lib/xml/Narudzbe.xml');
                } elseif ($_REQUEST[$str] == 'IZMIJENI') // funkcija izmjene
                {
                    $_SESSION['izmijeni'] = "on";
                    $_SESSION['polje'] = $narudzba->id + 0;
                } elseif ($_REQUEST[$str] == 'SPASI') {
                    // Da li je zaista poslan request?
                    if (isset($_REQUEST['ime']) && isset($_REQUEST['prezime']) && isset($_REQUEST['email']) && isset($_REQUEST['telefon']) && isset($_REQUEST['tipBroda'])) {
                        // Provjera da li su submit-ani podaci prazni
                        if (!praznoPolje($_REQUEST['ime']) && !praznoPolje($_REQUEST['prezime']) && !praznoPolje($_REQUEST['email']) && !praznoPolje($_REQUEST['telefon'])
                            && !praznoPolje($_REQUEST['tipBroda'])
                        ) {
                            if (!validacijaIme($_REQUEST['ime'])) {
                                echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravno ime.');</script>";
                                break;
                            }
                            if (!validacijaPrezime($_REQUEST['prezime'])) {
                                echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravno prezime.');</script>";
                                break;
                            }
                            if (!validacijaEmail($_REQUEST['email'])) {
                                echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
                                break;
                            }
                            if (!validacijaTelefon($_REQUEST['telefon'])) {
                                echo "<script type='text/javascript'>alert('Validan oblik broja telefona: [111-111-111] ili [111 111 111] ili [111/111/111]');</script>";
                                break;
                            }
                            if (!validacijaIme($_REQUEST['tipBroda'])) {
                                echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neisrpavan naziv');</script>";
                                break;
                            }

                            // Potrebno je obezbijediti zastitu od XSS-a
                            $narudzba->ime = xssPrevencija($_REQUEST['ime']);
                            $narudzba->prezime = xssPrevencija($_REQUEST['prezime']);
                            $narudzba->email = xssPrevencija($_REQUEST['email']);
                            $narudzba->telefon = xssPrevencija($_REQUEST['telefon']);
                            $narudzba->tipBroda = xssPrevencija($_REQUEST['tipBroda']);
                            $nar->asXML('lib/xml/Narudzbe.xml');
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
            <li><a class="active" href="#">Narudzbe</a></li>
            <li><a href="registrovaniClanovi.php">Korisnici</a></li>
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
if(!file_exists("lib/xml/Narudzbe.xml"))
{

}
else
{
    $narudzbe = simplexml_load_file("lib/xml/Narudzbe.xml");
    echo "<div class='row'>";
    echo "<div class='kolona-12'>";
    echo "<form action='dashboard.php' method='get'>";
    echo "<table id='tabela'>";
    echo "<tr><th>ID</th><th>IME</th><th>PREZIME</th><th>EMAIL</th><th>TELEFON</th><th>TIP BRODA</th><th>OPCIJA 1</th><th>OPCIJA 2</th></tr>";

    foreach ($narudzbe->children() as $narudzba)
    {

        if(isset($_SESSION['izmijeni']))
        {
            if($_SESSION['polje'] == ($narudzba->id + 0) && $_SESSION['izmijeni'] == 'on')
            {
                echo "<tr>";
                echo "<td>$narudzba->id</td>";
                echo "<td><input type='text' name='ime' value='$narudzba->ime'></td>";
                echo "<td><input type='text' name='prezime' value='$narudzba->prezime'></td>";
                echo "<td><input type='text' name='email' value='$narudzba->email'></td>";
                echo "<td><input type='text' name='telefon' value='$narudzba->telefon'></td>";
                echo "<td><input type='text' name='tipBroda' value='$narudzba->tipBroda'></td>";
                echo "<td style='text-align: center'><input type='submit'  class='dugme' name='opt_" . $narudzba->id . "' value='SPASI'></td>";
                echo "<td style='text-align: center'><input type='submit'  class='dugme' name='opt_" . $narudzba->id . "' value='OBRISI'></td>";
                echo "</tr>";
                $_SESSION['izmijeni'] = 'off';
            }
            else
            {
                echo "<tr>";
                echo "<td>$narudzba->id</td>";
                echo "<td>$narudzba->ime</td>";
                echo "<td>$narudzba->prezime</td>";
                echo "<td>$narudzba->email</td>";
                echo "<td>$narudzba->telefon</td>";
                echo "<td>$narudzba->tipBroda</td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $narudzba->id . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $narudzba->id . "' value='OBRISI'></td>";
                echo "</tr>";
            }
        }
        else {
            echo "<tr>";
            echo "<td>$narudzba->id</td>";
            echo "<td>$narudzba->ime</td>";
            echo "<td>$narudzba->prezime</td>";
            echo "<td>$narudzba->email</td>";
            echo "<td>$narudzba->telefon</td>";
            echo "<td>$narudzba->tipBroda</td>";
            echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $narudzba->id . "' value='IZMIJENI'></td>";
            echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $narudzba->id . "' value='OBRISI'></td>";
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
