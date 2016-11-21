function validacijaPolja()
{
	var tekstPolje = document.getElementById("fname");
	var regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
	var regexTelefon = /^\d{3}[ ,\-,/]\d{3}[ ,\-,/]\d{3}$/i;
	var tekstVrijednost = document.getElementById("fname").value;

	var selekt = document.getElementById("kontaktOpcije");
	var selektVrijednost =  selekt.options[selekt.selectedIndex].value;
	if(selektVrijednost == "Email")
	{
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
	else if(selektVrijednost == "Telefon")
	{
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

}