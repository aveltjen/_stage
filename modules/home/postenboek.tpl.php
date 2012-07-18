<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisor V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styleSV.css" rel="stylesheet" type="text/css">
<script>
<!-- Hide from old browsers

/******************************************
* Find In Page Script -- Submitted/revised by Alan Koontz (alankoontz@REMOVETHISyahoo.com)
* Visit Dynamic Drive (http://www.dynamicdrive.com/) for full source code
* This notice must stay intact for use
******************************************/

//  revised by Alan Koontz -- May 2003

var TRange = null;
var dupeRange = null;
var TestRange = null;
var win = null;


//  SELECTED BROWSER SNIFFER COMPONENTS DOCUMENTED AT
//  http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html

var nom = navigator.appName.toLowerCase();
var agt = navigator.userAgent.toLowerCase();
var is_major   = parseInt(navigator.appVersion);
var is_minor   = parseFloat(navigator.appVersion);
var is_ie      = (agt.indexOf("msie") != -1);
var is_ie4up   = (is_ie && (is_major >= 4));
var is_not_moz = (agt.indexOf('netscape')!=-1)
var is_nav     = (nom.indexOf('netscape')!=-1);
var is_nav4    = (is_nav && (is_major == 4));
var is_mac     = (agt.indexOf("mac")!=-1);
var is_gecko   = (agt.indexOf('gecko') != -1);
var is_opera   = (agt.indexOf("opera") != -1);


//  GECKO REVISION

var is_rev=0
if (is_gecko) {
temp = agt.split("rv:")
is_rev = parseFloat(temp[1])
}


//  USE THE FOLLOWING VARIABLE TO CONFIGURE FRAMES TO SEARCH
//  (SELF OR CHILD FRAME)

//  If you want to search another frame, change from "self" to
//  the name of the target frame:
//  e.g., var frametosearch = 'main'

//var frametosearch = 'main';
//var frametosearch = self;
var frametosearch = 'content';


function search(whichform, whichframe) {

//  TEST FOR IE5 FOR MAC (NO DOCUMENTATION)

if (is_ie4up && is_mac) return;

//  TEST FOR NAV 6 (NO DOCUMENTATION)

if (is_gecko && (is_rev <1)) return;

//  TEST FOR Opera (NO DOCUMENTATION)

if (is_opera) return;

//  INITIALIZATIONS FOR FIND-IN-PAGE SEARCHES

if(whichform.findthis.value!=null && whichform.findthis.value!='') {

       str = whichform.findthis.value;
       win = whichframe;
       var frameval=false;
       if(win!=self)
{

       frameval=true;  // this will enable Nav7 to search child frame
       win = parent.frames[whichframe];

}

    
}

else return;  //  i.e., no search string was entered

var strFound;

//  NAVIGATOR 4 SPECIFIC CODE

if(is_nav4 && (is_minor < 5)) {
   
  strFound=win.find(str); // case insensitive, forward search by default

//  There are 3 arguments available:
//  searchString: type string and it's the item to be searched
//  caseSensitive: boolean -- is search case sensitive?
//  backwards: boolean --should we also search backwards?
//  strFound=win.find(str, false, false) is the explicit
//  version of the above
//  The Mac version of Nav4 has wrapAround, but
//  cannot be specified in JS

 
        }

//  NAVIGATOR 7 and Mozilla rev 1+ SPECIFIC CODE (WILL NOT WORK WITH NAVIGATOR 6)

if (is_gecko && (is_rev >= 1)) {
   
    if(frameval!=false) win.focus(); // force search in specified child frame
    strFound=win.find(str, false, false, true, false, frameval, false);

//  The following statement enables reversion of focus 
//  back to the search box after each search event 
//  allowing the user to press the ENTER key instead
//  of clicking the search button to continue search.
//  Note: tends to be buggy in Mozilla as of 1.3.1
//  (see www.mozilla.org) so is excluded from users 
//  of that browser.

    if (is_not_moz)  whichform.findthis.focus();

//  There are 7 arguments available:
//  searchString: type string and it's the item to be searched
//  caseSensitive: boolean -- is search case sensitive?
//  backwards: boolean --should we also search backwards?
//  wrapAround: boolean -- should we wrap the search?
//  wholeWord: boolean: should we search only for whole words
//  searchInFrames: boolean -- should we search in frames?
//  showDialog: boolean -- should we show the Find Dialog?


}

 if (is_ie4up) {

  // EXPLORER-SPECIFIC CODE revised 5/21/03

  if (TRange!=null) {
	  
   TestRange=win.document.body.createTextRange();
 
	  

   if (dupeRange.inRange(TestRange)) {

   TRange.collapse(false);
   strFound=TRange.findText(str);
    if (strFound) {
        //the following line added by Mike and Susan Keenan, 7 June 2003
        win.document.body.scrollTop = win.document.body.scrollTop + TRange.offsetTop;
        TRange.select();
        }


   }
   
   else {

     TRange=win.document.body.createTextRange();
     TRange.collapse(false);
     strFound=TRange.findText(str);
     if (strFound) {
        //the following line added by Mike and Susan Keenan, 7 June 2003
        win.document.body.scrollTop = TRange.offsetTop;
        TRange.select();
        }



   }
  }
  
   if (TRange==null || strFound==0) {
   TRange=win.document.body.createTextRange();
   dupeRange = TRange.duplicate();
   strFound=TRange.findText(str);
    if (strFound) {
        //the following line added by Mike and Susan Keenan, 7 June 2003
        win.document.body.scrollTop = TRange.offsetTop;
        TRange.select();
        }

   
   }

 }

  if (!strFound) alert ("String '"+str+"' not found!") // string not found

        
}
  </script>
  <SCRIPT LANGUAGE="JavaScript">
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
</head>
<body OnLoad="loadImages()">
{titel}

<div id="hidepage" style="position: absolute; left:320px; top:153px; layer-background-color: #FFFFCC; height: 50; width: 100; z-index:2; font-family: Verdana, Helvetica, sans-serif; font-size: 10px; font-style: normal; font-weight: bold; "> 

<table width=100%><tr><td>Postenboek vorderingen wordt ingeladen ... even geduld!</td></tr></table></div> 

<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/logo.png"></td>
		<td align="right"><img src="images/header.jpg"></td>
	</tr>
	<tr>
		<td colspan="2" height="18" background="images/menubar.png">
			<table cellpadding="0" cellspacing="0" class="tekstnormal" width="950" border="0">
				<td width="20">&nbsp;</td>
				<td width="600"><b>:: {Name} :: </b>{description}</td>
				<td align="right" width="1%"><a href="../home/index.php">Start</a></td>
				<td align="right" width="1%"><a href="?action=logout">Uitloggen</a></td>
			</table>
		</td>
	</tr>
</table>
</div>
<div id="frame">
<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td rowspan="3" valign="top" align="center" align="left">
    	<div align="center">
    	<table width="900" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
				<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
				  <tr>
				   <td><img src="images/spacer.gif" width="14" height="1" border="0" alt="" /></td>
				   <td><img src="images/spacer.gif" width="15" height="1" border="0" alt="" /></td>
				   <td><img src="images/spacer.gif" width="9" height="1" border="0" alt="" /></td>
				   <td><img src="images/spacer.gif" width="136" height="1" border="0" alt="" /></td>
				   <td><img src="images/spacer.gif" width="9" height="1" border="0" alt="" /></td>
				   <td><img src="images/spacer.gif" width="15" height="1" border="0" alt="" /></td>
				   <td><img src="images/spacer.gif" width="13" height="1" border="0" alt="" /></td>
				
				  </tr>
				
				  <tr>
				   <td width="14" background="images/index_r1_c1.gif"><img src="images/spacer.gif" height="29" width="14"></td>
				   <td background="images/index_r1_c2.gif">&nbsp;</td>
				   <td width="1%" background="images/index_r1_c3.png"></td>
				   <td width="20%" background="images/index_r1_c4.png" align="center" valign="middle"><b>Postenboek Vorderingen</b></td>
				   <td width="1%" background="images/index_r1_c5.png"><img src="images/spacer.gif" height="29" width="9"></td>
				   <td background="images/index_r1_c6.gif">&nbsp;</td>
				   <td width="10" background="images/index_r1_c7.gif"><img src="images/spacer.gif" height="29" width="10"></td>
		
				  </tr>
				  <tr>
				   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
				   <td colspan="5" bgcolor="White">
				   <form name="form1" onSubmit="search(document.form1, frametosearch); return false">
				   	<table width="100%" class="plattetekst" border="0">
				   		<tr>
				   			<td valign="bottom" width="1%">
				   				<img src=images/zoeken.gif>
				   			</td>
				   			<td align="left" valign="bottom">
									<input type="text" name="findthis" size="15" title="Druk ALT + Z om je zoekactie te herhalen">
									<input name="submit" type="submit" ACCESSKEY="z" value="Post zoeken">
				   			</td>
				   			<td align="right"><a href="../home/startwerf.php?werf={id}"><img src="images/back.gif" alt='Terug'></a></td>
				   		</tr>
				   	</table>
				   	</form>
					<table width="100%" height="150" align="left" border="0" cellpadding="10" cellspacing="1" class="tableframe">
						<tr>
							<td align="left" valign="top" class="tableframe">
								<div id="hidepage" style="position: absolute; left:5px; top:5px; height: 100%; width: 100%;"> 

<table class="tekstnormal" width=100%><tr><td><img src="images/ajax-loader.gif"> meetstaat loading...</td></tr></table></div> 
								<iframe name="content" frameborder="0" scrolling="No" height="420" width="900" src="postenboekcontent.php?werf={id}"></iframe>
							</td>
						</tr>
					</table>
				   
				   </td>
				   <td background="images/index_r2_c7.gif"><img src="images/spacer.gif" height="3" alt="" width="13
				   "></td>
				   
				  </tr>
				  <tr>
				   <td width="14" background="images/index_r3_c1.gif"><img src="images/spacer.gif" height="15" width="14"></td>
				   <td colspan="5" background="images/index_r3_c2.gif"><img src="images/spacer.gif" height="15" alt="" width="3"></td>
				   <td width="14" background="images/index_r3_c7.gif"><img src="images/spacer.gif" height="15" width="14"></td>
				   
				  </tr>
				</table>
				</div>
    </td>
  </tr>
</table>
</div>
</body>
</html>

