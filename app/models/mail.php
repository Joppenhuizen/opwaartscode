<?php

class mail
{

	private $ontvangers = [];
	private $onderwerp;
	private $inhoud;

	function setemail($ontvangers,$onderwerp,$inhoud)
	{
		$this->ontvangers = $ontvangers;
		$this->onderwerp = $onderwerp;
		$this->inhoud = $inhoud;
	}

	function getont($ontvanger,$project)
	{
		$db = db::getInstance();
		switch ($ontvanger) {
		    case 1:
	    		$query="SELECT DISTINCT email FROM gebruikers WHERE nieuwsbrief = 1";
				$query = $db->prepare($query);
				$query->execute();
				$ontvangers = $query->fetchAll(PDO::FETCH_ASSOC);
				return $ontvangers;
		    break;
		    case 2:
	    		$query="SELECT DISTINCT email FROM gebruikers INNER JOIN internbalans ON gebruikers.user_id = internbalans.user_id";
				$query = $db->prepare($query);
				$query->execute();
				$ontvangers = $query->fetchAll(PDO::FETCH_ASSOC);
				return $ontvangers;
		    break;
		    case 3:
		        $query="SELECT DISTINCT email 
		        		FROM gebruikers 
		        		INNER JOIN internbalans ON gebruikers.user_id = internbalans.user_id 
		        		INNER JOIN projecten ON internbalans.project_id = projecten.project_id 
		        		WHERE projecten.project_id = :project";
				$query = $db->prepare($query);
				$query->execute([':project' => $project]);
				$ontvangers = $query->fetchAll(PDO::FETCH_ASSOC);
				return $ontvangers;
		    break;
		    case 4:
		        $query="SELECT DISTINCT email FROM gebruikers WHERE rechten_id = 3";
				$query = $db->prepare($query);
				$query->execute();
				$ontvangers = $query->fetchAll(PDO::FETCH_ASSOC);
				return $ontvangers;
		    break;
		    case 5:
		        $query="SELECT DISTINCT email FROM gebruikers";
				$query = $db->prepare($query);
				$query->execute();
				$ontvangers = $query->fetchAll(PDO::FETCH_ASSOC);
				return $ontvangers;
		    break;
		}
	}

	function sendmail()
	{
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= 'From: <noreply@opwaarts.nl>' . "\r\n";
		$db = db::getInstance();

		$query="INSERT INTO `emailqueue` (`email_id`,`ontvanger`, `onderwerp`, `inhoud`, `datum`,`header`) 
		VALUES (NULL,:ontvanger, :onderwerp, :inhoud, now(), :header)";

		$query = $db->prepare($query);
		foreach ($this->ontvangers as $ontvanger)
		{
		$query->execute(array(':ontvanger' => $ontvanger['email'], ':onderwerp' => $this->onderwerp, ':inhoud' => $this->inhoud, ':header' => $headers));
		}
	}
}

?>