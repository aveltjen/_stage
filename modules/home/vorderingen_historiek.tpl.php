<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisie V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/faviconSV.ico" type="image/x-icon" />

<link href="styles/styleContent.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">
// Centered Pop-Up Window (v1.0)
// (C) 2002 www.smileycat.com
// Free for all users, but leave in this header

var win = null;
function newWindow(mypage,myname,w,h,features) {
  var winl = (screen.width-w)/2;
  var wint = (screen.height-h)/2;
  if (winl < 0) winl = 0;
  if (wint < 0) wint = 0;
  var settings = 'height=' + h + ',';
  settings += 'width=' + w + ',';
  settings += 'top=' + wint + ',';
  settings += 'left=' + winl + ',';
  settings += features;
  win = window.open(mypage,myname,settings);
  win.window.focus();
}

</script>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body>
{titel}
<div id="frame">
<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    
    <td rowspan="3" valign="top" align="center" align="left">

    <table width="100%" class="tekstnormal">
    	<tr>
    		<td>{fout}</td>
    		<td align="right"> <a href="vorderingen_overschreiding.php?werf={WerfID}"><img src="images/back.gif" alt='Terug'></a></td>
    	</tr>
    	{fout_img}
    	<tr>
    		<td colspan="2">
    		

    				<!-- BEGIN posten -->
                            		<fieldset>
                            			<legend class="tekstlegend"><img src="images/book-open-bookmark.png"> {postlegend} {omschrijving}</legend>
                            			<table width="650" class="tekstnormal">
         
          
                           					<tr>
                           						<td>
                           						
                           						<img src="images/clock.png"> Historiek vorderingen:<br><br>
                           						<div id="historiek">
                           						<table class="tekstnormal">
                           							<tr bgcolor="#EFEFEF">
                           								
                           							<!-- BEGIN perioden -->
                           								<td width="80" align="center">
                           								<b>VS{vsnummer}:<br> {periode}</b> 
                           								</td>
                           							<!-- END perioden -->
                           							
                           							</tr>
                           							<tr class="drukrows">
                           								<!-- BEGIN hoeveelheden -->
                           								<td align="center">
                           								{uitgevoerd}
                           								</td>
                           								<!-- END hoeveelheden -->
                           							</tr>
                           						</table>
                           						</div>
                           						
                           						</td>
                           					</tr>
                           								  
                            			</table>
                            		</fieldset><br>
                   	<!-- END posten -->
                            		
                   	
</body>
</html>

