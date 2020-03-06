<?php

class login extends controller{
	public function index($params = '')
	{	

		$msg = '';
		if(isset($_POST['username']) && isset($_POST['wachtwoord']))
		{
			$user = $this->model('user');
			$user->set_user($_POST['username'],$_POST['wachtwoord'],'','','','');
			$authuser = $user->authenticatie();
			if($authuser == 'ver=0') //ingelogt
			{
				//header("location:/account");
				$msg = 'Verifiëer uw email adres';
			}
			if($authuser == 'ver=1') //email ver
			{
				unset($user);
				$msg = 'Verifiëer uw email adres';
			}
			if($authuser == 'ver=2')//foutieve inlog
			{
				unset($user);
				$msg = 'Foutieve inlog';
			}
		}
		$this->view('login/index',['msg' => $msg]);
	}
	public function uitloggen()
	{
		session_destroy();
		$this->view('login/index');
	}
}

?>