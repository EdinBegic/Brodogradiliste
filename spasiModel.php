<?php
$_REQUEST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_REQUEST);
require 'provjeraAutorizacije.php';
require 'validacija.php';

if(isset($_REQUEST['naziv']) && isset($_REQUEST['cijena']))
{
        // Provjera da li su submit-ani podaci prazni
        if(praznoPolje($_REQUEST['naziv']) || praznoPolje($_REQUEST['cijena']))
        {
            echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }
//        $modeli = simplexml_load_file("lib/xml/modeli.xml");
        // Potrebno je obezbijediti zastitu od XSS-a
        $naziv = xssPrevencija($_REQUEST['naziv']);
        $cijena = xssPrevencija($_REQUEST['cijena']);
        //Validacija podataka
        if(!validacijaCijena($naziv))
        {
            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravan naziv.');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }
        if(!validacijaCijena($cijena))
        {
            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravnu cijenu.');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }

        if(isset($_REQUEST['dodajModel']))
        {
       
            $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
            $veza->exec("set names utf8");
        
            $insert = "INSERT INTO modeli (naziv, cijena) " ."VALUES (?, ?)";

            $iskaz = $veza->prepare($insert);
            $iskaz->bindValue(1, $naziv, PDO::PARAM_STR);
            $iskaz->bindValue(2, $cijena, PDO::PARAM_STR);
            $rezultat = $iskaz->execute();
            //Konekcija kod PDO objekta se zatvara setovanjem objekta na null za razliku
            // od mysqli gdje je potrebno pozvati metodu closedir
            $iskaz = null;
            $veza = null;
            // ukoliko nije uspješan unos
            if($rezultat == false)
            {
                echo "<script type='text/javascript'>alert('Doslo je do pogreske pri unosu u bazu');</script>";
                echo "<script type='text/javascript'>window.location.href='main.php'</script>";
                exit();
            }
           
            echo "<script type='text/javascript'>alert('Uspjesno ste dodali model.');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }
        elseif(isset($_REQUEST['izmijeniModel']) && isset($_REQUEST['idModel']))
        {
            $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
            $veza->exec("set names utf8");
            $update = "UPDATE modeli SET naziv = :naziv, cijena = :cijena WHERE id = :id";
            $iskaz = $veza->prepare($update);
            $iskaz->bindParam(':naziv',$naziv);
            $iskaz->bindParam(':cijena',$cijena);
            $iskaz->bindParam(':id',$_REQUEST['idModel']);
            $rezultat = $iskaz->execute();
            $iskaz = null;
            $veza = null;
            if($rezultat == false)
            {
                echo "<script type='text/javascript'>alert('Doslo je do pogreske pri unosu u bazu');</script>";
                echo "<script type='text/javascript'>window.location.href='main.php'</script>";
                exit();
            }
            echo "<script type='text/javascript'>alert('Uspjesno ste izmijenili model.');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }
    else
    {
        header("Location: katalog.php");
        exit();
    }
}
else
{
    header("Location: katalog.php");
    exit();
}
