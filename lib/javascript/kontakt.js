function validacijaEmail()
{
	var tekstPolje = document.getElementById("fname");
	var regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
	var tekstVrijednost = document.getElementById("fname").value;
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
function  validacijaKomentar() {
	var tekstPolje = document.getElementById("komentar");
	var tekstVrijednost = document.getElementById("komentar").value;
    if(tekstVrijednost == "")
    {
        tekstPolje.setCustomValidity("Ne mozete poslati prazan komentar");
    }
    else if(tekstVrijednost.length > 100)
	{
		tekstPolje.setCustomValidity("Komentar ne smije bit duzi od 100 karaktera");
	}
    else // Ukoliko je uspjela validacija, skloni poruku
    {
        tekstPolje.setCustomValidity("");
    }
}