<?php

		//Functie Administrator 
		function email($bestemmeling, $fullname){

			// multiple recipients
			$to  = $bestemmeling; // note the comma
			
			// subject
			$subject = "CONFIRMATION!!! Conference Technology enhance learning in the workplace!!!";
			
			// message
			$message = "
			<html>
			<head>
			 
			</head>
			<body>
			<p>Dear ".$fullname.",</p>
			Your registration was succesful!!! We will contact you with new updates concerning the conference. <br>For further questions you can contact us by email: <A HREF='mailto:edict@khlim.be'>edict@khlim.be</A>.
			<p>Kind regards,</p>
			On behalf of the organisation
			</body>
			</html>
			";
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			$headers .= 'From: Education & ict <edict@khlim.be>' . "\r\n";
			
			// Mail it
			mail($to, $subject, $message, $headers);
		}
		
		function email_webmaster($Doclink){

			// multiple recipients
			$to  = "aveltjen@khlim.be"; // note the comma
			
			// subject
			$subject = "NIEWE MEETSTAAT!";
			
			// message
			$message = "
			<html>
			<head>
			 
			</head>
			<body>
			<p>Dag Andy,</p>
			Is het mogelijk de volgende meetstaat online te plaatsen!!!".$Doclink."
			<p>Kind regards,</p>
			Andy Veltjen
			</body>
			</html>
			";
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			$headers .= 'From: Supervisie <aveltjen@khlim.be>' . "\r\n";
			
			// Mail it
			mail($to, $subject, $message, $headers);
		}
	
?>

