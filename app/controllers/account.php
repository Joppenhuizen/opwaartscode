<?php

class account extends controller
{
	function index()
	{
			if(isset($_SESSION['user']))
			{
				$account = $this->model('accounts');
				$account->setuser($_SESSION['user']['user_id']);
				$inv = $account->getinv();

				$this->view('account/index',['trans' => $inv]);
			}
			else{
				header("Location:/home");
			}
		
		
	}
	function editwacht()
	{
		$viewparam = '';

		if(isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['repass']))
		{
			$account = $this->model('user');
			$account->set_user($_SESSION['user']['email'], $_POST['oldpass'],'','','','');
			$ver = $account->authenticatie();
			if($_POST['newpass'] == $_POST['repass'])
			{
				if($ver == 'ver=0')
				{
					if($account->changepass($_POST['newpass']))
					{
						$viewparam = 1;
					}
				}

				else
				{
					$viewparam = 0;
				}

				$this->view('account/editwacht',['user' => $_SESSION['user'], 'viewparam' => $viewparam]);
			}
			else
			{
				$viewparam = 3;
				$this->view('account/editwacht',['user' => $_SESSION['user'], 'viewparam' => $viewparam]);
			}
		}
		else
		{
			if(isset($_SESSION['user']))
			{
				
				$this->view('account/editwacht',['user' => $_SESSION['user'], 'viewparam' => $viewparam]);
			}
			else
			{

			}
		}
	}
	function edit()
	{
		$viewparam = '';

		if(isset($_POST['username']) && isset($_POST['voornaam']) && isset($_POST['achternaam']))
		{
			$account = $this->model('user');
			if($account->checkIBAN($_POST['iban']))
			{
				if($account->edit($_POST,$_FILES))
				{
					$viewparam = 1;
				}

				else
				{
					$viewparam = 0;
				}

				$this->view('account/edit',['user' => $_SESSION['user'], 'viewparam' => $viewparam]);
			}
			else
			{
				$viewparam = 3;
				$this->view('account/edit',['user' => $_SESSION['user'], 'viewparam' => $viewparam]);
			}


		}
		else
		{
			if(isset($_SESSION['user']))
			{
				
				$this->view('account/edit',['user' => $_SESSION['user'], 'viewparam' => $viewparam]);
			}
			else
			{

			}
		}
	}
	function withdrawal()
	{
		$allowedcur = ['20','50','100','200'];
		if(isset($_POST['cur']) && in_array($_POST['cur'], $allowedcur))
		{
			$account = $this->model('accounts');
			if(isset($_SESSION['user']['bankrekening']) && $_SESSION['user']['bankrekening'] != ''){
				if($account->withdrawal($_SESSION['user'],$_POST['cur']))
				{
					$this->view('account/withsucces',['user' => $_SESSION['user'],'cur' => $_POST['cur']]);
				}
			}
			else{
				$this->view('account/edit',['user' => $_SESSION['user'], 'viewparam' => 'iban']);
			}
			//$this->view('account/add-success',[]);
		}
		else{

			if(isset($_SESSION['user']) && $_SESSION['user']['balans'] > 20)
			{
				$this->view('account/withdrawal',[]);
			}
			else
			{

			}
		}
	}
	function addcur()
	{
		$allowedcur = ['20','50','100','200'];
		if(isset($_POST['cur']) && in_array($_POST['cur'], $allowedcur))
		{
			$account = $this->model('accounts');
			
			if($account->addcur($_SESSION['user'],$_POST['cur']))
			{
				$this->view('account/addsuccess',['user' => $_SESSION['user'],'cur' => $_POST['cur']]);
			}

			//$this->view('account/add-success',[]);
		}
		else
		{
			if(isset($_SESSION['user']))
			{
				$this->view('account/addcur',[]);
			}
			else{
				header("Location:/home");
			}
		}
	}
}

?>