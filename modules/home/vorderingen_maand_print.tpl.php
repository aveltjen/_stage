<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>Supervisor V3 - afdrukweergave</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styleContent.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function printen() {
   print();
   window.close();
}
//-->
</script>

</head>
<body onload="printen();">
{titel}
<table width="233" height="800" border="1" align="center" cellpadding="0" cellspacing="0" class="tekstnormal">
<tr>
<td valign="top">
<table width="598" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="center"><img src="images/infrax.jpg"></td>
</tr>
</table>
<table width="598">
<tr>
<td colspan="2"><hr size="1"></td>
</tr>
<tr>
<td><b>OPMAAK VORDERINGSSTAAT</b></td>
<td><div align="right"><b>DOC. NR.3</b></div></td>
</tr>
</table>
<table width="600" height="26" cellpadding="2" cellspacing="1">
			<tr>
				<td colspan="5" valign="top" height="40">
					<hr size="1">
					<table width="100%">
						<tr>
							<td colspan="3">
								<img src="images/box.png"> <b>Project:</b> {project}
							</td>
						</tr>
						<tr>
							<td align="left"><img src="images/book-open-next.png"> <b>Vorderingstaat Nr.:</b> {vsnum}</td>
							<td align="center">{printen}</td>
							<td align="right"><img src="images/calendar--arrow.png"> <b>Periode:</b> {periode}</td>
						</tr>
					</table>
					<hr size="1">
				</td>
			</tr>
			<tr class="tekstnormal" bgcolor="#EFEFEF">
     			 <td width="20">&nbsp;</td>
     			 <td width="78"><b>Post Nr.</b></td>
     			 <td width="157"><b>Vorige hoeveelheid</b></td>
     			 <td width="164"><b>Huidige hoeveelheid</b></td>
     			 <td width="153"><b>Totale hoeveelheid</b></td>
			</tr>
			</table>
		
			<div id="maandlist">
			<table width="600" cellpadding="2" cellspacing="1" border="1">
			<!-- BEGIN posten -->
			<tr class="drukrows">
				 <td width="20">{icon}</td>
     			 <td width="78">{msNummer}</td>
     			 <td width="157">{vorige}</td>
     			 <td width="164">{huidige}</td>
     			 <td width="153">{totaal}</td>
			</tr>
			<!-- END posten -->
			{empty}
			</table>
</td>
  </tr>
</table>
</body>
</html>

