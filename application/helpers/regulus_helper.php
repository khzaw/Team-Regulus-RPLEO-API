<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('element'))
{
	function get_html($sid, $password, $url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_USERPWD, "$sid:$password");
		$html = curl_exec($ch);
		curl_close($ch);
		return $html;		
	}	
}

if(! function_exists('element'))
{
	function get_module_name($sid, $password, $module_code)
	
	// $module_code is an array.
	
	{
		$url = "http://leo.rp.edu.sg/workspace/studentModule.asp?disp=all";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_USERPWD, "$sid:$password");
		$html = curl_exec($ch);
		curl_close($ch);
		
		
		
		
		$result = array();
		
		if($module_code) {
			foreach($module_code as $mc) {
				$pattern = "/$mc-\d-\w\d\d\w-[ABC]<\/a>&nbsp;&nbsp;<a href='javascript:\/\/' class=ttitle onMouseOver=\"popup\('<font color=darkblue> Owner: .*<\/font>', '#F1F1F1', '280'\);\" OnMouseOut='kill\(\)'><i>(.*)<\/i>/";
				preg_match_all($pattern, $html, $matches);
				$result[] = $matches[1][0];
			}		
		}
		return $result;
	}

}

if(! function_exists('element'))
{
	function get_all_module_codes($sid, $password)
	{
		$url = "http://leo.rp.edu.sg/workspace/studentGrades.asp";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_USERPWD, "$sid:$password");
		$html = curl_exec($ch);
		curl_close($ch);
		
		$module_code_pattern = "/'_blank'>([A-Z][0-9][0-9][0-9])-/";
		preg_match_all($module_code_pattern, $html, $matches);
		$module_codes = $matches[1];
				
		$course_id_pattern = "/projectweb\/student_summary.asp\?courseid=(.{38})/s";
		preg_match_all($course_id_pattern, $html, $matches);
		$course_ids = $matches[1];
		
		$result = array("module_codes" => $module_codes, "course_ids" => $course_ids);
		return $result;
	}
}

if(! function_exists('element'))
{
	function get_module_summary($sid, $password, $course_id)
	{
		$url = "http://leo3.rp.edu.sg//projectweb/student_summary.asp?courseid=" . $couse_id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_USERPWD, "$sid:$password");
		$html = curl_exec($ch);
		curl_close($ch);
		
		$problem_grades_pattern = "/<b>([ABCDFX])<\/b>/";
		preg_match_all($problem_grades_pattern, $html, $matches);
		$problem_grades = $matches[1];
		
		$ut_grades_pattern = "/<font class=iContent>(.{1,2})<\/font>/";
		preg_match_all($$ut_grades_pattern, $html, $matches);
		$ut_grades = $matches[1];
		
		$result = array("problem_grades" => $problem_grades, "ut_grades" => $ut_grades);
		return $result;
		
	}
}