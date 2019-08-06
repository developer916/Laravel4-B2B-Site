/* LOAD HEADER, FOOTER, RESPONSE FILES HERE.. */

//check page name
var path = window.location.pathname;
var page = path.split("/").pop();

// Returns height of browser viewport
var window_height = $(window).height();

var window_width = $(window).width();

// Returns height of HTML document
var body_height = $('body').height();

$(function() {
	$("#header").load("views/header.html");
	$("#categories").load("views/categories.html");
	$("#searchbar").load("views/searchbar.html");
	$("#productBody").load("views/productbody.html");
	$("#suppliers").load("views/suppliers.html");
	$("#footer").load("views/footer.html");
});

/* LOADS ALL CSS JS FILES HERE.. */

function loadjscssfile(filename, filetype) {
	var fileref;
	if (filetype == "js") {
		fileref = document.createElement('script');
		fileref.setAttribute("type", "text/javascript");
		fileref.setAttribute("src", filename);
	} else if (filetype == "css") {
		fileref = document.createElement("link");
		fileref.setAttribute("rel", "stylesheet");
		fileref.setAttribute("type", "text/css");
		fileref.setAttribute("href", filename);
	} else if (filetype == "less") {
		fileref = document.createElement("link");
		fileref.setAttribute("rel", "stylesheet/less");
		fileref.setAttribute("type", "text/css");
		fileref.setAttribute("href", filename);
	}
	if ( typeof fileref != "undefined") {
		document.getElementsByTagName("head")[0].appendChild(fileref);
	}
}

loadjscssfile("assets/css/bootstrap.css", "css");
loadjscssfile("assets/css/styles.less", "less");
loadjscssfile("assets/js/less.js", "js");

loadjscssfile("assets/css/helper.css", "css");
/* loadjscssfile("assets/js/bootstrap.js", "js"); */ 
loadjscssfile("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js", "js");
loadjscssfile("assets/js/script.js", "js");


/* http://stackoverflow.com/questions/33827503/jquery-code-not-working-on-microsoft-edge-browser */