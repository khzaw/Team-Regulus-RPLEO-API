<?php

class Testing extends CI_Controller
{
	public function index()
	{
		$module_codes = array("C335", "C331", "C327");
		foreach($module_codes as $mc)
		{
			echo get_module_name("91178", "1337H4x0r", $mc);
			echo "<br/>";
		}
	}
}