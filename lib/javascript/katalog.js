function otvoriModal(id)
{

var modal = document.getElementById('myModal');
var span = document.getElementsByClassName("close")[0];
modal.style.display = "block";
document.getElementById("prosirenaSlikaID").src = document.getElementById(id).src;
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