<?php

class sepa
{
	function downloadsepa($id)
	{
		$query="SELECT bestandnaam FROM `sepa`
		WHERE sepa_id = ".$id;

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();

		return $result;
	}
	function pendingtrans()
	{
		$query="SELECT COUNT(*) as count FROM `externbalans`
		WHERE type_id = 3 && `verwerkt` = 0";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();

		return $result;
	}
	function payments()
	{
		$query="SELECT * FROM `sepa` ORDER BY datum DESC";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();

		return $result;
	}
	function downloaded($id)
	{
		$query="UPDATE sepa
				SET gedownload=1
				WHERE sepa_id=".$id;

		$db = db::getInstance();
		$query = $db->prepare($query);
		$result = $query->execute();

		return $result;
	}
	function generatesepa()
	{

		$query="SELECT COUNT(*) as count FROM `externbalans`
		WHERE type_id = 3 && `verwerkt` = 0";

		$db = db::getInstance();
		$query = $db->prepare($query);
		$query->execute();
		$result = $query->fetchAll();

		if($result[0]['count'] > 0)
		{

			require_once '../app/lib/Sepa_credit_XML_Transfer_initation.class.php';

			$query="SELECT * FROM `externbalans`
					INNER JOIN gebruikers ON gebruikers.user_id = externbalans.user_id
					WHERE externbalans.type_id = 3 && `verwerkt` = 0";

			$query = $db->prepare($query);
			$query->execute();
			$result = $query->fetchAll();

			$query="SELECT count(*) as count FROM `sepa`";

			$query = $db->prepare($query);
			$query->execute();
			$result2 = $query->fetchAll();

			$id = $result2[0]['count'] + 1;

			//header ("Content-Type:text/xml");  
			$sepapay 		= new Sepa_credit_XML_Transfer_initation("Betaling-".$id); 	// batch name
			$sepapay->setOrganizationName("Opwaars"); 								// your accountname
			$sepapay->setOrganizationIBAN("NL81RABO0363973249");							// your IBAN
			$sepapay->setOrganizationBIC("INGBNL2A");								// your BIC
				
				$verwerkt="UPDATE externbalans
						   SET verwerkt=1
						   WHERE transnummer=:transnummer";

				$verwerkt = $db->prepare($verwerkt);
				$opdrachten = 0;
			foreach($result as $trans)
			{
			
				$transactie = new Sepa_credit_XML_Transfer_initation_Transaction($trans['achternaam'],$trans['mutatie'],$trans['bankrekening'],"INGBNL2A","Uitbetaling Opwaarts");
				$sepapay->addTransaction($transactie,'Betalingen');

				$verwerkt->execute(array(':transnummer' => $trans['transnummer']));
				$opdrachten++;
			}
		   	$sepa="INSERT INTO sepa (bestandnaam, datum,transacties)
				   VALUES (:id, now(),:opdrachten)";   
			$sepa = $db->prepare($sepa);
			$sepa->execute(array(':id' => $id, ':opdrachten' => $opdrachten));

			
			$sepapay->storeSepaFile('../app/lib/sepa/'.$id.'.xml');
			
		}
		else
		{
			
		}
	}
}

?>