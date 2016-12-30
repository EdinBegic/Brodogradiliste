/*var script = document.createElement('script');
script.src = 'main.js';
script.onload = function() {};
document.head.appendChild(script);
function ucitajPodStranicu(url, broj) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200)
            document.getElementById("podstr").innerHTML = ajax.responseText;
        if (ajax.readyState == 4 && ajax.status == 404)
            document.getElementById("podstr").innerHTML = "Nije moguce otvoriti podstranicu";
    };

    ajax.open("GET", url, true);
    ajax.send();

    document.getElementById("sesti").style.backgroundColor = "#33b5e5";
    if (broj == 2) {
        document.getElementById("peti").style.backgroundColor = "#33b5e5";
        document.getElementById("prvi").style.backgroundColor = "#33b5e5";
        document.getElementById("treci").style.backgroundColor = "#33b5e5";
        document.getElementById("cetvrti").style.backgroundColor = "#33b5e5";
        document.getElementById("drugi").style.backgroundColor = "#0099cc";
    }
    if (broj == 3)
    {
        document.getElementById("peti").style.backgroundColor = "#33b5e5";
        document.getElementById("prvi").style.backgroundColor = "#33b5e5";
        document.getElementById("treci").style.backgroundColor = "#0099cc";
        document.getElementById("cetvrti").style.backgroundColor = "#33b5e5";
        document.getElementById("drugi").style.backgroundColor = "#33b5e5";

    }
    if(broj == 4)
    {
        document.getElementById("peti").style.backgroundColor = "#33b5e5";
        document.getElementById("prvi").style.backgroundColor = "#33b5e5";
        document.getElementById("treci").style.backgroundColor = "#33b5e5";
        document.getElementById("cetvrti").style.backgroundColor = "#0099cc";
        document.getElementById("drugi").style.backgroundColor = "#33b5e5";

    }
    if(broj == 5)
    {
        document.getElementById("peti").style.backgroundColor = "#0099cc";
        document.getElementById("prvi").style.backgroundColor = "#33b5e5";
        document.getElementById("drugi").style.backgroundColor = "#33b5e5";
        document.getElementById("treci").style.backgroundColor = "#33b5e5";
        document.getElementById("cetvrti").style.backgroundColor = "#33b5e5";
    }

}

function osvjeziStranicu() {
    document.location.href='main.php';
}
*/
document.forms["f1"]["pretraga"].addEventListener("input", function() {

    $str = this.value;
    document.getElementById('uzivoPretraga').innerHTML='';
    document.getElementById('uzivoPretraga').style.border='0px';

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {

            document.getElementById("uzivoPretraga").innerHTML=this.responseText;
            document.getElementById("uzivoPretraga").style.border="1px solid #A5ACB2";
            document.getElementById("uzivoPretraga").style.borderRadius = "10px";
            document.getElementById("uzivoPretraga").style.width="100%";
            document.getElementById("uzivoPretraga").style.backgroundColor="#21D5D5";
            document.getElementById("uzivoPretraga").style.color="whitesmoke";

        }
    }
    xmlhttp.open("GET","pretraga.php?q="+$str,true);
    xmlhttp.send();

});
function validacijaUser()
{
    var tekstPolje = document.getElementById("fname");
    var regexUser = /^\w{2,18}$/;
    var tekstVrijednost = document.getElementById("fname").value;
    if(tekstVrijednost == "")
    {
        tekstPolje.setCustomValidity("Polje za username ne smije biti prazno");
    }
    else if(regexUser.test(tekstVrijednost) == false)
    {
        tekstPolje.setCustomValidity("Username se smije sastojati samo od alfanumerickih znakova.");
    }
    else // Ukoliko je uspjela validacija, skloni poruku
    {
        tekstPolje.setCustomValidity("");
    }       
    
}
function validacijaPassword()
{
    var tekstPolje = document.getElementById("lname");
    var regexPassword = /^.{6,}$/;
    var tekstVrijednost = document.getElementById("lname").value;
    if(tekstVrijednost == "")
    {
        tekstPolje.setCustomValidity("Polje za password ne smije biti prazno");
    }
    else if(regexPassword.test(tekstVrijednost) == false)
    {
        tekstPolje.setCustomValidity("Minimalna duzina passworda je 6 znakova. Pokusajte ponovo");
    }
    else // Ukoliko je uspjela validacija, skloni poruku
    {
        tekstPolje.setCustomValidity("");
    }
}




