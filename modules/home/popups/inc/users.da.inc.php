<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("db.inc.php");
		
        //Functie om alle users op te halen uit de database.
		function GetAllUsers(){
			global $db;
			
			$usersLijst = $db->query("SELECT * FROM users ORDER BY Naam");

			return $usersLijst;
		}
		
		//Functie om user op te halen aan de hand van zijn ID
		function GetUserById($id){ //GetUser niet users
			
            global $db;
			
			$result = $db->query("SELECT * FROM users where ID = '$id'");
			$user = $result->fetchrow(DB_FETCHMODE_ASSOC);
			return $user;

		}
		
		//Functie om user op te halen aan de hand van zijn groep ID
		function GetUsersByGroupId($id){
			
            global $db;
			
			$result = $db->query("SELECT * FROM users where GroupID = '$id' AND Actief = 1 ORDER BY Naam ");
			//$user = $result->fetchrow(DB_FETCHMODE_ASSOC);
			//return $user;
			return $result;

		}
		
		//Functie om de groep ID op te halen aan de hand van zijn ID
		function GetGroupIdByUsersId($id){
			
            global $db;
			
			$result = $db->query("SELECT GroupID FROM users where ID = '$id'");
			$user = $result->fetchrow(DB_FETCHMODE_ASSOC);
			return $user["GroupID"];

		}
		
		//Functie om studenten 3de jaar van een bepaalde docent op te halen aan de hand van zijn ID
		function GetUserByDocentId($id){
			
            global $db;
			
			$result = $db->query("SELECT * FROM toewijzingD where UsersIDd = '$id'");
			
			return $result;

		}
		
		//Funtie Authentication van de user)
		function AuthenticateUser($username,$password){
			
            global $db;
            
			$result = $db->query("SELECT * FROM users where Username = '$username' AND Password = '$password'");
			$row = $result->fetchrow(DB_FETCHMODE_ASSOC);
			
			$num = $result->numRows();
			
				if($num == 1){
					return $row;
				}else{
					return null;	
				}
	
		}
		//Identification van de user aan de hand van gebruikersnaam en wachtwoord
		function IdentifyUser($gebruikersnaam,$wachtwoord){
			
            global $db;
            
			$result = $db->query("SELECT * FROM users where Gebruikersnaam = '$gebruikersnaam' AND Wachtwoord = '$wachtwoord'");
			$row = $result->fetchrow(DB_FETCHMODE_ASSOC);
			
			$id = $row['ID'];
			
			return $id;
			
	
		}
		
		function CheckIfUsernameIsAvailable($Gebruikersnaam){
			
            global $db;
            
			$result = $db->query("SELECT * FROM users where Gebruikersnaam = '$Gebruikersnaam'");
			$row = $result->fetchrow(DB_FETCHMODE_ASSOC);
			
			$num = $result->numRows();
			
				if($num == 1){
					return false;
				}else{
					return true;	
				}
		}
		
		//Functie registratie van een User.
		//GroupID = 0 (geregistreerde bezoeker die nog niet actief is krijgt groepID '0')
		function RegisterUser($Gebruikersnaam, $Wachtwoord, $Naam, $Voornaam, $GroupID, $Adres, $Postcode, $Plaats, $Land, $Website, $Email, $MobieleTelefoon, $Telefoon, $Pic, $Info, $Cv, $Created){
			global $db;
			
		$db->query("INSERT INTO users (Gebruikersnaam ,Wachtwoord, Naam, Voornaam, GroupID ,Adres ,Postcode ,Plaats ,Land ,Website ,Email, MobieleTelefoon ,Telefoon ,Pic,Info,Cv,Created,Actief) VALUES( '$Gebruikersnaam', '$Wachtwoord', '$Naam', '$Voornaam', '$GroupID', '$Adres', '$Postcode', '$Plaats', '$Land', '$Website', '$Email', '$MobieleTelefoon', '$Telefoon', '$Pic', '$Info', '$Cv','$Created',false)");
		}
		
		//Functie geregistreerde user activeren aan de hand van zijn ID.
		function ActivateRegisteredUser($id){
			global $db;
			
		$db->query("UPDATE users SET Actief = true where ID = '$id'");

		}
		
		//Functie niet actieve users op halen
		function GetNonActiveUsers(){
			global $db;
			
			$result = $db->query("SELECT * FROM users WHERE Actief = false ORDER BY GroupID, Naam, Voornaam");
			
			return $result;
		}
		
		//Functie userprofiel wijzigen aan de hand van zijn ID.
		function UpdateUserProfile($id, $Naam, $Voornaam, $Geboortedatum, $Adres, $Postcode, $Plaats, $Land, $Website, $Email, $MobieleTelefoon, $Telefoon, $Pic, $Info, $Cv){
			global $db;
			
		$db->query("UPDATE users SET Naam='$Naam',Voornaam='$Voornaam',Geboortedatum='$Geboortedatum',Adres='$Adres',Postcode='$Postcode',Plaats ='$Plaats',Land='$Land',Website='$Website',Email='$Email',MobieleTelefoon='$MobieleTelefoon',Telefoon='$Telefoon',Pic='$Pic',Info='$Info',Cv='$Cv' WHERE ID=$id");

		}
		
		//Functie user verwijderen aan de hand van zijn ID.
		function DeleteUser($id){
			global $db;
			
			$db->query("DELETE FROM `users` WHERE `users`.`ID` = $id");

		}
		
		//Search Companies
		function SearchContacts($name, $GroupID){
			 global $db;
            
			$contactenLijst = $db->query("SELECT * FROM users WHERE GroupID LIKE '" . $GroupID . "%' AND Naam LIKE '%" . $name ."%' AND Actief = true");
			
			$num = $contactenLijst->numRows();
			if($num >= 1){
				return $contactenLijst;
			}else{
				return false;	
			}	
			
		}
		
		//
		function GetGroupNameByGroupID($groupID){
			global $db;		
			
			$result = $db->query("SELECT * FROM `group` WHERE ID = $groupID");
			
			$row = $result->fetchrow(DB_FETCHMODE_ASSOC);
			
			return $row["Naam"];
		}
		
		//
		function GetNameByID($id){
			global $db;		
			
			$result = $db->query("SELECT * FROM `users` WHERE ID = $id");
			
			$row = $result->fetchrow(DB_FETCHMODE_ASSOC);
			
			return $row["Naam"];
		}
		
		function GetSurnameByID($id){
			global $db;		
			
			$result = $db->query("SELECT * FROM `users` WHERE ID = $id");
			
			$row = $result->fetchrow(DB_FETCHMODE_ASSOC);
			
			return $row["Voornaam"];
		}
		
		
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>