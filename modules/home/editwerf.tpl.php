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
			<td width="600"><b> <img src="images/icon_user.gif"> {Name} :: </b>{description}</td>
				<td align="right" width="1%"><a href="index.php">Start</a></td>
				<td align="right" width="1%"><a href="?action=logout">Uitloggen</a></td>
			</table>
		</td>
	</tr>
</table>
</div>
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
    			
    			</td>
    		</tr>
    	</table>		
    </td>
    <td rowspan="3" valign="top" align="center" align="left">
    	<div align="center">
    	<table width="700" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
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
				   	<table width="100%" class="tekstnormal">
				   		<tr>
				   			<td align="left"></td>
				   			<td align="right"><a href="wervenbeheer.php"><img src="images/back.gif" alt='Terug'></a></td>
				   		</tr>
				   	</table>
					<table width="100%" height="150" align="left" border="0" cellpadding="10" cellspacing="1" class="tableframe">
						<tr>
	
							<td align="left" valign="top">
								{txt_bevestigd}
								<fieldset class="tekstnormal">
								<legend class="tekstlegend"><b>Werf wijzigen</b></legend>
									<form method="POST" action="?action=editwerf&WerfID={WerfID}">
									<table height="80" class="plattetekst">
										<tr>
											<td>Werfnummer:</td>
											<td><input type="text" name="Number" value="{Nummer}" size="25"></td>
										</tr>
										<tr>
											<td>Werfomschrijving:</td>
											<td><input type="text" name="Description" value="{Description}" size="25"></td>
										</tr>
										<tr>
											<td>Startdatum: </td>
											<td><input type="text" name="Date" value="{Date}" size="10" /><i>(vorderingsstaat 1)</i></td>
										</tr>
										<tr>
											<td colspan="2" align="left">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="2"><button type="submit">Wijzigen</button></td>
										</tr>
									</table>
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
				   <td width="13" background="images/index_r3_c1.gif">&nbsp;</td>
				   <td colspan="5" background="images/index_r3_c2.gif"><img src="images/spacer.gif" height="15" alt="" width="3"></td>
				   <td width="11" background="images/index_r3_c7.gif">&nbsp;</td>
				   
				  </tr>
				</table>
				</div>
    </td>
    <td valign="top" align="left">
   
    </td>
  </tr>
</table>
</div>
</body>
</html>

