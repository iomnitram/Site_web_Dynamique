var zone = document.getElementById('blocEdit');
var a;
zone.addEventListener('dragover', function(e) {
    e.preventDefault();
});

zone.addEventListener('drop', function(e) {
    e.preventDefault();

    var text = e.dataTransfer.getData('text/plain');
    parser = new DOMParser();
	xmlDoc = parser.parseFromString(text,"text/xml");

	var id = xmlDoc.children[0].children[0];
	a = id;

	document.getElementById('Name').value = id.children[0].childNodes[0].data;
	document.getElementById('FirstName').value = id.children[1].childNodes[0].data;
});