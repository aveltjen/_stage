<html >
<body>
<h3>Email verzenden</h3>
<?

   
    $zender_email = "info@owt.be";
    $zender_naam = "Onafhankelijk werftoezicht";
    $onderwerp = "nieuwe werf";
    $bericht = "nieuwe werf uploaden";
    $bestemmeling = 'aveltjen@khlim.be';
    
    $headers = "Content-type: text/plain; charset=iso-8859-1\n";                
    $headers .= "From: ".$zender_naam."<".$zender_email.">\n";        
    $headers .= "Reply-To: ".$zender_naam."<".$zender_email.">\n";                        
    $headers .= "Return-Path: ".$zender_naam."<".$zender_email.">\n";                                
    $headers .= "X-Mailer: PHP/" . phpversion();    
    
    if(mail($bestemmeling,$onderwerp,$bericht,$headers))
    {
    echo 'Uw email werd succesvol verzonden';
    }
    else
    {
    echo 'Er is een fout opgetreden bij het verzenden van de email';
    }

?>