/*var script = document.createElement('script');
script.src = 'main.js';
script.onload = function() {};
document.head.appendChild(script);*/
function ucitajPodStranicu(url, broj) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200)
            document.getElementById("podstr").innerHTML = ajax.responseText;
        if (ajax.readyState == 4 && ajax.status == 404)
            document.getElementById("podstr").innerHTML = "Nije moguce otvoriti podstranicu";
    };

    ajax.open("GET", url, true);
    ajax.send();

    if(broj == 2)
    {
        document.getElementById("prvi").style.backgroundColor = "#33b5e5";
        document.getElementById("treci").style.backgroundColor = "#33b5e5";
        document.getElementById("cetvrti").style.backgroundColor = "#33b5e5";
        document.getElementById("drugi").style.backgroundColor = "#0099cc";
    }
    if(broj == 3)
    {
        document.getElementById("prvi").style.backgroundColor = "#33b5e5";
        document.getElementById("treci").style.backgroundColor = "#0099cc";
        document.getElementById("cetvrti").style.backgroundColor = "#33b5e5";
        document.getElementById("drugi").style.backgroundColor = "#33b5e5";

    }
    if(broj == 4)
    {
        document.getElementById("prvi").style.backgroundColor = "#33b5e5";
        document.getElementById("treci").style.backgroundColor = "#33b5e5";
        document.getElementById("cetvrti").style.backgroundColor = "#0099cc";
        document.getElementById("drugi").style.backgroundColor = "#33b5e5";

    }

}

function osvjeziStranicu() {
    document.location.href='main.html';
}

function validacijaEmail()
{
    var tekstPolje = document.getElementById("Email");
    var regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
    var tekstVrijednost = document.getElementById("Email").value;
    if(tekstVrijednost == "")
    {
        tekstPolje.setCustomValidity("E-mail polje ne smije biti prazno");
    }
    else if(regexEmail.test(tekstVrijednost) == false)
    {
        tekstPolje.setCustomValidity("Unijeli ste neispravan e-mail, pokušajte ponovo");
    }
    else // Ukoliko je uspjela validacija, skloni poruku
    {
        tekstPolje.setCustomValidity("");
    }       
    
}
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

function potvrdaPassword()
{
    var passwordVrijednost = document.getElementById("lname").value;
    var verifikujPasswordVrijednost = document.getElementById("pwrd").value;
    var verifikujPassword = document.getElementById("pwrd");
    if(verifikujPasswordVrijednost == "")
    {
        verifikujPassword.setCustomValidity("Polje za verifikaciju passworda ne smije biti prazno");
    }
    else if(passwordVrijednost != verifikujPasswordVrijednost)
    {
        verifikujPassword.setCustomValidity("Niste ispravno ponovili password. Pokušajte ponovo");
    }
    else // Ukoliko je uspjela validacija, skloni poruku
    {
        verifikujPassword.setCustomValidity("");
    }       

}