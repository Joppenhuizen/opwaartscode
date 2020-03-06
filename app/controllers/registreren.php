<?php
class registreren extends controller
{
		function index()
		{
			
			$nieuwsbrief = 0;
			$viewparam = '';
			if(isset($_POST['username']) && !empty($_POST['username']) && 
			   isset($_POST['wachtwoord']) && !empty($_POST['wachtwoord']) && 
			   isset($_POST['achternaam']) && !empty($_POST['achternaam']) && 
			   	isset($_POST['voornaam']) && !empty($_POST['voornaam']))
			{
				if(isset($_POST['nieuwsbrief']))
				{
					$nieuwsbrief = 1;
				}
				$hash = md5(rand(0,1000));
				$user = $this->model('user');
				$user->set_user($_POST['username'],$_POST['wachtwoord'],$_POST['voornaam'],$_POST['achternaam'],$nieuwsbrief,$hash);
				if($user->registreren())
				{
					$user->sendmail();
					header("Location:/login");
				}
				else
				{
					$viewparam="exists";
				}
			}
			$this->view('registreren/index',['viewparam' => $viewparam]);
		}
		function verifieren($userid = '', $hash = '')
		{
			if($userid != '' && $hash != '')
			{
				$user = $this->model('user');
				if($user->emailver($userid,$hash))
				{
					$this->view('registreren/emailver',['viewparam' => $viewparam]);
				}			
			}
			else
			{
				header("location:/home");
			}
		}
}

?>