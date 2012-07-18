<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>{title}</title>
	<link rel="stylesheet" href="../home/styles/styleSV.css" />

	
</head>
<body>

<table width='600' align="center" class="tekstnormal">
<tr>
<td>
<a href="oplevering_pdf.php?werven_ID={id}&id={user}" target="_blank"><img src="../home/images/document-pdf.png">&nbsp;download PDF</a> 
</td>
</tr>
<tr>
<td>

<table class="tekstnormal" width='100%' align="center">
	        <tr>
	        <td height='30'>
	      		<img src='../home/images/docbalk5.png'/>
	        </td>
	        </tr>
	       </table>
	        
	        <table width='100%' align="center" class="tekstnormal" cellspacing="0" border="0">
	        <tr>
	        <td height='30'>
	        	<b>PROJECT:</b> {project}<br>
	        	<b>TOEZICHTER:</b> {toezichter}
	        </td>
	        <td rowspan='2' align='right'>
	        	<img src='../home/images/infrax.jpg'/ width='200'>
	        </td>
	        </tr>
	        <tr>
	        <td height='30' rowspan='2'>
	        	
	        </td>
	        </tr>
	        
	        </table>
	        	<br>
	        <hr>
	        <table width='100%' align="center"class="tekstnormal">
	        <tr>
	        <td>
	        Totaal aanbestedingsbedrag: {vtotaal} 
	        </td>
	        </tr>
	        <tr>
	        <td>
	        Bedrag uitgevoerde werken: {totaal}
	        </td>
	        </tr>
	        </table>
	        <hr>
	        
	        <!-- BEGIN opmetingen -->      
	        <TABLE CELLSPACING='0' class="tekstnormal" align="center"  border="1">
			<TR>
				<TD BGCOLOR='#e49230' ALIGN='LEFT' WIDTH=200><b>Postnr.: </b>{nummer}</TD>
				<TD BGCOLOR='#e49230' ALIGN='CENTER' WIDTH=200><b>V.H.:</b> {VH} {eenheden}</TD>
				<TD BGCOLOR='#e49230' ALIGN='RIGHT' WIDTH=200><b>Eenheidsprijs:</b> {eur} {eprijs}</TD>
			</TR>
			<tr>
				<td colspan="3">{omschrijving}</td>
			</tr>
			<tr>
				<td>
					<b>Totaal opgemeten: {topgemeten}</b>
				</td>
				<td colspan="2" align="center">
					<b>Totale prijs: {popgemeten}</b>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="600" class="tekstnormal" cellpadding="3" cellspacing="0" border="0">
					<tr BGCOLOR='#fdcf94'>
					<td width="400">Berekening/Omschrijving</td><td width="110" align="right">Uitgevoerd</td><td align="center" width="90">Bijlage</td>
					<tr>
					<!-- BEGIN opmeting -->
					<tr>
					<td>{berekening}</td><td align="right">{uitgevoerd}</td><td align="center">{link}</td>
					</tr>
					<!-- END opmeting -->
					</table>
				</td>
			</tr>
			</table>
			<br><br>
	        <!-- END opmetingen -->
	        

</td>
</tr>
</table>		
</body>
</html>

