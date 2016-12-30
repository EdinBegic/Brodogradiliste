<?php
$_REQUEST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_REQUEST);
session_start();
if(isset($_SESSION['username']))
{
    if(isset($_REQUEST['odjava'])) // Odjaviti se moze samo kroz klik na dugme, a ne direktnim unosom url-a
    {
        session_destroy();
        echo "<script type='text/javascript'>alert('Uspjesno ste se odjavili.');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
    else
    {
        header("Location: main.php");
        exit();
    }

}
else
{
    header("Location: main.php");
    exit();

}
