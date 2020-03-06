<?php

class ontwikkelaar
{

	private $ontwikkelaarid;
	private $devomschrijving;
	private $devkvk;
	private $devlocatie;
	private $devnaam;
	private $devlogo;
	private $wachtwoord;
	private $email;


	function setontwikkelaar($ontwikkelaar,$logo)
	{
		if(isset($ontwikkelaar['ontwikkelaarid']))
		{$this->ontwikkelaarid = $ontwikkelaar['ontwikkelaarid'];}
		$this->devomschrijving = $ontwikkelaar['devomschrijving'];
		$this->devkvk = $ontwikkelaar['devkvk'];
		$this->devlocatie = $ontwikkelaar['devlocatie'];
		$this->devnaam = $ontwikkelaar['devnaam'];
		$this->devlogo = $logo['logo'];
		$this->wachtwoord = $ontwikkelaar['wachtwoord'];
		$this->email = $ontwikkelaar['email'];
	}

	function setontid($id)
	{
		$this->ontwikkelaarid = $id;
	}

	function findontwikkelaar()
	{
		$query="SELECT * FROM ontwikkelaars 
		INNER JOIN images ON ontwikkelaars.image_id = images.image_id 
		INNER JOIN ontaccounts ON ontaccounts.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id
		INNER JOIN gebruikers ON ontaccounts.user_id = gebruikers.user_id 
		WHERE ontwikkelaars.ontwikkelaar_id = :id";
		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute([':id' => $this->ontwikkelaarid]);
		$ontwikkelaars = $query->fetchAll(PDO::FETCH_ASSOC);

		return $ontwikkelaars;
	}

	function findall($rechten = '')
	{
		if($rechten = 3 && isset($_SESSION['ont']['ontwikkelaar_id']))
		{
			$query="SELECT * FROM ontwikkelaars 
			INNER JOIN images ON ontwikkelaars.image_id = images.image_id
			INNER JOIN ontaccounts ON ontaccounts.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id
			INNER JOIN gebruikers ON ontaccounts.user_id = gebruikers.user_id 
			WHERE ontwikkelaars.ontwikkelaar_id =".$_SESSION['ont']['ontwikkelaar_id'];
		}
		else
		{
			$query="SELECT * FROM ontwikkelaars 
			INNER JOIN images ON ontwikkelaars.image_id = images.image_id
			INNER JOIN ontaccounts ON ontaccounts.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id
			INNER JOIN gebruikers ON ontaccounts.user_id = gebruikers.user_id";
		}
		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$ontwikkelaars = $query->fetchAll();

		return $ontwikkelaars;
	}
	function editontwikkelaar($ontwikkelaar,$thumb)
	{
		$db = db::getInstance();
			$ver = false;

			if (isset($thumb['logo']['name'])) {
				$target_path = "images/";
				
				$db = db::getInstance();
		        $validextensions = array("jpeg", "jpg", "png","gif"); 
		        $ext = explode('.', basename($thumb['logo']['name']));//explode file name from dot(.) 
		        $file_extension = end($ext); //store extensions in the variable
		  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image   
		   	if (($thumb['logo']["size"] < 10000000) //bestands grote
		                && in_array($file_extension, $validextensions)) {
		            if (move_uploaded_file($thumb['logo']['tmp_name'], $target_path)) {//if file moved to uploads folder

		            	$query="SELECT image_id FROM ontwikkelaars WHERE ontwikkelaar_id = :id";
						$query = $db->prepare($query);
						$query->execute([':id' => $this->ontwikkelaarid]);
						$imageid = $query->fetchAll(PDO::FETCH_ASSOC);
		            	$query="UPDATE `images` SET image_path='/:path' WHERE image_id = :imageid;";
						$query = $db->prepare($query);
						$query->execute([':path' => $target_path, ':imageid' => $imageid[0]['image_id']]);
						$ver = true;
		            } else {//bestand niet gekopieert
		            	echo 'bestand niet gekopieerd';
		            }
		        } else {//bestand te groot
		        	echo 'bestand te groot';
		        }
		    }

				$query="SELECT gebruikers.user_id FROM gebruikers 
						INNER JOIN ontaccounts ON ontaccounts.user_id = gebruikers.user_id
						INNER JOIN ontwikkelaars ON ontwikkelaars.ontwikkelaar_id = ontaccounts.ontwikkelaar_id
						WHERE gebruikers.email =':email'";
				$query = $db->prepare($query);
				$query->execute([':email' => $ontwikkelaar['email']]);
				$userid = $query->fetchAll(PDO::FETCH_ASSOC);

				$query1="UPDATE `gebruikers` SET 
				email=':email' WHERE user_id = :userid;";
				$query1 = $db->prepare($query1);
				$query1->execute([':email' => $ontwikkelaar['email'],':userid' => $userid[0]['user_id']]);

			    $query2="UPDATE `ontwikkelaars` SET 
				naam=':naam',
				plaats=':plaats',
				kvk=':kvk',
				omschrijving=':omschrijving'
				 WHERE ontwikkelaar_id = :id;";

				$query2 = $db->prepare($query2);
			    $query2->execute([':naam' => $ontwikkelaar['devnaam'], ':plaats' => $ontwikkelaar['devlocatie'], ':kvk' => $ontwikkelaar['devkvk'], ':omschrijving' => $ontwikkelaar['devomschrijving'], ':id' => $this->ontwikkelaarid]); 

			    return true;  
	}

	function adddev()
	{
		$db = db::getInstance();
			$ver = false;
			if (isset($this->devlogo['name'])) {
				$target_path = "images/";
				
				
		        $validextensions = array("jpeg", "jpg", "png","gif"); 
		        $ext = explode('.', basename($this->devlogo['name']));//explode file name from dot(.) 
		        $file_extension = end($ext); //store extensions in the variable
		  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image   
		   	if (($this->devlogo["size"] < 10000000) //bestands grote
		                && in_array($file_extension, $validextensions)) {
		            if (move_uploaded_file($this->devlogo['tmp_name'], $target_path)) {//if file moved to uploads folder
		            	
		            	$query="INSERT INTO `images` (image_path) VALUES ('/:path');";
						
						$query = $db->prepare($query);
						$query->execute([':path'=>$target_path]);
						$lastId = $db->lastInsertId();
						$thumbnailid = $lastId;
						$ver = true;
		            } else {//bestand niet gekopieert
		            	echo 'bestand niet gekopieerd';
		            }
		        } else {//bestand te groot
		        	echo 'bestand te groot';
		        }
		    }
		    if($ver == true)
		    {
		    	$options = [
		    	'cost' => 12,
				];

				$hash = password_hash($this->wachtwoord, PASSWORD_BCRYPT, $options);

				$query2="INSERT INTO `gebruikers` (`email`, `voornaam`, `achternaam`, `balans`, `wachtwoord`, `rechten_id`, `bankrekening`, `image_id`, `nieuwsbrief`,`vertificatie`) 
				VALUES (':email', ':devnaam', '', '0', '".$hash."', '3', '', ".(isset($lastid)?$lastid:'1').", '0','1');";
				$query2 = $db->prepare($query2);

			    $query="INSERT INTO `ontwikkelaars`(`naam`, `plaats`, `kvk`, `omschrijving`, `image_id`) 
			    		VALUES (':naam',':devlocatie',':devkvk',':devomschrijving',:thumbnailid)";
				$query = $db->prepare($query);
			    
				if($query->execute([':naam' => $this->devnaam, ':devlocatie' => $this->devlocatie, ':devkvk' => $this->devkvk, ':devomschrijving' => $this->devomschrijving, ':thumbnailid' => $this->thumbnailid]))
				{
					$ontid = $db->lastInsertId();
					if($query2->execute([':email' => $this->email, ':devnaam' => $this->devnaam]))
					{
						$userid = $db->lastInsertId();
						$query3="INSERT INTO `ontaccounts` (`user_id`, `ontwikkelaar_id`) 
						VALUES (':userid', ':ontid');";
						$query3 = $db->prepare($query3);
						if($query3->execute([':userid' => $userid, ':ontid' => $ontid]))
						{
							return true;
						}
					}
				}
				else{return false;}
			}
			else
			{
				return false;
			}
	}
}

?>