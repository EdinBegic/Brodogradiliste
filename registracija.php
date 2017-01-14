<!DOCTYPE html>
<html lang="en">
<head>
        <META http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="lib/css/header.css">
        <link rel="stylesheet" type="text/css" href="lib/css/registracija.css">
        <script type="text/javascript" src="lib/javascript/registracija.js"></script>
        <title>Registracija</title>
</head>
<body>
<?php
session_start();
if(isset($_SESSION['username']))
{   
    echo "<script type='text/javascript'>alert('Vec ste prijavljeni!');</script>";
    echo "<script type='text/javascript'>window.location.href='main.php'</script>";
}
?>
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
    <div class="kolona-2 meni_aktivan" id="petiButton">
        <ul>
            <li id="peti">
                <a href="#" class="meni_link" ><b>Registracija</b></a>
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

<div class = "row" id="ispod_headera">
    <div class="kolona-12" id="prijava">
        <h1 id="pri">Registracija</h1>
    </div>
</div>
<form action="slanjeRegistracije.php" method="post">

    <div class="row" id="username_red">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="username_kolona1">
            <label for="fname">Username:</label>
        </div>
        <div class="kolona-3" id="username_kolona2">
            <input type="text" id="fname" name="username" required autofocus oninput="validacijaUser()" oninvalid="validacijaUser()">
        </div>
    </div>
    <div class="row" id="password_red">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="password_kolona1">
            <label for="lname">Password:</label>
        </div>
        <div class="kolona-3" id="password_kolona2">
            <input type="password" id="lname" name="password" required oninput="validacijaPassword()" oninvalid="validacijaPassword()">
        </div>
    </div>
    <div class="row" id="password_potvrdi_red">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="password_potvrdi_kolona1">
            <label for="pwrd">Potvrdite Password:</label>
        </div>
        <div class="kolona-3" id="password_potvrdi_kolona2">
            <input type="password" id="pwrd" name="potvrda" required oninvalid="potvrdaPassword()" oninput="potvrdaPassword()">
        </div>
    </div>
    <div class="row" id="email_red">
        <div class="kolona-3">&nbsp;</div>
        <div class="kolona-3" id="email_kolona1">
            <label for="Email">Email:</label>
        </div>
        <div class="kolona-3" id="email_kolona2">
            <input type="text" id="Email" name ="email" required oninvalid="validacijaEmail()" oninput="validacijaEmail()">
        </div>
    </div>
    <div class="row" id="posalji_red">
        <div class="kolona-12" id="posalji_kolona1">
            <input type="submit" value="Registruj se" id="dugmeZaSlanje">
        </div>
    </div>

</form>
</body>
</html>