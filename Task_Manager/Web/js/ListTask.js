var tasks = document.getElementsByClassName('task_Resume');
var a;


for (var i = tasks.length - 1; i >= 0; i--) {
	tasks[i].addEventListener('click', function(e){
		var elem = e.target;
		while(elem.className != "task")
			elem = elem.parentElement;
		elem = elem.lastElementChild;
		var state = getComputedStyle(elem).display;
		if(state == "none")
			elem.style.display = "flex";
		else
			elem.style.display = "none";
	});	
}

function Click_Tack(e){
	alert(e.relatedTarget);
}

