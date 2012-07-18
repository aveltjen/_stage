Follow these instructions...

STEP 1.  Edit fadw.js and set the variable on line 37 according to the instructions in the commented code. There is not a reliable cross-browser way to retrieve an element's width with javascript, so you have to define it manually.

STEP 2.  Make sure to link the files properly in the <head> section of your XHTML file.

	<script type="text/javascript" src="fadw.js"></script>
	<link rel="stylesheet" type="text/css" href="fadw.css" />

STEP 3.  Inset this div right after the <body> tag. You can put whatever you want to be included in the popup in the faw div.

	<div id="faw">
		<div class="bar"><a href="#">Make money being a geek!</a><a href="#" onClick="hFa()" class="close">&nbsp;</a></div>
		<div class="ad"><a href="#"><img src="rich_geek.gif" alt="Advertisement" /></a></div>
	</div>
	
STEP 4.  Put this script right above the closing </body> tag at the end of your XHTML file.

	<script type="text/javascript">sFa();</script>

STEP 5.  Upload fadw.js, fadw.css, the image files (if you're going to use them), and the XHTML file to your server and test it out, it should work fine! The stylesheet was written to work with this doctype...

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

	it may work with others though...

Thanks for downloading!! www.bmgadg.com