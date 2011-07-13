<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leo extends CI_Controller {


	public function index()
	{
		echo "Welcome to Project Regulus";
	}
	
	public function rj() 
	{
	
	}
	
	public function me()
	{
	
	}
	
	public function ce() 
	{
	
	}
	
	public function recent_grades()
	{
		$url = "http://leo.rp.edu.sg//workspace/studentGrades.asp";
		$sid = "91178";
		$password = "parphoungM@";
		$result = $this->get_courses_id($sid, $password,$url);
		echo $result;
	
	}
	
	public function urlopen($sid, $password, $url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_USERPWD, "$sid:$password");
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	
	public function get_courses_id($sid, $password, $url)
	{
		$html_content = (string)urlopen($sid, $password, $url);
		return $html_content;
		$pattern = "/courseid=(.{38})/";
		preg_match_all($pattern, $html_content, $matches);
		return $matches;
	}
	
	
}