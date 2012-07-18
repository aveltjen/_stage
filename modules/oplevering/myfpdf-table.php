<?php

/**
 * Class extention for Header and Footer Definitions
 *
 */

class myFpdf extends FPDF
{
    
    public function Header()
    {
    	$werf=$_REQUEST["werven_ID"];
    	$werfdata = GetWerfByWerfID($werf);
    	
        $this->SetY(10);

        /**
        * yes, even here we can use the multicell tag!
        * this will be a local object
        */
        $oMulticell = fpdfMulticell::getInstance($this);
        
        $oMulticell->SetStyle("head1","arial","",6,"160,160,160");
        $oMulticell->SetStyle("head2","arial","",6,"0,119,220");
        
        $oMulticell->multiCell(200, 3, "OPMETING ".$werfdata["nummer"]." - gegenereerd door supervisie, product van onafhankelijk werftoezicht");
        
//         $this->Image(dirname(__FILE__) . '/images/interpid_logo.png', 160, 10, 40, 0, '', 'http://www.interpid.eu');
        $this->SetY($this->tMargin);
    }
    
    public function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial','I',7);
        $this->SetTextColor(170, 170, 170);
        $this->MultiCell(0, 4, "Page {$this->PageNo()} / {nb}", 0, 'C');
    }
    
    function WordWrap(&$text, $maxwidth)
    {
    	$text = trim($text);
    	if ($text==='')
    		return 0;
    	$space = $this->GetStringWidth(' ');
    	$lines = explode("\n", $text);
    	$text = '';
    	$count = 0;
    
    	foreach ($lines as $line)
    	{
    		$words = preg_split('/ +/', $line);
    		$width = 0;
    
    		foreach ($words as $word)
    		{
    			$wordwidth = $this->GetStringWidth($word);
    			if ($wordwidth > $maxwidth)
    			{
    				// Word is too long, we cut it
    				for($i=0; $i<strlen($word); $i++)
    				{
    					$wordwidth = $this->GetStringWidth(substr($word, $i, 1));
    					if($width + $wordwidth <= $maxwidth)
    					{
    						$width += $wordwidth;
    						$text .= substr($word, $i, 1);
    					}
    					else
    					{
    						$width = $wordwidth;
    						$text = rtrim($text)."\n".substr($word, $i, 1);
    						$count++;
    					}
    				}
    			}
    			elseif($width + $wordwidth <= $maxwidth)
    			{
    				$width += $wordwidth + $space;
    				$text .= $word.' ';
    			}
    			else
    			{
    				$width = $wordwidth + $space;
    				$text = rtrim($text)."\n".$word.' ';
    				$count++;
    			}
    		}
    		$text = rtrim($text)."\n";
    		$count++;
    	}
    	$text = rtrim($text);
    	return $count;
    }
} 

?>