<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head profile="http://www.w3.org/2005/10/profile">
<head>
<title>Supervisor V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styleSViframe.css" rel="stylesheet" type="text/css">

  <script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
    var GB_ROOT_DIR = "./greybox/";
</script>
<script type="text/javascript" src="greybox/AJS.js"></script>
<script type="text/javascript" src="greybox/AJS_fx.js"></script>
<script type="text/javascript" src="greybox/gb_scripts.js"></script>

<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />
</script>



</head>
<body>
<form action="historiek?werf={id}&historiek=show" target="_blank" method="POST">
<table class="tekstnormal" width="840">
<tr>
<td>
	
</td>
<td align="right" height="30">
<input type="submit" value="historiek opvragen"/>
</td>
</tr>
</table>
							<div id="vstitels">
							<table width="829" cellpadding="2" border="0" cellspacing="1">
									<tr class="tekstnormal" bgcolor="#EFEFEF">
										<td width="79"><b>Nr.</b></td>
										<td width="208"><b>Omschrijving</b></td>
										<td width="46"><b>VH/TP</b></td>
										<td width="57" ><b>Eenheid</b></td>
										<td width="65"><b>Eenheids prijs</b></td>
										<td width="70"><b>Voorziene hv.</b></td>
										<td width="84"><b>Gevorderde hv.</b></td>
										<td width="81"><b>Opgemeten hv.</b></td>
										<td width="24">&nbsp;</td>
										<td width="24"><b>&nbsp;</b></td>
										<td width="35" align="center"><img src="images/clock--arrow.png"></td>
									</tr>
							</table>
							</div>
							<div id="vslist">
							<table width="829" cellpadding="2" border="0" cellspacing="1">
								
								<!-- BEGIN vslist -->
									<tr class="{class}">
										<td width="79">{nummer}</td>
										<td width="208">{omschrijving}</td>
										<td width="46">{VHTP}</td>
										<td width="57">{eenheden}</td>
										<td width="65">{eenheidsprijs}</td>
										<td width="70">{voorzien}</td>
										<td width="84">{gevorderd}</td>
										<td width="81">{opgemeten}</td>
										<td width="24">{vorderen}</td>
										<td width="24">{opmeten}</td>
										<td width="35" align="center">{historiek}</td>
										
									</tr>
								<!-- END vslist -->
							</table>
							</div>	
</form>		 
</body>
</html>

