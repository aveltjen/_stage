<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisor V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styleSV.css" rel="stylesheet" type="text/css">
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
<style type="text/css" media="all">
@import "jquery/jquery-tooltip/css/global.css";
</style>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
			<link rel="stylesheet" href="jquery/css/ui-lightness/jquery-ui-1.8.18.custom.css" type="text/css" media="all" />
			<link rel="stylesheet" href="jquery/development-bundle/themes/ui-lightness/jquery.ui.tooltip.css" type="text/css" media="all" />
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
			<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
			<script src="jquery/jquery-tooltip/js/jtip.js" type="text/javascript"></script>
<script type="text/javascript">
	function openCalculatorBox(){
		window.open("reken.htm","_blank","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=210, height=165, left=420, top=300");
	}
</script>

<SCRIPT>
function compute(obj) {
	var omschrijving = obj.omschrijving.value
	var a = omschrijving.replace(/\,/g,'.')
	
	var num = eval(a)
	var res = num.toFixed(3)
	
	
	res = res.replace(".",",");


	//res
	obj.opgemeten.value = res
	
}
</SCRIPT>

</head>
<body>
{titel}
<table cellpadding="0" cellspacing="0" border="0" align="center">
  <tr>
    
    <td rowspan="3" valign="top" align="center" align="center">

    <table>
    	<tr>
    		<td align="center">
    			<div align="center">
    				
    	<table width="740" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
				<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
				  <tr>
				   <td height="29" background="images/index_r1_c1.gif"></td>
				   <td width="317" background="images/index_r1_c2.gif"></td>
				   <td width="8" background="images/index_r1_c3.png"></td>
				   <td width="91" background="images/index_r1_c4.png" align="center" valign="middle"><b>Opmeten</b></td>
				   <td width="9" background="images/index_r1_c5.png"></td>
				   <td width="320" background="images/index_r1_c6.gif">&nbsp;</td>
				   <td background="images/index_r1_c7.gif"></td>
		
				  </tr>
				  <tr>
				   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
				   <td colspan="5" bgcolor="White" align="center" valign="top">
						<table>
                        	<tr>
                            	<td valign="top">
                            	{txt_delete}
                            	{txt_wijzig}
                            		<fieldset>
                            			<legend class="tekstlegend"><img src="images/book-open-bookmark.png"> Gegevens geselecteerde post</legend>
                            			<table width="650" class="tekstnormal">
                            				<tr align="left">
                            					<td width="74"><b>Nummer:</b></td>
                            					<td width="63">{nummer}</td>
                            					<td width="56"></td>
                            					<td width="185">&nbsp;</td>
                            					<td width="71"><strong>Eenheden:</strong></td>
                            					<td width="72">{eenheden}</td>
                            					<td width="27"><strong>HV:</strong></td>
                            					<td width="86">{hoeveelheid}</td>
                           					</tr>
                           					<tr align="left">
                           						<td colspan="8"><b>Omschrijving:</b> {omschrijving}</td>
                           					</tr>		  
                            			</table>
                            		</fieldset><br>
                            		
                            		<fieldset>
                            		<legend class="tekstlegend"><img src="images/plus-circle-frame.png"> Nieuwe opmeting ingeven</legend>
                            		<form name="evalform" action="?werf={werf}&msID={msID}&action=add" method="POST" enctype="multipart/form-data">
                            		
                            		<table width="650" class="tekstnormal">
                            			<tr align="left" class="tip">
                            				<td>Omschrijving:</td>
                                            <td><input value="{lastomschrijving}" type="text" size="50" name="omschrijving" /> <INPUT TYPE="button" VALUE=" = " onClick="compute(this.form)"><span class="formInfo"><a href="jquery/jquery-tooltip/calculator.htm?width=320" class="jTip" id="one" name="De calculator gebruiken">?</a></span></td>
                                            <td align="right"><a href="?lastopmeting=1&msID={msID}&werf={werf}"><img src="images/calendar_add.png"></a><span class="formInfo"><a href="jquery/jquery-tooltip/history2.htm?width=280" class="jTip" id="two" name="Laatste opmeting oproepen">?</a></span>&nbsp;<button type="submit">opslaan</button></td>
                            			</tr>
                            			<tr align="left">
                            				<td>Opgemeten:</td>
                                            <td><input value="{lastopgemeten}" type="text" size="10" name="opgemeten" /></td>
                                            <td></td>
                            			</tr>
                            			<tr align="left">
                            				<td>Bijlage: <img src="images/attach.png"></td>
                                            <td><input type="file" name="f" size="25"></td>
                                            <td></td>
                            			</tr>
                            		</table>
                            		</form>
                            		</fieldset><br>
                            		<table width="100%" class="tekstnormal">
                            			<tr>
                            				<td align="right">{printen2}</td>
                            			</tr>
                            		</table>
                            		<fieldset>
                            		<legend class="tekstlegend"><img src="images/property-blue.png"> Opgemeten hoeveelheden <i>(Totaal opgemeten: {totaal})</i></legend>
                            		
                            		<table height="200">
                            			<tr>
                            				<td valign="top">
                            			<div id="vorderlistkop">	
                            			<table width="645" border="0" cellpadding="2" cellspacing="1">
                            			<tr class="tekstnormal" bgcolor="#EFEFEF" align="left">
											<td width="20"></td>
											<td width="80"><b>OpmetingID</b></td>
											<td width="341"><b>Omschrijving/berekening</b></td>
											<td width="58"><b>Gemeten</b></td>
											<td width="25">&nbsp;</td>
											<td width="25">&nbsp;</td>
											<td width="25">&nbsp;</td>
											<td width="25">&nbsp;</td>
										</tr>	
										</table>
										</div>
										<div id="vorderlist">
										<table width="645" border="0" cellpadding="2" cellspacing="1">
                            			<!-- BEGIN opmetingen -->
                            			<tr class="drukrows" align="left">
											<td width="20">{icon}</td>
											<td width="80">{ID}</td>
											<td width="341">{berekening}</td>
											<td width="58">{gemeten}</td>
											<td width="25">{bijlage}</td>
											<td width="25" align="center">{delete}</td>
											<td width="25" align="center">{wijzig}</td>
											<td width="25" align="center">{vorder}</td>
										</tr>	
                               			<!-- END opmetingen -->
                               			{geenopm}
                            			</table>
                            			</div>	
                            				</td>
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
				   <td colspan="5" background="images/index_r3_c2.gif"></td>
				   <td width="11" background="images/index_r3_c7.gif">&nbsp;</td>
				   
				  </tr>
				</table>

</body>
</html>

