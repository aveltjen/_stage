<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisor V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styleSV.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
function submitform()
{
  document.selecteren.submit();
}

</SCRIPT>
</head>
<body>
{titel}

<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/logo.png"></td>
		<td align="right"><img src="images/header.jpg"></td>
	</tr>
	<tr>
		<td colspan="2" height="18" background="images/menubar.png">
			<table cellpadding="0" cellspacing="0" class="hoofdmenu" width="950" border="0">
				<td width="20">&nbsp;</td>
				<td width="600"><img src="images/figure_ver1.gif"> {Name} :: {description}</td>
				<td align="right" width="1%"><a href="index.php">Start</a></td>
				<td align="right" width="1%"><a href="?action=logout">Uitloggen</a></td>
			</table>
		</td>
	</tr>
</table>

<div id="frame">
<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td valign="top" align="left">
    	<table cellpadding="0" cellspacing="0" align="left">
    		<tr>
    			<td>
    				
    			</td>
    		</tr>
    		<tr>
    			<td>
	    			
    			</td>
    		</tr>
    		<tr>
    			<td>
    			</td>
    		</tr>
    	</table>		
    </td>
    <td rowspan="3" valign="top" align="center" align="left">
    	<div align="center">
    	<table width="800" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
				<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
				  <tr>
				   <td height="29" background="images/index_r1_c1.gif"></td>
				   <td width="317" background="images/index_r1_c2.gif"></td>
				   <td width="8" background="images/index_r1_c3.png"></td>
				   <td width="91" background="images/index_r1_c4.png" align="center" valign="middle"><b>Wervenbeheer</b></td>
				   <td width="9" background="images/index_r1_c5.png"></td>
				   <td width="320" background="images/index_r1_c6.gif">&nbsp;</td>
				   <td background="images/index_r1_c7.gif"></td>
		
				  </tr>
				  <tr>
				   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
				   <td colspan="5" bgcolor="White" valign="top">
				   	<table width="100%" class="tekstinfo">
				   		<tr>
				   			<td align="left"><img src="images/verwijder.gif"> <b>Werf verwijderen:</b> Selectievakje eerst selecteren en vervolgens op het vuilbakje klikken!</td>
				   			<td align="right"><a href="index.php"><img src="images/back.gif" alt='Terug'></a></td>
				   		</tr>
				   	</table>
					<table width="100%" height="150" align="left" border="0" cellpadding="10" cellspacing="1" class="tableframe">
						<tr>
							<td align="left" valign="top" class="tableframe">
									<form name="selecteren" method="POST" action="?action=delete" class="tekstnormal">
									<table width="190" class="plattetekst">
										<tr><td colspan="2" align="center"><b>Mijn werven</b><hr size="1"></td></tr>
									</table>
									<div class="werflistbeheer">
									<table cellpadding="0" cellspacing="0" border="0" width="300" class="config">
										<!-- BEGIN Werflist -->
											<tr height="50">
												<td align="left" width=""><img src="images/box.png"></td>
												<td width="50" align="left"><b>{Number}</b> {description}</td>
												<td align="left">{checkbox}</td>
												<td align="left">{editwerf}</td>
												<td align="left">{archiveer}</td>
												<td align="left">{delete}{id}</td>
												<td align="left">{archief}</td>
											</tr>
										<!-- END Werflist -->
									</div>
									</table>
									</form>
							
							</td>
							<td align="left" valign="top">
							{txt_bevestigd}{txt_archief}
								<fieldset class="plattetekst">
								<legend class="tekstlegend"><b>Werf toevoegen</b></legend>
								
									<form name="addwerf" method="POST" enctype="multipart/form-data" action="?action=addwerf">
									<table height="80" border="0" class="tekstnormal">
										<tr>
											<td>Werfnummer:</td>
											<td><input type="text" name="nummer" size="25"></td>
										</tr>
										<tr>
											<td>Werfomschrijving:</td>
											<td><input type="text" name="omschrijving" size="25"></td>
										</tr>
										<tr>
											<td>Startdatum: </td>
											<td><input type="text" name="startdatum" value="{today}" size="10" /></td>
										</tr>
										<tr>
											<td colspan="2" align="left">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="2"></td>
										</tr>
										<tr>
											<td>Meetstaat:</td>
											<td><input type="file" name="f" size="25"></td>
										</tr>
										<tr>
											<td height="25" colspan="2"></td>
										</tr>
										<tr>
											<td colspan="2"><button type="submit">Toevoegen</button></td>
										</tr>
									</table>
							
								</fieldset>
							</td>
						</tr>
					</table>
				   
				   </td>
				   <td background="images/index_r2_c7.gif">
				   </td>
				   
				  </tr>
				  <tr>
				   <td width="13" background="images/index_r3_c1.gif">&nbsp;</td>
				   <td colspan="5" background="images/index_r3_c2.gif"><img src="images/spacer.gif" height="15" alt="" width="3"></td>
				   <td width="11" background="images/index_r3_c7.gif">&nbsp;</td>
				   
				  </tr>
				</table>
				</div>
    </td>
  </tr>
</table>
</div>
</body>
</html>

