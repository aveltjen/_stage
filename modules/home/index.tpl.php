<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisie V3</title>
<link rel="shortcut icon" href="images/faviconSV.ico" type="image/x-icon" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- Bootstrap CSS Toolkit styles -->
<!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> -->
<link href="styles/styleSV.css" rel="stylesheet" type="text/css">
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">
<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]><link rel="stylesheet" href="blueimp/css/bootstrap-ie6.min.css"><![endif]-->
<!-- Bootstrap Image Gallery styles -->
<link rel="stylesheet" href="blueimp/css/bootstrap-image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>
<body>
{titel}

<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
	<tr bgcolor="white">
		<td width="250"><img src="images/logo.png"></td>
		<td align="right"><img src="images/header.jpg"></td>
	</tr>
	<tr>
		<td colspan="2" height="18" background="images/menubar.png">
			<table cellpadding="0" cellspacing="0" class="hoofdmenu" width="950" border="0">
				<td width="20">&nbsp;</td>
				<td width="600"><img src="images/figure_ver1.gif"> {Name} :: {description}</td>
				<td align="right" width="1%"><a href="handleiding_supervisie.pdf" target="_blank">Handleiding</a></td>
				<td align="right" width="1%"><a href="#">Start</a></td>
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
    				{docblock}
    			</td>
    		</tr>
    		<tr>
    			<td>
	    			<table width="230" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
					<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
					  
					
					  <tr>
					   <td width="14" background="images/index_r1_c1.gif"><img src="images/spacer.gif" height="29" width="14"></td>
					   <td background="images/index_r1_c2.gif">&nbsp;</td>
					   <td width="9" background="images/index_r1_c3.png"></td>
					   <td width="136" background="images/index_r1_c4.png" align="center" valign="middle"><b>Zoeken met google</b></td>
					   <td width="9" background="images/index_r1_c5.png"></td>
					   <td background="images/index_r1_c6.gif">&nbsp;</td>
					   <td width="10" background="images/index_r1_c7.gif"></td>
					   
					  </tr>
					  <tr>
					   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
					   <td colspan="5" bgcolor="White" valign="middle">
					  <form name="google" method="get" action="http://www.google.be/search" target="_blank">
					   <table width="100%" border="0" align="left">
							<tr>
								<td align="center" height="30"><input type="text" name="q" size="23" maxlength="255"></td>
							</tr>
							<tr>
								<td align="center"><button type="submit">Zoeken</button></td>
							</tr>
							<tr>
								<td align="center"><img src="images/google.gif"></td>
							</tr>
						</table>
						</td>
					   <td background="images/index_r2_c7.gif"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
			
					  </tr>
					  <tr>
					   <td width="14" background="images/index_r3_c1.gif"><img src="images/spacer.gif" height="15" width="14"></td>
					   <td colspan="5" background="images/index_r3_c2.gif"><img src="images/spacer.gif" height="15" alt="" width="3"></td>
					   <td width="10" background="images/index_r3_c7.gif"></td>
					   
					  </tr>
					</table>
					 </form>
    			</td>
    		</tr>
    		<tr>
    			<td align="left">
    				<table width="230" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
					<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
					  
					
					  <tr>
					   <td width="14" background="images/index_r1_c1.gif"><img src="images/spacer.gif" height="29" width="14"></td>
					   <td background="images/index_r1_c2.gif">&nbsp;</td>
					   <td width="9" background="images/index_r1_c3.png"></td>
					   <td width="136" background="images/index_r1_c4.png" align="center" valign="middle"><b>Mijn Profiel</b></td>
					   <td width="9" background="images/index_r1_c5.png"></td>
					   <td background="images/index_r1_c6.gif">&nbsp;</td>
					   <td width="10" background="images/index_r1_c7.gif"></td>
					   
					  </tr>
					  <tr>
					   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
					   <td colspan="5" bgcolor="White" valign="middle">
					  
					    <table width="100%" border="0" align="left">
							<tr>
								<td valign="top">
									<div id="profileLNK">
									<table width="179" cellpadding="0" cellspacing="0" border="0">
										<tr><td><b>{Name}</</td></tr>
										<tr><td>{Street}</td></tr>
										<tr><td>{Place}</td></tr>
										<tr><td>&nbsp;</td></tr>
										<tr><td>{Phone}</td></tr>
										<tr><td>{Mobile}</td></tr>
										<tr><td>{Email}</td></tr>
									</table>
									</div>
								</td>
							</tr>
						</table>
					   
						</td>
					   <td background="images/index_r2_c7.gif"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
			
					  </tr>
					  <tr>
					   <td width="14" background="images/index_r3_c1.gif"><img src="images/spacer.gif" height="15" width="14"></td>
					   <td colspan="5" background="images/index_r3_c2.gif"><img src="images/spacer.gif" height="15" alt="" width="3"></td>
					   <td width="10" background="images/index_r3_c7.gif"></td>
					   
					  </tr>
					</table>
    			</td>
    		</tr>
    	</table>		
    </td>
    <td rowspan="3" valign="top" align="center" align="left">
    	<div align="center">
    	<table width="500" border="0" cellpadding="0" cellspacing="0" class="tekstkader" align="left">
				<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
				  <tr>
				   <td height="29" background="images/index_r1_c1.gif"></td>
				   <td width="180" background="images/index_r1_c2.gif"></td>
				   <td width="7" background="images/index_r1_c3.png"></td>
				   <td width="129" align="center" valign="middle" background="images/index_r1_c4.png"><b>Mijn werven</b></td>
				   <td width="9" background="images/index_r1_c5.png"></td>
				   <td width="175" background="images/index_r1_c6.gif">&nbsp;</td>
				   <td background="images/index_r1_c7.gif"></td>
		
				  </tr>
				  <tr>
				   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
				   <td colspan="5" bgcolor="White" valign="top" align="right">
				  
				 
				  	
				  	
				   
				  <div class="werfliststart">	
					<table cellpadding="2" cellspacing="1" border="0" width="100%" class="tekstnormal">
						<tr bgcolor="#f7f6f6">
							<td align="left" width="25">&nbsp;</td>
							<td align="left" width="70"><b>werf nr.</b></td>
							<td align="left"><b>Omschrijving</b></td>
						</tr>
					<!-- BEGIN Werflist -->
						<tr>
							<td align="left">{bullet}</td>
							<td align="left">{Number}</td>
							<td align="left">{Description}</td>
						</tr>
					<!-- END Werflist -->
					</table>
					</div>
				   </td>
				   <td background="images/index_r2_c7.gif"><img src="images/spacer.gif" height="3" alt="" width="13
				   "></td>
				   
				  </tr>
				  <tr>
				   <td width="14" background="images/index_r3_c1.gif"><img src="images/spacer.gif" height="15" width="14"></td>
				   <td colspan="5" background="images/index_r3_c2.gif"><img src="images/spacer.gif" height="15" alt="" width="3"></td>
				   <td width="10" background="images/index_r3_c7.gif"></td>
				   
				  </tr>
				</table>
				</div>
    </td>
    <td valign="top" align="left">
    <table cellpadding="0" cellspacing="0" align="left">
    	<tr>
    		<td>
    			<table width="230" border="0" cellpadding="0" cellspacing="0" width="211" class="tekstkader">
					<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
					 
					  <tr>
					   <td width="14" background="images/index_r1_c1.gif"><img src="images/spacer.gif" height="29" width="14"></td>
					   <td background="images/index_r1_c2.gif">&nbsp;</td>
					   <td width="9" background="images/index_r1_c3.png"></td>
					   <td width="136" background="images/index_r1_c4.png" align="center" valign="middle"><b>Kalender</b></td>
					   <td width="9" background="images/index_r1_c5.png"></td>
					   <td background="images/index_r1_c6.gif">&nbsp;</td>
					   <td width="10" background="images/index_r1_c7.gif"></td>
					
					  </tr>
					  <tr>
					   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
					   <td colspan="5" bgcolor="White">
					   	
						<table height="100" border="0" align="center">
							<tr>
								<td valign="middle">
									<iframe frameborder="0" width="175" height="150" scrolling="No" src="calendar.php"></iframe>
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
					   <td width="10" background="images/index_r3_c7.gif"></td>
					  
					  </tr>
					</table>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<table width="230" border="0" cellpadding="0" cellspacing="0" class="tekstkader">
					<!-- fwtable fwsrc="Untitled" fwbase="index.png" fwstyle="Dreamweaver" fwdocid = "234834546" fwnested="0" -->
					
					  <tr>
					   <td width="14" background="images/index_r1_c1.gif"><img src="images/spacer.gif" height="29" width="14"></td>
					   <td background="images/index_r1_c2.gif">&nbsp;</td>
					   <td width="9" background="images/index_r1_c3.png"></td>
					   <td width="140" background="images/index_r1_c4.png" align="center" valign="middle"><b>Configuratie</b></td>
					   <td width="9" background="images/index_r1_c5.png"></td>
					   <td background="images/index_r1_c6.gif">&nbsp;</td>
					   <td width="10" background="images/index_r1_c7.gif"></td>
					
					  </tr>
					  <tr>
					   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
					   <td colspan="5" bgcolor="White">
					   	
						<table width="179" border="0" align="left">
							<tr>
								<td valign="top">
									<div id="configuratieLNK">
									<table cellpadding="0" cellspacing="0" border="0" class="configmenu">
										{configLnk}
									</table>
									</div>
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
					   <td width="10" background="images/index_r3_c7.gif"></td>
					  
					  </tr>
					  <tr>
    				  </tr>
					</table>
    		</td>
    	</tr>
    </table> 	
    </td>
  </tr>
</table>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class=""><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr height="35px">
            <td class="preview">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="images/page_white_magnify.png"></a>
            </td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="blueimp/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="blueimp/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="blueimp/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="blueimp/js/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload image processing plugin -->
<script src="js/jquery.fileupload-ip.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="js/locale.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->


</body>
</html>

