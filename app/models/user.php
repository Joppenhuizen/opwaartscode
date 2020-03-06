<?php

class user
{
	private $username;
	private $wachtwoord;
	private $rechten;
	private $userid;
	private $voornaam;
	private $achternaam;
	private $niewsbrief;
	private $hash;

	function set_user($username,$wachtwoord,$voornaam,$achternaam,$niewsbrief,$hash)
	{
		$this->username = $username;
		$this->wachtwoord = $wachtwoord;
		$this->voornaam = $voornaam;
		$this->achternaam = $achternaam;
		$this->nieuwsbrief = $niewsbrief;
		$this->hash = $hash;
	}
	function get_username()

	{
		return $this->username;
	}

	function get_wachtwoord()
	{
		return $this->wachtwoord;
	}

	function get_rechten()
	{
		return $this->rechten;
	}

	function get_userid()
	{
		return $this->userid;
	}
	function edit($user,$file)
	{
		$db = db::getInstance();
		$imageid='';
		if(isset($file['userpic']['name']) && $file['userpic']['name'] != '')
		{
	 		$fileName = $file['userpic']['name'];
	        $tmpName = $file['userpic']['tmp_name'];
	        $fileSize = $file['userpic']['size'];
	        $fileType = $file['userpic']['type'];

	        if($fileSize < 1000000)
	        {
		        
		        $ext = substr(strrchr($fileName, "."), 1); 

		        
		        $randName = md5(rand() * time());

		        
		        $filePath = 'images/user/' . $randName . '.' . $ext;
				$imgfilePath = '/images/user/' . $randName . '.' . $ext;
				$result = move_uploaded_file($tmpName, $filePath);
				$orig_image = imagecreatefromjpeg($filePath);
				$image_info = getimagesize($filePath); 
				$width_orig  = $image_info[0]; 
				$height_orig = $image_info[1]; 
				$width = 100; 
				$height = 100; 
				$destination_image = imagecreatetruecolor($width, $height);
				imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
				
				imagejpeg($destination_image, $filePath, 100);

				if($_SESSION['user']['image_id'] == 1)
				{
					$query1="INSERT INTO `images` (`image_path`) 
							 VALUES (':path');";
					$query1 = $db->prepare($query1);
					$query1->execute([':path' => $imgfilePath]);
					$lastId = $db->lastInsertId();

					$query2="UPDATE gebruikers
					SET image_id= :lastid
					WHERE user_id= :userid";
					$query2 = $db->prepare($query2);
					$query2->execute([':lastid' => $lastId, ':userid' => $_SESSION['user']["user_id"]]);
					$imageid = $lastId;
				}
				else
				{
					var_dump($_SESSION['user'][8]);
					$query1="UPDATE images
					SET image_path= ':path'
					WHERE image_id=:image_id";
					$query1 = $db->prepare($query1);
					$query1->execute([':path' => $imgfilePath, ':image_id' => $_SESSION['user']['image_id']]);
					$imageid = $_SESSION['user']['image_id'];
				}
			}	
		}

		$query="UPDATE gebruikers
				SET email=:email,voornaam=:voornaam,achternaam=:achternaam,bankrekening=:iban,nieuwsbrief=:nieuwsbrief
				WHERE user_id=:userid";

		$query = $db->prepare($query);
		if(!isset($user['nieuwsbrief']))
		{
			$user['nieuwsbrief'] = 0;
		}
		$result = $query->execute(array(':email' => $user['username'],':voornaam' => $user['voornaam'],':achternaam' => $user['achternaam'],':iban' => $user['iban'],':nieuwsbrief' => $user['nieuwsbrief'], ':userid' => $_SESSION['user']["user_id"] ));
		if($result)
		{
			$_SESSION['user']['email'] = $user['username'];
			$_SESSION['user']['voornaam'] = $user['voornaam'];
			$_SESSION['user']['achternaam'] = $user['achternaam'];
			$_SESSION['user']['bankrekening'] = $user['iban'];
			$_SESSION['user']['nieuwsbrief'] = $user['nieuwsbrief'];
			if(isset($file['userpic']['name']) && $file['userpic']['name'] != '')
			{
				$_SESSION['user']['image_path'] = $imgfilePath;
				$_SESSION['user']['image_id'] = $imageid;
			}
		}

		return $result;
	}
	function findusers()
	{
		$query="SELECT * FROM `gebruikers`";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();

		return $result;
	}
	function emailver($userid, $hash)
	{
		$query="SELECT * FROM `gebruikers` WHERE user_id = ':userid' && hash = ':hash'";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute([':userid' => $userid, ':hash' => $hash]);
		$result = $query->fetchAll();
		if($query->rowCount() > 0)
		{
			$ver = "UPDATE gebruikers
					SET wachtwoord = 1
					WHERE user_id = ':userid'";
			$ver = $db->prepare($ver);
			if($ver->execute([':userid' => $userid]))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	function changepass($nieuwpass)
	{
			$options = [
	    	'cost' => 12,
			];
			$db = db::getInstance();
			$hash = password_hash($nieuwpass, PASSWORD_BCRYPT, $options);

			$query="UPDATE gebruikers
					SET wachtwoord = ':hash'
					 WHERE user_id = :userid";

			$query = $db->prepare($query);
			return $query->execute([':hash' => $hash, ':userid' => $_SESSION['user']['user_id']]);
	}
	function authenticatie()
	{
		$query="SELECT * FROM `gebruikers` INNER JOIN `rechten` ON gebruikers.rechten_id = rechten.rechten_id INNER JOIN images ON gebruikers.image_id = images.image_id WHERE email = ':username'";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute([':username' => $this->username]);
		$result = $query->fetchAll();
		if(isset($result[0]['wachtwoord']) && password_verify($this->wachtwoord, $result[0]['wachtwoord']))
		{
			if($result[0]['vertificatie'] == 1)
			{	
				$this->username = $result[0]['email'];
				$this->wachtwoord = $result[0]['wachtwoord'];
				$this->rechten = $result[0]['rechten_id'];
				$this->userid = $result[0]['user_id'];
				$_SESSION['user'] = $result[0];

				if($result[0]['rechten_id'] == 3)
				{
					$ont="SELECT *
					FROM ontwikkelaars 
					INNER JOIN ontaccounts ON ontwikkelaars.ontwikkelaar_id = ontaccounts.ontwikkelaar_id
				    WHERE ontaccounts.user_id = :userid";
				
					$ont = $db->prepare($ont);
					$ont->execute([':userid' => $this->userid]);
					$ont = $ont->fetchAll();
					$_SESSION['ont'] = $ont[0];
				}
				return 'ver=0'; //inloggen
			}
			else
			{
				return 'ver=1'; //email verify
			}
		}
		else
		{
			return 'ver=2'; //niet geldige login
		}
	}

	function registreren()
	{



		$query="SELECT * FROM `gebruikers` INNER JOIN `rechten` ON gebruikers.rechten_id = rechten.rechten_id WHERE email = ':username'";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute([':username' => $this->username]);
		$result = $query->fetchAll();
		if($query->rowCount() > 0)
		{
			return false;
		}
		else
		{
			$options = [
	    	'cost' => 12,
			];

			$hash = password_hash($this->wachtwoord, PASSWORD_BCRYPT, $options);

			$query="INSERT INTO `gebruikers` (`user_id`, `email`, `voornaam`, `achternaam`, `balans`, `wachtwoord`, `rechten_id`, `bankrekening`, `image_id`, `nieuwsbrief`) 
			VALUES (NULL, ':username', ':voornaam', ':achternaam', '0', ':hash', '2', '', '1', ':nieuwsbrief');";

			$query = $db->prepare($query);
			$query->execute([':username' => $this->username, ':voornaam' => $this->voornaam, ':achternaam' => $this->achternaam, ':hash' => $hash , ':nieuwsbrief' => $this->nieuwsbrief]);
			$this->userid = $db->lastInsertId();
			return true;
		}
	}
	function sendmail()
	{
		$to = $this->username;
		$subject = "Registratie Opwaarts";

		$message = "
		<html>
		<head>
		<title>Registratie Opwaarts</title>
		</head>
		<body>
		<p>Bedankt voor het registreren op opwaarts.nl</p>
		<table>
		<tr>
		<td>Voornaam:</td>
		<td>".$this->voornaam."</td>
		</tr>
		<tr>
		<td>Achternaam:</td>
		<td>".$this->achternaam."</td>
		</tr>
		<tr>
			<td>Klik hier om een account te verifiëren:</td>
			<td><a href='http://".$_SERVER['HTTP_HOST']."/registreren/verifieren/".$this->userid."/".$this->hash."'>Verifiëren</td>
		</tr>
		</table>
		</body>
		</html>
		";

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= 'From: <noreply@opwaarts.nl>' . "\r\n";

		mail($to,$subject,$message,$headers);
	}
	function uitloggen()
	{
		session_destroy();
	}
	function checkIBAN($iban)
	{
		if($iban != '')
		{
		    $iban = strtolower(str_replace(' ','',$iban));
		    $Countries = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
		    $Chars = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

		   if(array_key_exists(substr($iban,0,2), $Countries) && strlen($iban) == $Countries[substr($iban,0,2)]){

		        $MovedChar = substr($iban, 4).substr($iban,0,4);
		        $MovedCharArray = str_split($MovedChar);
		        $NewString = "";

		        foreach($MovedCharArray AS $key => $value){
		            if(!is_numeric($MovedCharArray[$key])){
		                $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
		            }
		            $NewString .= $MovedCharArray[$key];
		        }

		        if(bcmod($NewString, '97') == 1)
		        {
		            return TRUE;
		        }
		        else{
		            return FALSE;
		        }
		    }
		    else{
		        return FALSE;
		    }  
	    } 
	    else
	    {
	    	return true;
	    }
	}
}

?>