<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head profile="http://www.w3.org/2005/10/profile">

<title>Supervisie V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/faviconSV.ico" type="image/x-icon" />

<link href="styles/styleSV.css" rel="stylesheet" type="text/css">
<link href="styles/styleSViframe.css" rel="stylesheet" type="text/css">

<script>

// -->

<!-- Original:  Gilbert Davis -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function loadImages() {
if (document.getElementById) {  // DOM3 = IE5, NS6
document.getElementById('hidepage').style.visibility = 'hidden';
}
else {
if (document.layers) {  // Netscape 4
document.hidepage.visibility = 'hidden';
}
else {  // IE 4
document.all.hidepage.style.visibility = 'hidden';
      }
   }
}
//  End -->
  </script>
  <script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
    var GB_ROOT_DIR = "./greybox/";
</script>
<script type="text/javascript" src="greybox/AJS.js"></script>
<script type="text/javascript" src="greybox/AJS_fx.js"></script>
<script type="text/javascript" src="greybox/gb_scripts.js"></script>

<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />
</script>

<style type="text/css" media="all">
@import "jquery/jquery-tooltip/css/global.css";
</style>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
			<link rel="stylesheet" href="jquery/css/ui-lightness/jquery-ui-1.8.18.custom.css" type="text/css" media="all" />
			<link rel="stylesheet" href="jquery/development-bundle/themes/ui-lightness/jquery.ui.tooltip.css" type="text/css" media="all" />
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
			<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
			<script src="jquery/jquery-tooltip/js/jtip.js" type="text/javascript"></script>

</head>
<body onload="loadImages()">
{titel}

<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="250"><img src="images/logo.png"></td>
		<td align="right"><img src="images/header.jpg"></td>
	</tr>
	<tr>
		<td colspan="2" height="18" background="images/menubar.png">
			<table cellpadding="0" cellspacing="0" class="hoofdmenu" width="950" border="0">
				<td width="20">&nbsp;</td>
				<td width="600"><img src="images/figure_ver1.gif"> {Name} :: {description} <i>{Toezichter}</i></td>
				<td align="right" width="1%"><a href="handleiding_supervisie.pdf" target="_blank" >Handleiding</a></td>
				<td align="right" width="1%"><a href="index.php">Start</a></td>
				<td align="right" width="1%"><a href="?action=logout">Uitloggen</a></td>
			</table>
		</td>
	</tr>
</table>
				<div id="hidepage"> 
					<table class="tekstnormal" width=100%><tr><td align="left"><img src="images/ajax-loader.gif"> meetstaat wordt geladen...</td></tr></table>
				</div>
	
    	<table width="960" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
				<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
				  <tr>
				   <td height="29" background="images/index_r1_c1.gif"></td>
				   <td width="380" background="images/index_r1_c2.gif"></td>
				   <td width="6" background="images/index_r1_c3.png"></td>
				   <td width="108" background="images/index_r1_c4.png" align="center" valign="middle"><b>Meetstaat</b></td>
				   <td width="7" background="images/index_r1_c5.png"></td>
				   <td width="385" background="images/index_r1_c6.gif">&nbsp;</td>
				   <td background="images/index_r1_c7.gif"></td>
		
				  </tr>
				  <tr>
				   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
				   <td colspan="5" bgcolor="White" valign="top">
						
				 		  <table width="100%" height="200" border="0" align="left">
		
				 		  		<tr>
									<td valign="top">
										
													<fieldset>
													<legend class="tekstlegend">Meetstaat: opmeten en vorderen</legend>
													<form action="historiek.php?werf={id}&historiek=show" target="_blank" method="POST">
													<table class="tekstnormal" width="840">
													<tr>
													<td align="left">
													<a href="startwerf_pdf.php?werf={id}"><img src='images/document-pdf.png'> meetstaat downloaden</a>
													</td>
													<td>
													</td>

													<td align="right" height="30">
													<input type="submit" value="historiek opvragen"/>
													</td>
													</tr>
													</table>
													<div id="vstitels">
													<table width="859" cellpadding="2" border="0" cellspacing="1">
															<tr class="tekstnormal" bgcolor="#EFEFEF">
																<td width="30" class="tip"><b>{tooltip}</b></td>
																<td width="49"><b>Nr.</b></td>
																<td width="240"><b>Omschrijving</b></td>
																<td width="46"><b>VH/TP</b></td>
																<td width="57" ><b>Eenheid</b></td>
																<td width="65"><b>Eenheids prijs</b></td>
																<td width="70"><b>Voorziene hv.</b></td>
																<td width="84"><b>Gevorderde hv.</b></td>
																<td width="81"><b>Opgemeten hv.</b></td>
																<td width="24">&nbsp;</td>
																<td width="24">&nbsp;</td>
																<td width="33" align="center"><img src="images/clock--arrow.png"></td>
															</tr>
													</table>
													</div>
													<div id="vslist">
													<table width="859" cellpadding="2" border="0" cellspacing="1">
														<!-- BEGIN vslist -->
															<tr class="{class}">
																<td width="30">{linken}</td>
																<td width="49">{nummer}</td>
																<td width="240">{omschrijving}</td>
																<td width="46">{VHTP}</td>
																<td width="57">{eenheden}</td>
																<td width="65">{eenheidsprijs}</td>
																<td width="70">{voorzien}</td>
																<td width="84">{gevorderd}</td>
																<td width="81">{opgemeten}</td>
																<td width="24">{vorderen}</td>
																<td width="24">{opmeten}</td>
																<td width="33" align="center">{historiek}</td>
															</tr>
														<!-- END vslist -->
													</table>
													</div>	
													</form>							
													</fieldset>

									</td>
								</tr>
							</table>
				
	
				
				    </td>
				   <td background="images/index_r2_c7.gif">
				   </td>
				   
				  </tr>
				  <tr>
				   <td width="10" background="images/index_r3_c1.gif">&nbsp;</td>
				   <td colspan="5" background="images/index_r3_c2.gif"><img src="images/spacer.gif" height="15" alt="" width="3"></td>
				   <td width="10" background="images/index_r3_c7.gif">&nbsp;</td>
				   
				  </tr>
				</table>




										<div id="bottom">

									   	<table width="100%" border="0">
									   		<tr>
									   			<td>
									   				<img src="images/magnifier.png">
									   			</td>
									   			<td align="left">
									   					
														<script type="text/javascript" language="JavaScript" src="js/find_custom2.js"></script>
														
									   			</td>
									   			<td>
									   		
									   				<table width="100%" border="0" class="tekstnormal">
									   					<tr>
									   						<td>
									   						<table>
									   							<tr>
									   								<td><img src="images/folders-stack.png"></td>
									   								<td><a href="werfdocumenten.php?werf={id}" onclick="return GB_showCenter('Supervisie - Werfdocumenten', this.href)">Werfdocumenten </a></td>
									   							</tr>
									   						</table>
									   						 </td>
									   						<td>
									   						<table>
									   							<tr>
									   								<td><img src="images/book-open.png"></td>
									   								<td><a href="vorderingen.php?werf={id}" onclick="return GB_showCenter('Supervisie - Vorderingen', this.href)">Vorderingen </a></td>
									   							</tr>
									   						</table>
									   						 </td>
									   						<td>
									   						<table>
									   							<tr>
									   								<td><img src="images/pencil-ruler.png"></td>
									   						
									   								<td><a href="../oplevering/oplevering.php?werven_ID={id}&id={user}" onclick="return GB_showCenter('Supervisie - Eindopmeting', this.href)">Eindopmeting</a></td>
									   							</tr>
									   						</table>
									   						 </td>
									   					</tr>
									   				</table>
									   			
									   			</td>
									   			
									   		</tr>
									   	</table>
</div>
</body>
</html>

