<?php

class accounts
{
	private $userid;

	function setuser($userid)
	{
		$this->userid = $userid;
	}

	function getinv()
	{
		$query="SELECT *
				FROM externbalans 
				INNER JOIN type_inv ON externbalans.type_id = type_inv.type_id
			    WHERE externbalans.user_id = :userid ORDER BY datum ASC";
		
		$query2="SELECT *
				FROM internbalans 
                INNER JOIN projecten ON internbalans.project_id = projecten.project_id
                INNER JOIN type_inv ON internbalans.type_id = type_inv.type_id
			    WHERE internbalans.user_id = :userid".
			    " ORDER BY internbalans.datum ASC";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query2 = $db->prepare($query2);
		$query->execute([':userid' => $this->userid]);
		$query2->execute([':userid' => $this->userid]);

		$externbalans = $query->fetchAll();
		$internbalans = $query2->fetchAll();

		$result = ['extern' => $externbalans,'intern' => $internbalans];

		return $result;
	}

	function addcur($user,$curr)
	{
		//validatie door externe betaalservice komt hier.

		$query="INSERT INTO `externbalans` (user_id,mutatie,datum,type_id) VALUES (:userid,:cur,now(),4);";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute([':userid' => $user['user_id'], ':cur' => $curr]);

		$curr = $user['balans'] + $curr;
		
		$updatebalans="UPDATE gebruikers
				SET balans=".$curr."
				WHERE user_id='".$user['user_id']."'";
		$updatebalans = $db->prepare($updatebalans);

		if($updatebalans->execute())
		{
			$_SESSION['user']['balans'] = $curr;
			return true;
		}
		else
		{
			return false;
		}
	}
	function withdrawal($user,$curr)
	{
		$query="INSERT INTO `externbalans` (user_id,mutatie,datum,type_id) VALUES (:userid,:cur,now(),3);";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute([':userid' => $user['user_id'], ':cur' => $curr]);

		$curr = $user['balans'] - $curr;
		
		$updatebalans="UPDATE gebruikers
				SET balans= :curr
				WHERE user_id=':userid'";
		$updatebalans = $db->prepare($updatebalans);

		if($updatebalans->execute([':curr' => $curr,':userid' => $user['user_id']]))
		{
			$_SESSION['user']['balans'] = $curr;
			return true;
		}
		else
		{
			return false;
		}
	}
	function removecur($user,$curr,$projectid)
	{
		$db = db::getInstance();
		$validate = [];

		$projecten = "SELECT * 
				FROM projecten 
			    WHERE project_id = :projectid";

		$projecten = $db->prepare($projecten);
		$projecten->execute(':projectid'=>$projectid);
		$result = $projecten->fetchAll();
		$curproject = $curr + $result[0]['ingelegt'];
		$curuser = $user['balans'] - $curr;
		if($curproject > $result[0]['doelbedrag']){return 3;}
		if($curuser >= 0)
		{
			$trans="INSERT INTO `internbalans` (user_id,mutatie,datum,type_id,project_id) 
					VALUES (:userid,:curr,now(),1,:projectid);";
			
			$updateuser="UPDATE gebruikers
							SET balans=:curuser
							WHERE user_id=':userid'";

			$updateproject="UPDATE projecten
								SET ingelegt=:curproj
								WHERE project_id=':projectid'";
			
			$trans = $db->prepare($trans);
			$updateuser = $db->prepare($updateuser);
			$updateproject = $db->prepare($updateproject);

			if($trans->execute([':userid' => $user['user_id'], ':curr' => $curr, ':projectid' => $projectid]) && 
				$updateuser->execute([':curuser' => $curuser, ':userid' => $user['user_id']) && 
				$updateproject->execute([':curproj' => $curproject, ':projectid' => $projectid)
			  )
			{
				$_SESSION['user']['balans'] = $curuser;
				return $result;
			}
			else
			{
				return 1;
			}
		}
		else
		{
			return 2;
		}
	}
}

?>