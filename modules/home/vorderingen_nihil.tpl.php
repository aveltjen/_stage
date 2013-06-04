<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisor V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styleSViframe.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript">

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
</head>
<body>
<br>
<table align="center">
<tr>
	<td>
		<table class="tekstnormal" width="730">
		<tr>
		<td align="right">
		<img src='images/document-pdf.png'>  <a href='vorderingen_nihil_pdf.php?werf={id}' target='_blank'>download PDF</a>	
		</td>
		</tr>
		</table>
		<fieldset>
		<legend class="tekstlegend">Overzicht posten nihil</legend>
		<table width="670" cellpadding="2" border="0" cellspacing="1">
									<tr class="tekstnormal" bgcolor="#EFEFEF">
										<td width="41"><b>Nr.</b></td>
										<td width="286"><b>Omschrijving</b></td>
										<td width="38"><b>VH/TP</b></td>
										<td width="45" ><b>Eenheid</b></td>
										<td width="55"><b>Eenheids prijs</b></td>
										<td width="67"><b>Voorziene hv.</b></td>
										<td width="67"><b>Gevorderde hv.</b></td>
										
									
									</tr>
							</table>
							
							<div style="position:relative;
	margin-left:0px;
	overflow-x:hidden;
	overflow-y: auto;
	height:300px;
	width:690px;
	z-index:1;">
							<table width="670" cellpadding="2" border="0" cellspacing="1">
								
								<!-- BEGIN vslist -->
									<tr class="drukrows">
										<td width="41">{nummer}</td>
										<td width="286">{omschrijving}</td>
										<td width="38">{VHTP}</td>
										<td width="45">{eenheden}</td>
										<td width="55">{eenheidsprijs}</td>
										<td width="67">{voorzien}</td>
										<td width="67">{gevorderd}</td>
										
									</tr>
								<!-- END vslist -->
							</table>
							</div>	
						</fieldset>	
	</td>
</tr>
</table>
			
							
							
		 
</body>
</html>

