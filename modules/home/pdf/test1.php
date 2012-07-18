<?php 
include ('class.ezpdf.php'); 
$pdf =& new Cezpdf(); 
$pdf->selectFont('./fonts/Helvetica.afm'); 
$data = array( 
 array('num'=>1,'name'=>'gandalf','type'=>'wizard') 
,array('num'=>2,'name'=>'bilbo','type'=>'hobbit','url'=>'http://www.ros.co. 
nz/pdf/') 
,array('num'=>3,'name'=>'frodo','type'=>'hobbit') 
,array('num'=>4,'name'=>'saruman','type'=>'bad 
dude','url'=>'http://sourceforge.net/projects/pdf-php') 
,array('num'=>5,'name'=>'sauron','type'=>'really bad dude') 
); 
$pdf->ezTable($data); 
$pdf->ezStream(); 
?> 

