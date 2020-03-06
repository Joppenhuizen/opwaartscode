<?php

class data
{
	function getinvest($ont)
	{
		$array = array();
		if($ont == '')
		{
			$query="SELECT DISTINCT project_naam, project_id FROM projecten";
		}
		else
		{
			$query="SELECT DISTINCT project_naam, project_id FROM projecten WHERE ontwikkelaar_id = ".$ont;
		}
		$db = db::getInstance();

		$query = $db->prepare($query);
		$query->execute();
		$projecten = $query->fetchAll(PDO::FETCH_ASSOC);


		$invss="SELECT * FROM gebruikers 
			  INNER JOIN internbalans ON gebruikers.user_id = internbalans.user_id 
		      WHERE internbalans.type_id = 1 && internbalans.project_id = :projectid";

		$invss = $db->prepare($invss);

		for($j=0;$j < count($projecten); $j++)
		{
			array_push($array,['project_naam' => $projecten[$j]['project_naam']]);

			$invss->execute(array(':projectid' => $projecten[$j]['project_id']));
			$invs = $invss->fetchAll(PDO::FETCH_ASSOC);

			for($i=0;$i < count($invs); $i++)
			{
				//$array[$j]['inv']
				array_push($array[$j], $invs[$i]);
			}
		}

		return $array;
	}
}	

?>