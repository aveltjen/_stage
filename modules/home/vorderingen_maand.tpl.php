<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisor V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styleContent.css" rel="stylesheet" type="text/css">
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
{titel}
<table width="100%" class="tekstnormal">
	<tr>
		<td height="50">
			<table class="tekstnormal" border="0">
				<tr>
					<td><img src="images/calendar-month.png">&nbsp;Kies de gewenste periode:</td>
					<td>
						<form action="?raadplegen=yes&werf={werf}" method="POST">
							<select name="periode">
							<option>--Beschikbare perioden--</option>
							<!-- BEGIN dates -->
							<option value="{lbl_dates} {vs}">{lbl_dates} {vs}</option>
							<!-- END dates -->
							</select>
						
					</td>
					<td width="250">
						&nbsp;&nbsp;<button type="submit">Raadplegen</button>&nbsp;&nbsp;{printen}{printen2}
						</form>
					</td>
				
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" align="center">
			<fieldset>
			<legend class="tekstlegend">Vorderingstaat raadplegen</legend>
			
			
			<table width="600" height="26" cellpadding="2" cellspacing="1">
			<tr>
				<td colspan="6" valign="top" height="40">
					<table width="100%">
						<tr>
							<td align="left"><img src="images/book-open-next.png"> <b>Vorderingstaat:</b> {vsnum}</td>
							<td align="center"><img src="images/calendar--arrow.png"> <b>Periode:</b> {periode}</td>
							<td align="right"><b>Totaal bedrag {vsnum}:</b> {tbedrag}</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<table width="100%">
									<tr>
										<td colspan="3" align="levt"><b>Totaal aanbestedingsbedrag:</b> {hvtotaal}</td>
										<td colspan="3" align="right"><b>Totaal vorige vorderingen:</b> {vtotaal}</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">&nbsp;</td>
						</tr>	
					</table>
				</td>
			</tr>
			</table>
			
			<table width="643" cellpadding="2" cellspacing="1">
			<tr class="tekstnormal" bgcolor="#EFEFEF">
     			 <td width="39">&nbsp;</td>
     			 <td width="78"><b>Post Nr.</b></td>
     			 <td width="96"><b>Vorige Hv.</b></td>
     			 <td width="96"><b>Huidige Hv.</b></td>
     			 <td width="96"><b>Totale Hv.</b></td>
     			 <td width="205"><b>Bedrag (&euro;)</b></td>
			</tr>
			</table>
			
			<div style="position:relative;
	left:8px;
	overflow-x: no;
	overflow-y: scroll;
	height:200px;
	width:683px;
	z-index:1;
	">
			<table width="643" cellpadding="2" cellspacing="1">
			<!-- BEGIN posten -->
			<tr class="drukrows">
				 <td width="39">{icon}</td>
     			 <td width="78">{msNummer}</td>
     			 <td width="96">{vorige}</td>
     			 <td width="96">{huidige}</td>
     			 <td width="96">{totaal}</td>
     			 <td width="205">{bedrag}</td>
			</tr>
			<!-- END posten -->
			{empty}
			</table>
			</div>	
			</fieldset>
		</td>
	</tr>
</table>
</body>
</html>

