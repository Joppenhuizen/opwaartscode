<?php

class project
{
	private $projectid;
	private $pnaam;
	private $plocatie;
	private $pomschrijving;
	private $pdoelbedrag;
	private $pstart;
	private $peind;
	private $pvanaf;
	private $ptot;
	private $ontwikkelaar;
	private $images;
	private $rendement;
	private $prisico;
	private $pltv;
	private $type;
	private $tonen;
	private $content;
	private $plabel;
	private $pstatus;

	function set_projectid($projectid)
	{
		$this->projectid = $projectid;
	}

	function set_all($postarray,$filearray)
	{
		$this->pnaam = $postarray['pnaam'];
		$this->plocatie = $postarray['plocatie'];
		$this->pomschrijving = $postarray['pomschrijving'];
		$this->pdoelbedrag = $postarray['pdoelbedrag'];
		$this->pstart = $postarray['pstart'];
		$this->peind = $postarray['peind'];
		$this->pvanaf = $postarray['pvanaf'];
		$this->ptot = $postarray['ptot'];
		$this->ontwikkelaar = $postarray['ontwikkelaar'];
		$this->rendement = $postarray['prendement'];
		$this->prisico = $postarray['prisico'];
		$this->pltv = $postarray['pltv'];
		$this->plabel = $postarray['plabel'];
		$this->type = $postarray['types'];
		$this->content = $postarray['content'];
		$this->pstatus = $postarray['status'];
		if(isset($postarray['tonen'])){$this->tonen = 1;}
		else{$this->tonen = 0;}
		$this->images = $filearray;

	}
	function findprotype()
	{	
		$query="SELECT project_types.type_id FROM project_types INNER JOIN types ON project_types.type_id = types.type_id  WHERE project_types.project_id = ".$this->projectid;;

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$types = $query->fetchAll(PDO::FETCH_ASSOC);
		$newarray = array();
		for($i = 0;$i < count($types); $i++)
		{
			$newarray[$i] = $types[$i]['type_id'];
		}

		return $newarray;
	}
	function getdocs()
	{
		$query="SELECT * FROM documenten INNER JOIN projecten ON documenten.project_id = projecten.project_id  WHERE documenten.project_id =".$this->projectid;

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$docs = $query->fetchAll(PDO::FETCH_ASSOC);

		return $docs;
	}
	function removedoc($project,$docid)
	{
		$db = db::getInstance();


		$query2="SELECT file_path from documenten where doc_id=:docid && project_id=:project";
		
		$query2 = $db->prepare($query2);
		$query2->execute(array(':docid' => $docid,'project' => $project));
		$path = $query2->fetchAll();

	    $query1="DELETE FROM documenten
				 WHERE doc_id=:docid && project_id=:project";
		
		$query1 = $db->prepare($query1);


		if($query1->execute(array(':docid' => $docid,'project' => $project)))
		{
			if (file_exists('../public'.$path[0]['file_path'])) 
			{
				 unlink($path[0]['file_path']);
				 return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	function downloaddoc($id = '')
	{
		$query="SELECT file_path FROM `documenten`
		WHERE doc_id = ".$id;

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();

		return $result;
	}
	function gettopcomments()
	{
		$query="SELECT * FROM comments INNER JOIN gebruikers ON comments.user_id = gebruikers.user_id INNER JOIN images ON gebruikers.image_id = images.image_id WHERE comments.project_id =".$this->projectid." LIMIT 10";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$comments = $query->fetchAll(PDO::FETCH_ASSOC);

		return $comments;
	}
	function getcomments()
	{
		$query="SELECT * FROM comments INNER JOIN gebruikers ON comments.user_id = gebruikers.user_id INNER JOIN images ON gebruikers.image_id = images.image_id WHERE comments.project_id =".$this->projectid;

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$comments = $query->fetchAll(PDO::FETCH_ASSOC);

		return $comments;
	}
	function removeimg($project,$imageid)
	{
		$db = db::getInstance();

	    $query1="DELETE FROM project_image
				 WHERE image_id=:imageid";
		

		$query2="DELETE FROM images
				 WHERE image_id=:imageid";

		$query1 = $db->prepare($query1);
		$query2 = $db->prepare($query2);

		if($query1->execute(array(':imageid' => $imageid)))
		{
			if($query2->execute(array(':imageid' => $imageid)))
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
			return false;
		}
	}
	function getprobytype($type)
	{
		$query="SELECT *
				FROM project_types 
				INNER JOIN projecten ON projecten.project_id = project_types.project_id 
				INNER JOIN types ON project_types.type_id = types.type_id
				INNER JOIN images ON projecten.image_id = images.image_id 
				INNER JOIN ontwikkelaars ON projecten.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id 
				INNER JOIN status ON projecten.status_id = status.status_id
				WHERE projecten.tonen = 1 && project_types.type_id=".$type;
		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$status = $query->fetchAll(PDO::FETCH_ASSOC);

		return $status;
	}
	function showall($rechten = '', $userid = '')
	{
		$query = '';
		$db = db::getInstance();
		$userquery = '&& projecten.tonen = 1';
		if($rechten == 1){
			$query="SELECT *
			FROM projecten 
			INNER JOIN project_types ON projecten.project_id = project_types.project_id 
			INNER JOIN types ON project_types.type_id = types.type_id
			INNER JOIN images ON projecten.image_id = images.image_id 
			INNER JOIN ontwikkelaars ON projecten.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id 
			INNER JOIN status ON projecten.status_id = status.status_id";
		}
		else if($rechten == 3 && isset($_SESSION['ont'])){

			$query="SELECT *
			FROM projecten 
			INNER JOIN project_types ON projecten.project_id = project_types.project_id 
			INNER JOIN types ON project_types.type_id = types.type_id
			INNER JOIN images ON projecten.image_id = images.image_id 
			INNER JOIN ontwikkelaars ON projecten.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id 
			INNER JOIN status ON projecten.status_id = status.status_id
		    WHERE projecten.ontwikkelaar_id = ".$_SESSION['ont']['ontwikkelaar_id'];
		}
		else{
			$query="SELECT *
			FROM projecten 
			INNER JOIN project_types ON projecten.project_id = project_types.project_id 
			INNER JOIN types ON project_types.type_id = types.type_id
			INNER JOIN images ON projecten.image_id = images.image_id 
			INNER JOIN ontwikkelaars ON projecten.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id 
			INNER JOIN status ON projecten.status_id = status.status_id
		    WHERE projecten.tonen = 1";
		}

		
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();

		return $result;
	}
	function findstatus()
	{
		$query="SELECT * FROM status";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$status = $query->fetchAll(PDO::FETCH_ASSOC);

		return $status;
	}
	function showproject()
	{
		$query="SELECT *, ontwikkelaars.image_id AS 'ontwikkelaars.image_id' FROM projecten 
				INNER JOIN kadaster ON projecten.kadaster_id = kadaster.kadaster_id 
				INNER JOIN ontwikkelaars ON projecten.ontwikkelaar_id = ontwikkelaars.ontwikkelaar_id 
				INNER JOIN project_types ON projecten.project_id = project_types.project_id 
				INNER JOIN types ON project_types.type_id = types.type_id
				INNER JOIN images ON images.image_id = projecten.image_id
				INNER JOIN status ON projecten.status_id = status.status_id
				WHERE projecten.project_id =".$this->projectid;



		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$type="SELECT types.type_naam,project_types.type_id FROM project_types 
				INNER JOIN projecten ON projecten.project_id = project_types.project_id 
				INNER JOIN types ON project_types.type_id = types.type_id
				WHERE project_types.project_id = ".$this->projectid;
		$type = $db->prepare($type);
		$type->execute();
		$types = $type->fetchAll(PDO::FETCH_ASSOC);
		$project = $query->fetchAll(PDO::FETCH_ASSOC);
		//print_r($project);
		$devimg="SELECT images.image_path 
			     FROM ontwikkelaars 
			     INNER JOIN images ON ontwikkelaars.image_id = images.image_id 
			     WHERE ontwikkelaars.ontwikkelaar_id =".$project[0]['ontwikkelaar_id'];
		$query="SELECT image_path,images.image_id 
			     FROM images 
			     INNER JOIN project_image ON images.image_id = project_image.image_id 
			     INNER JOIN projecten ON project_image.project_id = projecten.project_id 
			     WHERE projecten.project_id =".$this->projectid;
		$docs="SELECT * FROM documenten WHERE project_id=".$this->projectid;
		$query = $db->prepare($query);
		$query->execute();
		$devimg = $db->prepare($devimg);
		$devimg->execute();
		$devimgs = $devimg->fetchAll();
		$docs = $db->prepare($docs);
		$docs->execute();
		$docs = $docs->fetchAll();
		$allimages = $query->fetchAll();
		$images = [];
		foreach ($allimages as $image)
			{
				array_push($images, $image);
			}
		
		$projectimages = array (
				'project' => $project,
				'images' => $images,
				'devlogo' => $devimgs,
				'docs' => $docs,
				'types' => $types
			);
		return $projectimages;
	}
	function showtop()
	{
		$query="SELECT * FROM projecten 
		INNER JOIN images ON images.image_id = projecten.image_id
		WHERE projecten.tonen = 1 ORDER BY projecten.project_id DESC LIMIT 3";



		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$project = $query->fetchAll(PDO::FETCH_ASSOC);

		return $project;
	}

	function findtypes()
	{
		$query="SELECT * FROM types";



		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$types = $query->fetchAll(PDO::FETCH_ASSOC);

		return $types;
	}
	function editproject($data)
	{

		$projectid = $this->projectid;



		$db = db::getInstance();

	
 			$j = 0; //Variable for indexing uploaded image 
		 	$imageids = [];
		 	$validatie = [];
		 	$thumbnailid = '';
		 	$db = db::getInstance();
		    for ($i = 0; $i < count($this->images['images']['name']); $i++) {//loop to get individual element from the array
				$target_path = "images/"; //Declaring Path for uploaded images
		        $validextensions = array("jpeg", "jpg", "png","gif");  //Extensions which are allowed
		        $ext = explode('.', basename($this->images['images']['name'][$i]));//explode file name from dot(.) 
		        $file_extension = end($ext); //store extensions in the variable
		  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image
		        $j = $j + 1;//increment the number of uploaded images according to the files in array       
		      
		   	if (($this->images["images"]["size"][$i] < 100000000) //bestands grote
		                && in_array($file_extension, $validextensions)) {
		            if (move_uploaded_file($this->images['images']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
		            	
		            	$query="INSERT INTO `images` (image_path) VALUES ('/".$target_path."');";

						
						$query = $db->prepare($query);
						$query->execute();
						$lastId = $db->lastInsertId();
						array_push($imageids, $lastId);
						array_push($validatie, 1);
		            } else {//bestand niet gekopieert
		                array_push($validatie, 0);
		            }
		        } else {//bestand te groot
		            array_push($validatie, 0);
		        }
		    }

		    if (isset($this->images['thumbnail']['name']) && $this->images['thumbnail']['name'] != '' ) {
				$target_path = "images/";
		        $validextensions = array("jpeg", "jpg", "png","gif"); 
		        $ext = explode('.', basename($this->images['thumbnail']['name']));//explode file name from dot(.) 
		        $file_extension = end($ext); //store extensions in the variable
		  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image   
		   	if (($this->images["thumbnail"]["size"] < 100000000) //bestands grote
		                && in_array($file_extension, $validextensions)) {
		            if (move_uploaded_file($this->images['thumbnail']['tmp_name'], $target_path)) {//if file moved to uploads folder
		            	//var_dump($projectid);
		            	$imageid = "SELECT image_id FROM projecten WHERE project_id =".$projectid;
						$imageid = $db->prepare($imageid);
		            	$imageid->execute();
		            	$imageid = $imageid->fetchAll(PDO::FETCH_ASSOC);
		            	$query="UPDATE `images` SET image_path = '/".$target_path."' WHERE image_id = ".$imageid[0]['image_id'].";";
						
						$query = $db->prepare($query);
						$query->execute();
						$lastId = $db->lastInsertId();
						$thumbnailid = $lastId;
						array_push($validatie, 1);
		            } 
		            else {//bestand niet gekopieert
		            	echo 'bestand niet gekopieerd';
		                array_push($validatie, 0);
		            }
		        } 
		        else {//bestand te groot
		        	echo 'bestand te groot';
		            array_push($validatie, 0);
		        }
		    }
		    if(count(array_unique($validatie)) === 1)  
			{
						$query="UPDATE `projecten` SET 
									`project_naam`=:project_naam,
									`project_omschrijving`=:project_omschrijving,
									`project_locatie`=:project_locatie,
									`doelbedrag`=:doelbedrag,
									`start_datum`=:start_datum,
									`eind_datum`=:eind_datum,
									`inleg_vanaf`=:inleg_vanaf,
									`inleg_tot`=:inleg_tot,
									`risico_indicatie`=:risico_indicatie,
									`ltv`=:ltv,
									`duurzaamheidslabel`=:label ,
									`ontwikkelaar_id`=:ontwikkelaar_id,
									`content`=:content,
									`rendement`=:rendement,
									`tonen`=:tonen,
									`status_id`=:status_id"
									.($thumbnailid != '' ? ",`image_id`=".$thumbnailid."": '')."
									WHERE `project_id` = :projectid";
			$query = $db->prepare($query);
			$result = $query->execute(array(':project_naam' => $this->pnaam,':project_omschrijving' => $this->pomschrijving,':project_locatie' => $this->plocatie,':doelbedrag' => $this->pdoelbedrag,':start_datum' =>$this->pstart,':eind_datum' =>$this->peind,':inleg_vanaf' =>$this->pvanaf,':inleg_tot' =>$this->ptot,':risico_indicatie' =>$this->prisico ,':ltv' =>$this->pltv,':label' =>$this->plabel,':ontwikkelaar_id' =>$this->ontwikkelaar,':content' =>$this->content,':rendement' =>$this->rendement,':tonen' =>$this->tonen,':status_id' =>$this->pstatus,':projectid' =>$this->projectid));
			
 				$d = 0; //Variable for indexing uploaded docs 
			 	$docsids = [];
			 	$db = db::getInstance();
			    for ($i = 0; $i < count($this->images['docs']['name']); $i++) {//loop to get individual element from the array
					$target_path = "docs/"; //Declaring Path for uploaded images
			        $validextensions = array("jpeg", "jpg", "png","gif","pdf","doc","docx");  //Extensions which are allowed
			        $ext = explode('.', basename($this->images['docs']['name'][$i]));//explode file name from dot(.) 
			        $file_extension = end($ext); //store extensions in the variable
			  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image
			        $d = $d + 1;//increment the number of uploaded images according to the files in array       
			      
			   	if (($this->images["docs"]["size"][$i] < 100000000) //bestands grote
			                && in_array($file_extension, $validextensions)) {
			            if (move_uploaded_file($this->images['docs']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
			            	
			            	$query="INSERT INTO `documenten` (file_path, ext, project_id) VALUES ('/".$target_path."','".$ext[1]."',".$this->projectid.");";

							
							$query = $db->prepare($query);
							$query->execute();
							array_push($validatie, 1);
			            } else {//bestand niet gekopieert
			                array_push($validatie, 0);
			            }
			        } else {//bestand te groot
			            array_push($validatie, 0);
			        }
			    }
			//$projectid = $db->lastInsertId();
			   	$projecttypes = self::findprotype();
			   	$add = array_values(array_diff($this->type, $projecttypes));
			   	$remove = array_values(array_diff($projecttypes, $this->type));
			    for($i = 0;$i < count($add);$i++)
				{
					$query="INSERT INTO `project_types` (`project_id`,`type_id`) 
							VALUES (".$projectid.",".$add[$i].");";
					$query = $db->prepare($query);
					$query->execute();
				}
				for($i = 0;$i < count($remove);$i++)
				{
					$query="DELETE FROM project_types
							WHERE project_id=".$projectid." AND type_id=".$remove[$i].";";
					$query = $db->prepare($query);
					$query->execute();
				}
			foreach ($imageids as $imageid)
			{
				print_r($imageid);
				echo "<br>";
				$query="INSERT INTO `project_image` (`image_id`,`project_id`) 
						VALUES (".$imageid.", ".$this->projectid.");";

						
				$query = $db->prepare($query);
				$query->execute();
			}
				return true;
			}
			else{
				return false;
			}

	

	}
	function addproject()
	{


		    $j = 0; //Variable for indexing uploaded image 
		 	$imageids = [];
		 	$projectid = '';
		 	$validatie = [];
		 	$thumbnailid = '';
		 	$db = db::getInstance();
		    for ($i = 0; $i < count($this->images['images']['name']); $i++) {//loop to get individual element from the array
				$target_path = "images/"; //Declaring Path for uploaded images
		        $validextensions = array("jpeg", "jpg", "png","gif");  //Extensions which are allowed
		        $ext = explode('.', basename($this->images['images']['name'][$i]));//explode file name from dot(.) 
		        $file_extension = end($ext); //store extensions in the variable
		  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image
		        $j = $j + 1;//increment the number of uploaded images according to the files in array       
		      
		   	if (($this->images["images"]["size"][$i] < 100000000) //bestands grote
		                && in_array($file_extension, $validextensions)) {
		            if (move_uploaded_file($this->images['images']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
		            	
		            	$query="INSERT INTO `images` (image_path) VALUES ('/".$target_path."');";

						
						$query = $db->prepare($query);
						$query->execute();
						$lastId = $db->lastInsertId();
						array_push($imageids, $lastId);
						array_push($validatie, 1);
		            } else {//bestand niet gekopieert
		                array_push($validatie, 0);
		            }
		        } else {//bestand te groot
		            array_push($validatie, 0);
		        }
		    }

		    if (isset($this->images['thumbnail']['name'])) {
				$target_path = "images/";
		        $validextensions = array("jpeg", "jpg", "png","gif"); 
		        $ext = explode('.', basename($this->images['thumbnail']['name']));//explode file name from dot(.) 
		        $file_extension = end($ext); //store extensions in the variable
		  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image   
		   	if (($this->images["thumbnail"]["size"] < 100000000) //bestands grote
		                && in_array($file_extension, $validextensions)) {
		            if (move_uploaded_file($this->images['thumbnail']['tmp_name'], $target_path)) {//if file moved to uploads folder
		            	
		            	$query="INSERT INTO `images` (image_path) VALUES ('/".$target_path."');";
						
						$query = $db->prepare($query);
						$query->execute();
						$lastId = $db->lastInsertId();
						$thumbnailid = $lastId;
						array_push($validatie, 1);
		            } else {//bestand niet gekopieert
		            	echo 'bestand niet gekopieerd';
		                array_push($validatie, 0);
		            }
		        } else {//bestand te groot
		        	echo 'bestand te groot';
		            array_push($validatie, 0);
		        }
		    }
		    if(count(array_unique($validatie)) === 1)  
			{
				$query="INSERT INTO `projecten` (`project_naam`,`project_omschrijving`,`project_locatie`,`doelbedrag`,`start_datum`,`eind_datum`,`inleg_vanaf`,`inleg_tot`,`ontwikkelaar_id`,`image_id`,`kadaster_id`,`tonen`,`rendement`,`risico_indicatie`,`ltv`,`duurzaamheidslabel`,`content`) 
						VALUES ('".$this->pnaam."','".$this->pomschrijving."','".$this->plocatie."','".$this->pdoelbedrag."','".$this->pstart."','".$this->peind."',
								'".$this->pvanaf."','".$this->ptot."','".$this->ontwikkelaar."','".$thumbnailid."','1','".$this->tonen."','".$this->rendement."',
								'".$this->prisico."','".$this->pltv."','".$this->plabel."','".$this->content."');";
				//var_dump($this->ontwikkelaar);
				$query = $db->prepare($query);
				$query->execute();
				$projectid = $db->lastInsertId();
				

				foreach($this->type as $type)
				{
					$query="INSERT INTO `project_types` (`project_id`,`type_id`) 
							VALUES (".$projectid.",".$type.");";
					$query = $db->prepare($query);
					$query->execute();
				}

			    $d = 0; //Variable for indexing uploaded docs 
			 	$docsids = [];
			    for ($i = 0; $i < count($this->images['docs']['name']); $i++) {//loop to get individual element from the array
					$target_path = "docs/"; //Declaring Path for uploaded images
			        $validextensions = array("jpeg", "jpg", "png","gif","pdf","doc","docx");  //Extensions which are allowed
			        $ext = explode('.', basename($this->images['docs']['name'][$i]));//explode file name from dot(.) 
			        $file_extension = end($ext); //store extensions in the variable
			  		$target_path = $target_path . $ext[0] . "." . $ext[count($ext) - 1];//set the target path with a new name of image
			        $d = $d + 1;//increment the number of uploaded images according to the files in array       
			      
			   	if (($this->images["docs"]["size"][$i] < 100000000) //bestands grote
			                && in_array($file_extension, $validextensions)) {
			            if (move_uploaded_file($this->images['docs']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
			            	
			            	$query="INSERT INTO `documenten` (file_path, ext, project_id) VALUES ('/".$target_path."','".$ext[1]."',".$projectid.");";

							
							$query = $db->prepare($query);
							$query->execute();
							array_push($validatie, 1);
			            } else {//bestand niet gekopieert
			                array_push($validatie, 0);
			            }
			        } else {//bestand te groot
			            array_push($validatie, 0);
			        }
			    }


			foreach ($imageids as $imageid)
			{
				$query="INSERT INTO `project_image` (`image_id`,`project_id`) 
						VALUES (".$imageid.", ".$projectid.");";

						
				$query = $db->prepare($query);
				$query->execute();
			}
				return true;
			}
			else{
				return false;
			}

		


	}
}

?>