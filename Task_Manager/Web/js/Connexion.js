var f_validateForm = function(evt)
{
	var pass = document.getElementById('Password').value;
	pass = calcMD5(pass);
	document.getElementById('Password').value = pass;
}

var bt_Submit = document.getElementById('formConn');

bt_Submit.addEventListener('submit', f_validateForm);
