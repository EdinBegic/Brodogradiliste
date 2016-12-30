<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/dashboard.css">

    <title>Dashboard-Modeli</title>
</head>
<body>
<?php
require 'provjeraAutorizacije.php';
require 'validacija.php';
if(!file_exists('lib/xml/modeli.xml'))
{
    $mod = new SimpleXMLElement("<modeli></modeli>");
    header("Content-type: text/xml");
    $mod->asXML("lib/xml/modeli.xml");
    header("Location: modeli.php");
    exit();
}
else {
    $mod = simplexml_load_file("lib/xml/modeli.xml");
    foreach ($mod->children() as $model) {
        $str = 'opt_' . $model->id;

        if (isset($_REQUEST[$str])) {
            if ($_REQUEST[$str] == 'OBRISI') // funkcija brisanja
            {
                $dom = dom_import_simplexml($model);
                $dom->parentNode->removeChild($dom);
                $mod->asXML('lib/xml/modeli.xml');
            } elseif ($_REQUEST[$str] == 'IZMIJENI') // funkcija izmjene
            {
                $_SESSION['izmijeni'] = "on";
                $_SESSION['polje'] = $model->id + 0;
            } elseif ($_REQUEST[$str] == 'SPASI') {
                if (isset($_REQUEST['naziv']) && isset($_REQUEST['cijena'])) {
                    if (!praznoPolje($_REQUEST['naziv']) && !praznoPolje($_REQUEST['cijena'])) {
                        if (!validacijaCijena($_REQUEST['naziv'])) // koristim regex kao i za cijenu (jer nazivi brodova nisu sintaksno slicni imenima ljudi)
                        {
                            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravan naziv.');</script>";
                            break;
                        }
                        if (!validacijaCijena($_REQUEST['cijena'])) {
                            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravnu cijenu.');</script>";
                            break;
                        }
                        $model->naziv = xssPrevencija($_REQUEST['naziv']);
                        $model->cijena = xssPrevencija($_REQUEST['cijena']);
                        $mod->asXML('lib/xml/modeli.xml');
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
            <li><a  href="komentari.php">Komentari</a></li>
            <li><a class="active" href="#">Modeli</a></li>
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
if(!file_exists("lib/xml/modeli.xml"))
{
 }
else
{
    $modeli = simplexml_load_file("lib/xml/modeli.xml");
    echo "<div class='row'>";
    echo "<div class='kolona-12'>";
    echo "<form action='modeli.php' method='get'>";
    echo "<table id='tabela'>";
    echo "<tr><th>ID</th><th>NAZIV</th><th>CIJENA</th><th>OPCIJA 1</th><th>OPCIJA 2</th></tr>";

    foreach ($modeli->children() as $model)
    {

        if(isset($_SESSION['izmijeni']))
        {
            if($_SESSION['polje'] == ($model->id + 0) && $_SESSION['izmijeni'] == 'on')
            {
                echo "<tr style='text-align: center'>";
                echo "<td>$model->id</td>";
                echo "<td><input type='text' name='naziv' value='$model->naziv'></td>";
                echo "<td><input type='text' name='cijena' value='$model->cijena'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $model->id . "' value='SPASI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $model->id . "' value='OBRISI'></td>";
                echo "</tr>";
                $_SESSION['izmijeni'] = 'off';
            }
            else
            {
                echo "<tr style='text-align: center'>";
                echo "<td>$model->id</td>";
                echo "<td>$model->naziv</td>";
                echo "<td>$model->cijena</td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $model->id . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $model->id . "' value='OBRISI'></td>";
                echo "</tr>";
            }
        }
        else
        {
            echo "<tr style='text-align: center'>";
            echo "<td>$model->id</td>";
            echo "<td>$model->naziv</td>";
            echo "<td>$model->cijena</td>";
            echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $model->id . "' value='IZMIJENI'></td>";
            echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $model->id . "' value='OBRISI'></td>";
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
