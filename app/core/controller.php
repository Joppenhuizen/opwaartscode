<?php

class controller
{

	public function model($model)
	{
		require_once '../app/models/'.$model.'.php';
		return new $model();
	}

	public function view($view,$data = [])
	{
		$data['css'] = debug_backtrace()[1]['function'];
		require_once '../app/views/'.$view.'.php';
	}
}

?>