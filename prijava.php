<?php

    $_REQUEST = array(); //workaround for broken PHPstorm
    parse_str(file_get_contents('php://input'), $_REQUEST);
    require 'validacija.php';

// Da li je zaista poslan request?
    if(!isset($_REQUEST['username']) || !isset($_REQUEST['password']))
    {
        header("Location: main.php");
        exit();
    }
// Provjera da li su submit-ani podaci prazni
    if(praznoPolje($_REQUEST['username']) || praznoPolje($_REQUEST['password']))
    {
        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
// Potrebno je obezbijediti zastitu od XSS-a
    $usernameIzForme = xssPrevencija($_REQUEST['username']);
    $passwordIzForme = xssPrevencija($_REQUEST['password']);
// Validacija podataka
    if(!validacijaUsername($usernameIzForme))
    {
        echo "<script type='text/javascript'>alert('Username se moze sastojati samo od alfanumerickih znakova duzine od 2 do 18 karaktera');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
    if(!validacijaPassword($passwordIzForme))
    {
        echo "<script type='text/javascript'>alert('Minimalna duzina passworda je 6 znakova');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }

    $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
    $veza->exec("set names utf8"); 
    $query = "SELECT COUNT(username) AS brojac FROM korisnik WHERE username = :username AND password = :password";
   
    $iskaz = $veza->prepare($query);
    $iskaz->bindValue(':username', $usernameIzForme);
    $iskaz->bindValue(':password', $passwordIzForme);
    $iskaz->execute();
    $row = $iskaz->fetch(PDO::FETCH_ASSOC);
     if($row['brojac'] == 0){
        die('Neuspjesna prijava!');
     }
     else if($row['brojac'] == 1)
     {
                session_start();
                $_SESSION['username'] = $usernameIzForme;
                echo "<script type='text/javascript'>alert('Uspjesno ste se prijavili.');</script>";
                echo "<script type='text/javascript'>window.location.href='main.php'</script>";
                exit();
     }
     else
     {
         die('Greska pri unosu u bazu. Više korisnika s istim username-om');
     }            

