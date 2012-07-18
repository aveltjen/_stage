<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
		//Functie laatst ingevoerd vordering ophalen.
		
		function GetLastInsert($werf,$id){
			global $db;
			
		$result = $db->query("SELECT * FROM v_vorderingen_werf_".$werf." WHERE IDuser='$id' ORDER BY `ID` DESC LIMIT 0,1");
		$lastvordering = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
		return $lastvordering;
		}
        
		//Functie inserten van document in DB.
		
		function addVordering($werf,$user,$msID,$vs,$datum,$omschrijving,$uitgevoerd,$periode){
			global $db;
			
		$db->query("INSERT INTO v_vorderingen_werf_".$werf." (ID, IDmeetstaat, IDuser, datum, omschrijving, uitgevoerd, periode) VALUES( 'NULL', '$msID', '$user', '$datum', '$omschrijving', '$uitgevoerd', '$periode')");
		}
		
		//Functie om user op te halen aan de hand van zijn groep ID
		function GetVorderingenByPost($msID,$werf){
			
            global $db;
            
			$result = $db->query("SELECT * FROM v_vorderingen_werf_".$werf." WHERE IDmeetstaat = '$msID' ORDER BY ID");
			
			return $result;
		}
		
		function GetVorderingByVid($vid,$werf){
			
            global $db;
			
			$result = $db->query("SELECT * FROM v_vorderingen_werf_".$werf." where ID = '$vid' ORDER BY ID");
			$vordering = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $vordering;
		}
		
				
		function GetAllVorderingenDatum($werf){
			
            global $db;
			
			$result = $db->query("SELECT DISTINCT DATE_FORMAT(datum,'%m-%Y') AS month_yy FROM v_vorderingen_werf_".$werf." ORDER BY datum ASC");
			
			return $result;
		}
		
		function GetAllVorderingenDatumByMsID($msID,$werf){
			
            global $db;
			
            $result = $db->query("SELECT DISTINCT DATE_FORMAT(datum, '%m-%Y') AS vorderingen_m_y FROM v_vorderingen_werf_".$werf." WHERE IDmeetstaat = '$msID' ORDER BY datum ASC");
			
			return $result;
		}
		
		function GetPostByPeriode($periode,$werf){
			
            global $db;
			
			$result = $db->query("SELECT DISTINCT IDmeetstaat FROM v_vorderingen_werf_".$werf." WHERE DATE_FORMAT(datum,'%m-%Y') = '$periode' ORDER BY IDmeetstaat");
			
			return $result;
		}
		
		function GetAllVorderingenByPeriode($msID,$parameter,$werf){
			
            global $db;
			
			$result = $db->query("SELECT * FROM v_vorderingen_werf_".$werf." WHERE DATE_FORMAT(datum,'%m-%Y') = '$parameter' AND IDmeetstaat = '$msID'");
			
			return $result;
		}
		
		
		
		function GetAllVorderingenByMsID($msID,$werf){
			
            global $db;
			
			$result = $db->query("SELECT * FROM v_vorderingen_werf_".$werf." WHERE IDmeetstaat = '$msID'");
			
			
			return $result;
		}
		
		function GetAllVorigeVorderingenByPeriode($msID,$parameter2,$werf){
			
            global $db;
			
			$result = $db->query("SELECT * FROM v_vorderingen_werf_".$werf." WHERE '$parameter2' > datum AND IDmeetstaat = '$msID'");
			//$vordering = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $result;
		}
		
		function GetAllVorderingenByVorigePeriode($parameter2,$werf){
			
            global $db;
			
			$result = $db->query("SELECT * FROM v_vorderingen_werf_".$werf." WHERE '$parameter2' > datum");
			//$vordering = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $result;
		}
		
		//delete gebruikt tabel, niet de view
		function deleteVordering($vid,$werf){
			global $db;
			
		$db->query("DELETE FROM vorderingen WHERE ID = '$vid'");
		}
		
		
		function UpdateVordering($vid,$datum_new,$omschrijving_new,$uitgevoerd_new,$periode_new,$werf){
			global $db;
			
		$db->query("UPDATE v_vorderingen_werf_".$werf." SET datum = '$datum_new', omschrijving = '$omschrijving_new', uitgevoerd = '$uitgevoerd_new', periode = '$periode_new' WHERE ID = '$vid'");

		}
		
		function GetVS($periode,$werf){
				
			global $db;
			global $periode;
				
			$result = $db->query("SELECT DISTINCT DATE_FORMAT(datum,'%m-%Y') AS month_yy FROM v_vorderingen_werf_".$werf." ORDER BY datum ASC");
			$i=0;
			while($row = $result->fetchrow(MDB2_FETCHMODE_ASSOC)){
				
				$maand = $row["month_yy"];
				
// 					echo "".$maand.": ".$periode."<br>";
					$i++;

					if($periode == $maand){
						return $i;
					}
				
			}
			
		}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>
