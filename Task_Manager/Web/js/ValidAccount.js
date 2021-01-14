var f_validateForm = function(evt)
{
	var pseudo = document.getElementById('pseudo').value;
	var newPass = document.getElementById('NewPass').value;
	var repPass = document.getElementById('RepPass').value;
	var oldPass = document.getElementById('OldPass');
	if(oldPass != null)
		oldPass = oldPass;

	if(pseudo == "")
	{
		alert("Le pseudo ne peut pas être vide");
		evt.preventDefault();
		return false;
	}

	if (newPass != "" || repPass != "")
	{
		if(newPass != repPass)
		{
			alert("Les deux mots de passe sont différents");
			evt.preventDefault();
			return false;
		}
		if(newPass == "")
		{
			alert("Le nouveau mot de passe ne peut être vide");
			evt.preventDefault();
			return false;
		}
		newPass = calcMD5(newPass);

		document.getElementById('NewPass').value = newPass;
		document.getElementById('RepPass').value = newPass;

		if(oldPass != null)
		{
			oldPass = calcMD5(oldPass);
			document.getElementById('OldPass').value = oldPass;
		}
	}
}

var formu = document.getElementById('form_param');

formu.addEventListener('submit', f_validateForm);
