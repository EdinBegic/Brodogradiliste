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
function validacijaTelefon()
{
	var tekstPolje = document.getElementById("broj");
	var regexTelefon = /^\d{3}[ ,\-,/]\d{3}[ ,\-,/]\d{3}$/i;
	var tekstVrijednost = document.getElementById("broj").value;

	if(tekstVrijednost == "")
	{
		tekstPolje.setCustomValidity("Polje za unos telefona ne moze biti prazno");
	}
	else if(regexTelefon.test(tekstVrijednost) == false)
	{
		tekstPolje.setCustomValidity("Validan oblik broja telefona: [111-111-111] ili [111 111 111] ili [111/111/111]");
	}
	else // Ukoliko je uspjela validacija, skloni poruku
	{
		tekstPolje.setCustomValidity("");
	}		
}
function validacijaIme()
{
	var tekstPolje = document.getElementById("fname");
	var regexIme = /^[a-zA-Z ]{2,18}$/;
	var tekstVrijednost = document.getElementById("fname").value;
	if(tekstVrijednost == "")
	{
		tekstPolje.setCustomValidity("Polje za ime ne smije biti prazno");
	}
	else if(regexIme.test(tekstVrijednost) == false)
	{
		tekstPolje.setCustomValidity("Unijeli ste sintaksno neispravno ime. Pokusajte ponovo");
	}
	else // Ukoliko je uspjela validacija, skloni poruku
	{
		tekstPolje.setCustomValidity("");
	}		
	
}
function validacijaPrezime()
{
	var tekstPolje = document.getElementById("lname");
	var regexPrezime = /^[a-zA-Z ]{2,18}$/;
	var tekstVrijednost = document.getElementById("lname").value;
	if(tekstVrijednost == "")
	{
		tekstPolje.setCustomValidity("Polje za prezime ne smije biti prazno");
	}
	else if(regexPrezime.test(tekstVrijednost) == false)
	{
		tekstPolje.setCustomValidity("Unijeli ste sintaksno neispravno prezime. Pokusajte ponovo");
	}
	else // Ukoliko je uspjela validacija, skloni poruku
	{
		tekstPolje.setCustomValidity("");
	}		
	
}

