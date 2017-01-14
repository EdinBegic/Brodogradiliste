<?php
session_start();
$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

if(!isset($_SESSION['username']))
{
    header("Location: main.php");
    exit();
}
else
{
    if($_SESSION['username'] != 'admin')
    {
        header("Location: main.php");
        exit();
    }
    else if(isset($_POST['importujXML']))
    {
        // Importujmo prvo podatke iz modeli.xml
        $modeli = simplexml_load_file('lib/xml/modeli.xml');
        // otvorimo konekciju
        $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
        $veza->exec("set names utf8");

        // Modeli
        foreach ($modeli->children() as $model)
        {
            $query = "SELECT COUNT(naziv) AS brojac FROM modeli WHERE naziv = :naziv";
            $iskaz = $veza->prepare($query);
            $iskaz->bindParam(':naziv', $model->naziv);
            $iskaz->execute();
            $row = $iskaz->fetch(PDO::FETCH_ASSOC);
            if($row['brojac'] == 0) // Dodaj u bazu 
            {
                $query2 = "INSERT INTO modeli (naziv, cijena) VALUES (:naziv, :cijena)";
                $iskaz2 = $veza->prepare($query2);
                $iskaz2->bindParam(':naziv', $model->naziv);
                $iskaz2->bindParam(':cijena', $model->cijena);
                $iskaz2->execute();
                $iskaz2 = null;
            }
            $iskaz1 = null;
            $iskaz = null;
         }
        // Importujmo sada korisnike
        $korisnci = simplexml_load_file('lib/xml/korisnici.xml');
        foreach ($korisnci->children() as $korisnik)
        {
            $query = "SELECT COUNT(username) AS brojac FROM korisnik WHERE username = :username";
            $iskaz = $veza->prepare($query);
            $iskaz->bindParam(':username', $korisnik->username);
            $iskaz->execute();
            $row = $iskaz->fetch(PDO::FETCH_ASSOC);

            if($row['brojac'] == 0) // Dodaj u bazu (samo je bitno da ne postoji korisnik s istim username-om, password i email se mogu ponoviti)
            {
                $query3 = "INSERT INTO korisnik (username, password, email) VALUES (:username, :password, :email)";
                $iskaz3 = $veza->prepare($query3);
                $iskaz3->bindParam(':username', $korisnik->username);
                $iskaz3->bindParam(':password', $korisnik->password);
                $iskaz3->bindParam(':email',$korisnik->email);
                $iskaz3->execute();
                $iskaz3 = null;
            }
            $iskaz = null;
         }
        // Importujmo sada narudzbe
        $narudzbe = simplexml_load_file('lib/xml/Narudzbe.xml');
        foreach ($narudzbe->children() as $narudzba)
        {
            $query = "SELECT COUNT(ime) AS brojac FROM narudzba WHERE ime = :ime";
            $iskaz = $veza->prepare($query);
            $iskaz->bindParam(':ime', $narudzba->ime);
            $iskaz->execute();
            $row = $iskaz->fetch(PDO::FETCH_ASSOC);

            $query1 = "SELECT COUNT(prezime) AS brojac FROM narudzba WHERE prezime = :prezime";
            $iskaz1 = $veza->prepare($query1);
            $iskaz1->bindParam(':prezime', $narudzba->prezime);
            $iskaz1->execute();
            $row1 = $iskaz1->fetch(PDO::FETCH_ASSOC);

            $query2 = "SELECT COUNT(telefon) AS brojac FROM narudzba WHERE telefon = :telefon";
            $iskaz2 = $veza->prepare($query2);
            $iskaz2->bindParam(':telefon', $narudzba->telefon);
            $iskaz2->execute();
            $row2 = $iskaz2->fetch(PDO::FETCH_ASSOC);

            if($row['brojac'] == 0 || $row1['brojac'] == 0 || $row2['brojac'] == 0) 
            {
                $idKorisnika = 7; // Kako je admin log-ovan a ovo njegov primary key, neka novi unosi budu povezani sa adminom
                                 // jer u xml-u ne postoje podaci o korisniku za kojeg se vežu
                $query4 = "INSERT INTO narudzba (ime, prezime, telefon, tipBroda, korisnik) VALUES (:ime, :prezime, :telefon, :tipBroda, :korisnik)";
                $iskaz4 = $veza->prepare($query4);
                $iskaz4->bindParam(':ime', $narudzba->ime);
                $iskaz4->bindParam(':prezime', $narudzba->prezime);
                $iskaz4->bindParam(':telefon',$narudzba->telefon);
                $iskaz4->bindParam(':tipBroda',$narudzba->tipBroda);
                $iskaz4->bindParam(':korisnik',$idKorisnika);
                $iskaz4->execute();
                $iskaz4 = null;
            }
            $iskaz2 = null;
            $iskaz1 = null;
            $iskaz = null;
         }
         $komentari = simplexml_load_file('lib/xml/komentari.xml');
        foreach ($komentari->children() as $komentar)
        {
            $query = "SELECT COUNT(tekst) AS brojac FROM komentar WHERE tekst = :tekst";
            $iskaz = $veza->prepare($query);
            $iskaz->bindParam(':tekst', $komentar->tekst);
            $iskaz->execute();
            $row = $iskaz->fetch(PDO::FETCH_ASSOC);

            if($row['brojac'] == 0) 
            {
                $idKorisnika = 7; // Kako je admin log-ovan a ovo njegov primary key, neka novi unosi budu povezani sa adminom
                                 // jer u xml-u ne postoje podaci o korisniku za kojeg se vežu
                $query4 = "INSERT INTO komentar (tekst, korisnik) VALUES (:tekst, :korisnik)";
                $iskaz4 = $veza->prepare($query4);
                $iskaz4->bindParam(':tekst', $komentar->tekst);
                $iskaz4->bindParam(':korisnik',$idKorisnika);
                $iskaz4->execute();
                $iskaz4 = null;
            }
            $iskaz = null;
         }
         $veza = null;
         echo "<script type='text/javascript'>alert('Uspjesno ste importovali podatke iz xml-a u bazu');</script>";
         echo "<script type='text/javascript'>window.location.href='main.php'</script>";
         exit();

    }
}
