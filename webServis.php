<?php
    function zag() {
        header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
        header('Content-Type: text/html');
        header('Access-Control-Allow-Origin: *');
    }
    function rest_get($request, $data) {
        
        $idKomentar;
        if(!isset($_GET['korisnikId']))
        {
            $idKomentar = "";
        }
        else
            $idKomentar = $_GET['korisnikId'];
        
        $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
        $veza->exec("set names utf8");
        if($idKomentar == "")
        {
            $iskaz = $veza->prepare("SELECT * FROM komentar");
            $iskaz->execute();
            
            $rezultat = array();
            while($row = $iskaz->fetch(PDO::FETCH_ASSOC)){
                $rezultat[] = $row;
            }
            print json_encode($rezultat);

        }
        else
        {
            $iskaz = $veza->prepare("SELECT * FROM komentar WHERE korisnik=?");
            $iskaz->bindValue(1, $idKomentar, PDO::PARAM_INT);
            $iskaz->execute();
            $rezultat = array();
            while($row = $iskaz->fetch(PDO::FETCH_ASSOC)){
                $rezultat[] = $row;
            }
            print json_encode($rezultat);

        }
     }
    function rest_post($request, $data) { }
    function rest_delete($request) { }
    function rest_put($request, $data) { }
    function rest_error($request) { }

    $method  = $_SERVER['REQUEST_METHOD'];
    $request = $_SERVER['REQUEST_URI'];
    switch($method) {
        case 'PUT':
            parse_str(file_get_contents('php://input'), $put_vars);
            zag(); $data = $put_vars; rest_put($request, $data); break;
        case 'POST':
            zag(); $data = $_POST; rest_post($request, $data); break;
        case 'GET':

              zag(); $data = $_GET; rest_get($request, $data); break;

            case 'DELETE':
                zag(); rest_delete($request); break;
            default:
                header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
                rest_error($request); break;
        }