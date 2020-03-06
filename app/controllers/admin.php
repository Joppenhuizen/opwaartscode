<?php

class admin extends controller
{

	function index()
	{
		if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
		{

			$this->view('admin/index',[]);
		}
		else
		{
			header("Location:/home");
		}
	}
	function removedoc($projectid='',$docid='')
	{
		if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
		{
			
			$projecten = $this->model('project');
			$check = $projecten->removedoc($projectid, $docid);
			if($check)
			{
				header("Location:/admin/editproject/".$projectid);
			}

		}
		else
		{
			header("Location:/home");
		}
	}
	function sepa()
	{
		if($_SESSION['user']['rechten_id'] == 1)
		{
			$sepa = $this->model('sepa');
			$pending = $sepa->pendingtrans();
			$payments = $sepa->payments();

			$this->view('admin/sepa',['pending' => $pending, 'payment' => $payments]);
		}
		else
		{
			header("Location:/home");
		}
	}
	function generatesepa()
	{
		if($_SESSION['user']['rechten_id'] == 1)
		{
			$sepa = $this->model('sepa');
			$sepa = $sepa->generatesepa();

				header("Location:/admin/sepa");

		}
		else
		{
			header("Location:/home");
		}
	}
	function downloadsepa($id = '')
	{
		if($_SESSION['user']['rechten_id'] == 1)
		{
			$sepa = $this->model('sepa');
			$download = $sepa->downloadsepa($id);
			$file = '../app/lib/sepa/'.$download[0]['bestandnaam'].'.xml';

			if (file_exists($file)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename='.basename($file));
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    ob_clean();
			    flush();
			    readfile($file);
			    $sepa->downloaded($id);
			    //header("Location:/admin/sepa");
			}
		}
		else
		{
			header("Location:/home");
		}
	}
	function ontwikkelaars()
	{
		if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
		{
			$ontwikkelaars = $this->model('ontwikkelaar');
			$ontwikkelaars = $ontwikkelaars->findall($_SESSION['user']['rechten_id']);

			$this->view('admin/ontwikkelaars',['ont' => $ontwikkelaars]);
		}
		else
		{
			header("Location:/home");
		}
	}
	function investeerders()
	{
		if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
		{
			$ont = '';
			if(isset($_SESSION['ont'])){$ont=$_SESSION['ont']['ontwikkelaar_id'];}
			$investeerders = $this->model('data');
			$investeerders = $investeerders->getinvest($ont);

			$this->view('admin/investeerders',['inv' => $investeerders]);
		}
		else
		{
			header("Location:/home");
		}
	}
	function removeimg($project = '', $imageid = '')
	{


		if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
		{
			
			$projecten = $this->model('project');
			if($projecten->removeimg($project, $imageid))
			{
				header("Location:/admin/editproject/".$project);
			}

		}
		else
		{
			header("Location:/home");
		}


	}
	function editontwikkelaar($id = '')
	{
		if(isset($_POST['devnaam']) && !empty($_POST['devnaam']) && 
			   isset($_POST['email']) && !empty($_POST['email']) && 
			   isset($_POST['devlocatie']) && !empty($_POST['devlocatie']) && 
			   isset($_POST['devkvk']) && !empty($_POST['devkvk'])&& 
			   isset($_POST['devomschrijving']) && !empty($_POST['devomschrijving'])
			   )
		{
			$ontwikkelaar = $this->model('ontwikkelaar');
			$ontwikkelaar->setontid($id);
			$ontwikkelaar = $ontwikkelaar->editontwikkelaar($_POST,$_FILES);
			if($ontwikkelaar)
			{
				header("Location:/admin/editontwikkelaar/".$id);
			}
		}
		else
		{
			if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
			{
				$ontwikkelaars = $this->model('ontwikkelaar');
				$ontwikkelaars->setontid($id);
				$ontwikkelaars = $ontwikkelaars->findontwikkelaar();
				$this->view('admin/editontwikkelaar',['ontwikkelaars' => $ontwikkelaars]);
			}
			else
			{
				header("Location:/home");
			}
		}

	}
	function editproject($id = '')
	{
		if(isset($_POST['pnaam']) && !empty($_POST['pnaam']) && 
			   isset($_POST['plocatie']) && !empty($_POST['plocatie']) && 
			   isset($_POST['pomschrijving']) && !empty($_POST['pomschrijving']) && 
			   isset($_POST['pdoelbedrag']) && !empty($_POST['pdoelbedrag'])&& 
			   isset($_POST['pstart']) && !empty($_POST['pstart'])&& 
			   isset($_POST['peind']) && !empty($_POST['peind'])&& 
			   isset($_POST['pvanaf']) && !empty($_POST['pvanaf'])&& 
			   isset($_POST['ptot']) && !empty($_POST['ptot'])&& 
			   isset($_POST['prendement']) && !empty($_POST['prendement'])&& 
			   isset($_FILES['images']) && !empty($_FILES['images'])
			   )
		{
			$project = $this->model('project');
			$project->set_projectid($id);
			$project->set_all($_POST,$_FILES);
			$project = $project->editproject($id);

				header("Location:/admin/editproject/".$id);
			
		}
		else
		{
			if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
			{
				$model = $this->model('project');
				$model->set_projectid($id);
				$project = $model->showproject();
				$ontwikkelaars = $this->model('ontwikkelaar');
				$ontwikkelaars = $ontwikkelaars->findall();
				$projecttypes = $model->findprotype();
				$types = $model->findtypes();
				$status = $this->model('project');
				$status = $status->findstatus();
				$this->view('admin/editproject',['project' => $project,'ontwikkelaars' => $ontwikkelaars, 'types' => $types, 'status' => $status, 'projecttypes' => $projecttypes]);
			}
			else
			{
				header("Location:/home");
			}
		}
	}
	function email()
	{
		if(isset($_SESSION['user']['rechten_id']) &&  $_SESSION['user']['rechten_id'] != 2)
		{
			$projecten = $this->model('project');
			$projecten = $projecten->showall(3);
			$this->view('admin/email',['projecten' => $projecten]);
		}
		else
		{
			header("Location:/home");
		}
	}
	function users()
	{
		if($_SESSION['user']['rechten_id'] == 1)
		{
			$user = $this->model('user');
			$user = $user->findusers();
			$this->view('admin/user',['users' => $user]);
		}
		else
		{
			header("Location:/home");
		}
	}
	function projecten()
	{
		if(isset($_SESSION['user']['rechten_id']) && $_SESSION['user']['rechten_id'] != 2)
		{
			$projecten = $this->model('project');
			$projecten = $projecten->showall($_SESSION['user']['rechten_id'],$_SESSION['user']['user_id']);
			$this->view('admin/projecten',['projecten' => $projecten]);
		}
		else
		{
			header("Location:/home");
		}
	}
	function sendemail()
	{
		if(isset($_SESSION['user']['rechten_id']) && $_SESSION['user']['rechten_id'] != 2)
		{
			if(isset($_POST['onderwerp']) && !empty($_POST['onderwerp']) && 
			   isset($_POST['inhoud']) && !empty($_POST['inhoud']) && 
			   isset($_POST['ontvanger']) && !empty($_POST['ontvanger'])
			   )
			{
				$project = '';
				if($_SESSION['user']['rechten_id'] == 3 && $_POST['ontvanger'] != '3'){header("Location:/admin");}
				if($_POST['ontvanger'] == '3' && isset($_POST['project']))
				{
					$project = $_POST['project'];
				}

				$email = $this->model('mail');
				$ontvangers = $email->getont($_POST['ontvanger'],$project);
				$email->setemail($ontvangers,$_POST['onderwerp'],$_POST['inhoud']);
				$email->sendmail();
				header("Location:/admin");
			}
			else
			{

				$this->view('admin/email',['projecten' => $ontvangers]);
			}
		}
		else
		{
			header("Location:/home");
		}
	}

	function adddev()
	{
		if($_SESSION['user']['rechten_id'] == 1)
		{
			if(isset($_POST['devnaam']) && !empty($_POST['devnaam']) && 
			   isset($_POST['devlocatie']) && !empty($_POST['devlocatie']) && 
			   isset($_POST['devomschrijving']) && !empty($_POST['devomschrijving']) && 
			   isset($_POST['devkvk']) && !empty($_POST['devkvk']) && 
			   isset($_POST['wachtwoord']) && !empty($_POST['wachtwoord']) && 
			   isset($_POST['email']) && !empty($_POST['email']) && 
			   isset($_FILES['logo']) && !empty($_FILES['logo'])
			   )
			{
				$ontwikkelaar = $this->model('ontwikkelaar');
				$msg = '';
				$ontwikkelaar->setontwikkelaar($_POST,$_FILES);
				if($ontwikkelaar->adddev()){$msg='Toegevoegt';}
				else{$msg='Voeg aub een logo toe';}
				//header("Location:/admin/adddev");
				$this->view('admin/adddev',['msg' => $msg]);
			}
			else
			{
				$this->view('admin/adddev',['msg' => '']);
			}
		}
		else
		{
			header("Location:/home");
		}
}
	function addproject()
	{	
		if($_SESSION['user']['rechten_id'] == 1 || $_SESSION['user']['rechten_id'] == 3)
		{
			
			if(isset($_POST['pnaam']) && !empty($_POST['pnaam']) && 
			   isset($_POST['plocatie']) && !empty($_POST['plocatie']) && 
			   isset($_POST['pomschrijving']) && !empty($_POST['pomschrijving']) && 
			   isset($_POST['pdoelbedrag']) && !empty($_POST['pdoelbedrag'])&& 
			   isset($_POST['pstart']) && !empty($_POST['pstart'])&& 
			   isset($_POST['peind']) && !empty($_POST['peind'])&& 
			   isset($_POST['pvanaf']) && !empty($_POST['pvanaf'])&& 
			   isset($_POST['ptot']) && !empty($_POST['ptot'])&& 
			   isset($_POST['ontwikkelaar']) && !empty($_POST['ontwikkelaar'])&& 
			   isset($_POST['types']) && !empty($_POST['types'])&& 
			   isset($_POST['prendement']) && !empty($_POST['prendement'])&& 
			   isset($_FILES['images']) && !empty($_FILES['images'])
			   )
			{
				
				//var_dump($_POST);
				$project = $this->model('project');
				$project->set_all($_POST,$_FILES);
				$msg = '';
				if($project->addproject())
					{
						$msg='toegevoegt';
					}
				header("Location:/admin/addproject");
				$this->view('admin/add',['ontwikkelaars' => $_POST['ontwikkelaar'], 'msg' => $msg]);
				
			}
			else
			{


				$ontwikkelaars = $this->model('ontwikkelaar');
				$ontwikkelaars = $ontwikkelaars->findall();
				$types = $this->model('project');
				$types = $types->findtypes();
				$status = $this->model('project');
				$status = $status->findstatus();
				$this->view('admin/add',['ontwikkelaars' => $ontwikkelaars, 'types' => $types, 'status' => $status]);
			}
		}
		else
		{
			header("Location:/home");
		}
	}
}

?>