<?php

class projecten extends controller
{
	function index()
	{
		$projecten = $this->model('project');
		$projecten = $projecten->showall();
		$this->view('projecten/index',['projecten' => $projecten]);
	}
	function docs($id='')
	{
		if($id == ''){header("Location:/projecten");}
		$project = $this->model('project');
		$project->set_projectid($id);
		$docs = $project->getdocs();
		$this->view('projecten/docs',['id' => $id, 'docs' => $docs]);
	}
	function downloaddoc($id = '')
	{
		$project = $this->model('project');
		$download = $project->downloaddoc($id);
		$file = '../public'.$download[0]['file_path'];

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
		    //header("Location:/projecten/docs/".$id);
		}
	}
	function type($id = '')
	{
		if($id == ''){header("Location:/projecten");}
		$project = $this->model('project');
		$projecten = $project->getprobytype($id);
		$this->view('projecten/index',['projecten' => $projecten]);
	}
	function addcomments($id = '')
	{

	}
	function comments($id= '')
	{
		if($id == ''){header("Location:/projecten");}
		$project = $this->model('project');
		$project->set_projectid($id);
		$comment = $project->getcomments();
		$this->view('projecten/comments',['id' => $id, 'comment' => $comment]);
	}
	function show($id = '')
	{
		if($id == ''){header("Location:/projecten");}
		$project = $this->model('project');
		$project->set_projectid($id);
		$comments = $project->gettopcomments();
		$project = $project->showproject();
		$this->view('projecten/project',['project' => $project, 'comments' => $comments]);
	}
	function invest($id = '')
	{
		if(isset($_POST['id'])){$id=$_POST['id'];}
		if($id == ''){header('Location:/projecten');}
		if(isset($_SESSION['user']))
		{
			$allowedcur = ['60','100','175','250','500','1000','5000'];
			if(isset($_POST['cur']) && in_array($_POST['cur'], $allowedcur))
			{
				$account = $this->model('accounts');
				$project = $account->removecur($_SESSION['user'],$_POST['cur'],$id);
				if(gettype($project) == 'array')
				{
					$this->view('projecten/investsuccess',['project' => $project, 'cur' => $_POST['cur']]);
				}
				else
				{
					if($project == 1){$this->view('projecten/index');}
					if($project == 2){$this->view('account/addcur',['msg' => 'Uw balans is te laag']);}
					if($project == 3){$this->view('projecten/index',['msg' => 'Uw inleg gaat over het doelbedrag heen']);}
					
				}
			}
			else
			{
				$this->view('projecten/invest',['id' => $id]);
			}
		}
		else
		{
			header("Location:/registreren");
		}


	}
}

?>