function ucitajTekst(broj)
{
	if(broj == 1)
	{
		document.getElementById('modelBroda').innerHTML = "L-50";
		document.getElementById('cijenaBroda').innerHTML = "25.000 KM";
	}
	else if(broj == 2)
	{
		document.getElementById('modelBroda').innerHTML = "Lagoon 440";
		document.getElementById('cijenaBroda').innerHTML = "100.000 KM";
	}
	else
	{
		document.getElementById('modelBroda').innerHTML = "RC Ferry";
		document.getElementById('cijenaBroda').innerHTML = "1.300.000 KM";

	}


}

function otvoriModal()
{

var modal = document.getElementById('myModal');
var span = document.getElementsByClassName("close")[0];
modal.style.display = "block";
document.getElementById("prosirenaSlikaID").src = document.getElementById("uvecanaSlikaID").src;
    document.onkeydown = function(evt){
        evt = evt || window.event;
        var pritisnutESC = false;
        if ("key" in evt)
        {
            pritisnutESC = (evt.key == "Escape" || evt.key == "Esc");
        }
        else
        {
            pritisnutESC = (evt.keyCode == 27); // KeyCode za ESC tipku
        }
        if (pritisnutESC) {
            zatvoriModal();
        }

};
}

function zatvoriModal() {

	var modal = document.getElementById('myModal');
	modal.style.display = "none";
	window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
   }
	};
}