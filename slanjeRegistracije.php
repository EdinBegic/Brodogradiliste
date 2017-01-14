<?php
    $_REQUEST = array(); //workaround for broken PHPstorm
    parse_str(file_get_contents('php://input'), $_REQUEST);

    require 'validacija.php';

// Da li je zaista poslan request?
    if (!isset($_REQUEST['username']) || !isset($_REQUEST['password']) || !isset($_REQUEST['email']) || !isset($_REQUEST['potvrda'])) {
        header("Location: main.php");
        exit();
    }
// Provjera da li su submit-ani podaci prazni
    if (praznoPolje($_REQUEST['username']) || praznoPolje($_REQUEST['password']) || praznoPolje($_REQUEST['email']) || praznoPolje($_REQUEST['potvrda'])) {
        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();

    }
//Potrebno je obezbijediti zastitu od XSS-a
    $username = xssPrevencija($_REQUEST['username']);
    $password = xssPrevencija($_REQUEST['password']);
    $potvrdaPassword = xssPrevencija($_REQUEST['potvrda']);
    $email = xssPrevencija($_REQUEST['email']);
//Validacija podataka
    if (!validacijaUsername($username)) {
        echo "<script type='text/javascript'>alert('Username se moze sastojati samo od alfanumerickih znakova duzine od 2 do 18 karaktera');</script>";
        echo "<script type='text/javascript'>window.location.href='registracija.php'</script>";
        exit();
    }
    if (!validacijaPassword($password)) {
        echo "<script type='text/javascript'>alert('Minimalna duzina passworda je 6 znakova');</script>";
        echo "<script type='text/javascript'>window.location.href='registracija.php'</script>";
        exit();
    }
    if (!validacijaEmail($email)) {
        echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
        echo "<script type='text/javascript'>window.location.href='registracija.php'</script>";
        exit();
    }
// Da li postoji vec korisnik s takvim imenom
    if (!jedinstvenostUsername($username)) {
        echo "<script type='text/javascript'>alert('Postoji korisnik s takvim username-om');</script>";
        echo "<script type='text/javascript'>window.location.href='registracija.php'</script>";
        exit();

    }
    if (!potvrdaPassworda($password, $potvrdaPassword)) {
        echo "<script type='text/javascript'>alert('Password se ne podudara s ponovljenim unosom');</script>";
        echo "<script type='text/javascript'>window.location.href='registracija.php'</script>";
        exit();
    }
 //   $korisnici = simplexml_load_file("lib/xml/korisnici.xml");
/*
    $vel = $korisnici->count();
    if($vel == 0)
        $id = 1;
    else
    {
        $cvor = $korisnici->korisnik[$vel - 1];
        $id = $cvor->id + 1;
    }
    $korisnik = $korisnici->addChild('korisnik');
    $korisnik->addChild('id', $id);
    $korisnik->addChild('username', $username);
    $korisnik->addChild('password', $password);
    $korisnik->addChild('email', $email);
    $korisnik->addChild('priv', 0); // svaki novi registrovani clan nema privilegije admina
    $korisnici->asXML("lib/xml/korisnici.xml");
*/
    $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
    $veza->exec("set names utf8");
   
        
    $query = "SELECT COUNT(username) AS brojac FROM korisnik WHERE username = :username";
   
    $iskaz = $veza->prepare($query);
    $iskaz->bindValue(':username', $username);
    $iskaz->execute();
    $row = $iskaz->fetch(PDO::FETCH_ASSOC);
     if($row['brojac'] > 0){
        die('Postoji korisnik sa takvim username-om u bazi');
     }

    $insert = "INSERT INTO korisnik (username, password, email) " ."VALUES (?, ?, ?)";

    $iskaz = $veza->prepare($insert);
    $iskaz->bindValue(1, $username, PDO::PARAM_STR);
    $iskaz->bindValue(2, $password, PDO::PARAM_STR);
    $iskaz->bindValue(3, $email, PDO::PARAM_STR);
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
    echo "<script type='text/javascript'>alert('Uspjesno ste se registrovali na site');</script>";
    echo "<script type='text/javascript'>window.location.href='main.php'</script>";
    exit();
