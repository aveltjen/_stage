<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supervisor V3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
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
	<tr bgcolor="#ffffff">
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
				   <td width="91" background="images/index_r1_c4.png" align="center" valign="middle"><b>Documentenbeheer</b></td>
				   <td width="9" background="images/index_r1_c5.png"></td>
				   <td width="320" background="images/index_r1_c6.gif">&nbsp;</td>
				   <td background="images/index_r1_c7.gif"></td>
		
				  </tr>
				  <tr>
				   <td background="images/index_r2_c1.png"><img src="images/spacer.gif" height="3" alt="" width="13"></td>
				   <td colspan="5" bgcolor="White" valign="top">
				   	<table width="100%" class="tekstinfo">
				   		<tr>
				   			<td align="left"></td>
				   			<td align="right"><a href="index.php"><img src="images/back.gif" alt='Terug'></a></td>
				   		</tr>
				   	</table>
					<table width="100%" height="150" align="left" border="0" cellpadding="10" cellspacing="1" class="tableframe">
						<tr>
						
							<td align="left" valign="top">		
								
				
									<!-- The file upload form used as target for the file upload widget -->
								    <form id="fileupload" action="{upload_dir}" method="POST" enctype="multipart/form-data"> 
								             
								                <span class="btn btn-success fileinput-button" style="margin-bottom:10px;">
								                    <i class="icon-plus icon-white"></i>
								                    <span>Add files...</span>
								                    <input type="file" name="files[]" multiple>
								                </span>
								        	
								               
	
								        <!-- The loading indicator is shown during image processing -->
								        <div class="fileupload-loading"></div>
								        <br>
								        <!-- The table listing the files available for upload/download -->
								        <table class="table table-striped">
								        	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
								        	
								        	</tbody>
								        </table>
								    </form>
								
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
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
        
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

