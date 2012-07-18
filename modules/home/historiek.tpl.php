<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisie  - Historiek</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/faviconSV.ico" type="image/x-icon" />
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
</head>
<body>
{titel}
<div id="frame">
<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    
    <td rowspan="3" valign="top" align="center" align="left">

    <table>
    	<tr>
    		<td>
    			<div align="center">
    				
    	<table width="740" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
				<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
				  <tr>
				   <td height="29" background="images/index_r1_c1.gif"></td>
				   <td width="317" background="images/index_r1_c2.gif"></td>
				   <td width="8" background="images/index_r1_c3.png"></td>
				   <td width="91" background="images/index_r1_c4.png" align="center" valign="middle"><b>Historiek</b></td>
				   <td width="9" background="images/index_r1_c5.png"></td>
				   <td width="320" background="images/index_r1_c6.gif">&nbsp;</td>
				   <td background="images/index_r1_c7.gif"></td>
		
				  </tr>
				  <tr>
				   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
				   <td colspan="5" bgcolor="White" align="center" valign="top">

    <table width="100%" class="tekstnormal">
    	<tr>
    		<td>{fout}</td>
    		<td> </td>
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
                           								<b>VS{vsnummer}: {periode}</b>
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

