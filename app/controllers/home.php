<?php

class home extends controller
{
	public function index($param = '')
	{
		$project = $this->model('project');
		$project = $project->showtop();
		$this->view('home/index',['project' => $project]);
	}


}

?>