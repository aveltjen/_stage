var tmr;
var t;
var obj;

function sFa(id) {
	obj = gObj();
	sLft();
	shw(true);
	t = 0;
	sTmr();
	document.getElementById('postID').innerHTML = id;
}

function hFa() {
	t = -100;
	sTmr();
	return false;
}

function sTmr() {
	tmr = setInterval("fd()",20);
}

function fd() {
	var amt = Math.abs(t+=10);
	if(amt == 0 || amt == 100) clearInterval(tmr);
	amt = (amt == 100)?99.999:amt;
  	
	obj.style.filter = "alpha(opacity:"+amt+")";
	obj.style.KHTMLOpacity = amt/100;
	obj.style.MozOpacity = amt/100;
	obj.style.opacity = amt/100;
	
	if(amt == 0) shw(false);
}

function sLft() {
	var w = 170;	// set this to 1/2 the width of the faw div defined in the style sheet 
			// there's not a reliable way to retrieve an element's width via javascript!!
					
	var l = (document.body.innerWidth)? document.body.innerWidth / 2:document.body.offsetWidth / 2;

	obj.style.left = (l - w)+"px";
}

function gObj() {
	return document.getElementById("faw");	
}

function shw(b) {
	(b)? obj.className = 'show':obj.className = '';	
}