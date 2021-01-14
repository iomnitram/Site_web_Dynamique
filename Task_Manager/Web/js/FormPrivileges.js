var e = document.getElementById('priv_Admin')
if(e!=null)
	e.addEventListener('click', function(){
		document.getElementById('ChoicePriv').value = '1';
		document.getElementById('formPriv').submit();
	});

var e = document.getElementById('priv_Staff')
if(e!=null)
	e.addEventListener('click', function(){
		document.getElementById('ChoicePriv').value = '2';
		document.getElementById('formPriv').submit();
	});

var e = document.getElementById('priv_Trav')
if(e!=null)
	e.addEventListener('click', function(){
		document.getElementById('ChoicePriv').value = '3';
		document.getElementById('formPriv').submit();
	});

var e = document.getElementById('priv_Client')
if(e!=null)
	e.addEventListener('click', function(){
		document.getElementById('ChoicePriv').value = '4';
		document.getElementById('formPriv').submit();
	});

var priv = document.getElementById('ChoicePriv').value;
if(priv == '1')
	document.getElementById('priv_Admin').style.backgroundColor = 'rgba(150,150,150,0.5)';
if(priv == '2')
	document.getElementById('priv_Staff').style.backgroundColor = 'rgba(150,150,150,0.5)';
if(priv == '3')
	document.getElementById('priv_Trav').style.backgroundColor = 'rgba(150,150,150,0.5)';
if(priv == '4')
	document.getElementById('priv_Client').style.backgroundColor = 'rgba(150,150,150,0.5)';
