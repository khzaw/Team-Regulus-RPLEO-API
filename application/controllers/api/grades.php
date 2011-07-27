<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

class Grades extends REST_Controller {
	
	function recentGrades_post()
	{
		if(!($this->post('sid') && $this->post('password'))) {
			$this->response(NULL, 404);
		}
		else {
			$sid = $this->post('sid');
			$password = $this->post('password');
			$recent_grades_url = "http://leo.rp.edu.sg/workspace/studentGrades.asp";
			$problem_url = "http://leo3.rp.edu.sg//projectweb/daily_grade.asp?courseid=";
			
			
			$html = get_html($sid, $password, $recent_grades_url);
		
			$modules_pattern = "/'_blank'>([A-Z][0-9][0-9][0-9])-/";
			$problems_pattern = "/Problem (\d{1,2})/";
			$grades_pattern = "/\}' target='_blank'>([ABCDFX])</";
			$courseID_pattern = "/projectweb\/daily_grade.asp\?courseid=(.{38})/";
			$projectID_pattern = "/&projectid=(.{38})/";
			$team_comment_pattern = '/<td bgcolor="#FFFFFF"><font class=iContent>(.*)<font class=iContent><small>View Team Report on/s';
			$individual_comment_pattern = '/<td bgcolor="#FFFFFF"><font class=iContent>(.*)<\/font><\/td>/';
			$attendance_pattern = "/<b>(Present|Late|NIFM|Partial|Late & Partial)<\/b>/";
		
			preg_match_all($modules_pattern, $html, $matches);
			$modules = $matches[1];
			preg_match_all($problems_pattern, $html, $matches);
			$problems = $matches[1];
			preg_match_all($grades_pattern, $html, $matches);
			$grades = $matches[1];
			preg_match_all($courseID_pattern, $html, $matches);
			$courseIDs = $matches[1];
			preg_match_all($projectID_pattern, $html, $matches);
			$projectIDs = $matches[1];
			
				
			$recent_grades = array();
			
			for($i = 0; $i < count($modules); $i++) {
				$module_array= array(
					"module_code" => $modules[$i], 
					"module_name" => get_module_name($sid, $password, $modules[$i]), 
					"problem" => $problems[$i], 
					"grade" => $grades[$i]
					);
				$url = $problem_url.$courseIDs[$i]."&projectid=" . $projectIDs[$i];

				$html = get_html($sid, $password, $url);
				
				preg_match_all($attendance_pattern, $html, $matches);
			
				$recent_grades[] = $module_array;
			}
			
			if(count($recent_grades) > 0) {
				$this->response($recent_grades, 200);
			}
			else {
				$this->response(array("error" => "Invalid StudentID or password"), 404);
			}
		}
	}
	
	function recentUTGrades_post() {
		if(!($this->post('sid') && $this->post('password'))) {
			$this->response(NULL, 404);
		}
		else {
			$sid = $this->post('sid');
			$password = $this->post('password');
			$recent_grades_url = "http://leo.rp.edu.sg/workspace/studentGrades.asp";
			
			$html = get_html($sid, $password, $recent_grades_url);
			
			$utModules_pattern = "/'_blank'>(.{4})-\d-.{4}-\w<\/a>.{300,303}UT/";
			$utNo_pattern = "/UT ([1-3])/";
			$utGrades_pattern = "/}&order=1' target='_blank'>(.{1,2})</";
			$courseID_pattern = "/projectweb\/student_summary.asp\?courseid=(.{38})/";
			
			preg_match_all($utModules_pattern, $html, $matches);
			$utModules = $matches[1];
			preg_match_all($utNo_pattern, $html, $matches);
			$utNo = $matches[1];
			preg_match_all($utGrades_pattern, $html, $matches);
			$utGrades = $matches[1];
			preg_match_all($courseID_pattern, $html, $matches);
			$courseIDs = $matches[1];
			
			$recent_ut_grades = array();
			for($i = 0; $i < count($utModules); $i++) {
				$module_array = array("module_code" => $utModules[$i], "module_name" => get_module_name($sid, $password, $utModules[$i]) ,"ut_no" => $utNo[$i], "ut_grade" => $utGrades[$i]);
				$recent_ut_grades[] = $module_array;
			}
			
			if(count($recent_ut_grades) > 0) {
				$this->response($recent_ut_grades , 200);
			}
			else {
				$this->response(array("error" => "Invalid StudentID or password"), 404);
			}
		}
	}
	
	function allModuleSummary_get() {
		if(!($this->get('sid') && $this->get('password'))) {
			$this->response(NULL, 404);
		}
		else {
			$sid = $this->get('sid');
			$password = $this->get('password');
			$glob = get_all_module_codes($sid, $password);
			
			$module_codes = $glob["module_codes"];
			$course_ids = $glob["course_ids"];
		
			/* pyin dal kwar */
			
			
			
			$this->response($module_codes, 200);
			
		}
	}
	
	function recentGrades_get()
	{
		if(!($this->get('sid') && $this->get('password'))) {
			$this->response(NULL, 404);
		}
		else {
			$sid = $this->get('sid');
			$password = $this->get('password');
			$recent_grades_url = "http://leo.rp.edu.sg/workspace/studentGrades.asp";
			$problem_url = "http://leo3.rp.edu.sg//projectweb/daily_grade.asp?courseid=";
			
			
			$html = get_html($sid, $password, $recent_grades_url);
		
			$modules_pattern = "/'_blank'>([A-Z][0-9][0-9][0-9])-/";
			$problems_pattern = "/Problem (\d{1,2})/";
			$grades_pattern = "/\}' target='_blank'>([ABCDFX])</";
			$courseID_pattern = "/projectweb\/daily_grade.asp\?courseid=(.{38})/";
			$projectID_pattern = "/&projectid=(.{38})/";
			$team_comment_pattern = '/<td bgcolor="#FFFFFF"><font class=iContent>(.*)<font class=iContent><small>View Team Report on/s';
			$individual_comment_pattern = '/<td bgcolor="#FFFFFF"><font class=iContent>(.*)<\/font><\/td>/';
			$attendance_pattern = "/<b>(Present|Late|NIFM|Partial|Late & Partial)<\/b>/";
		
			preg_match_all($modules_pattern, $html, $matches);
			$modules = $matches[1];
			preg_match_all($problems_pattern, $html, $matches);
			$problems = $matches[1];
			preg_match_all($grades_pattern, $html, $matches);
			$grades = $matches[1];
			preg_match_all($courseID_pattern, $html, $matches);
			$courseIDs = $matches[1];
			preg_match_all($projectID_pattern, $html, $matches);
			$projectIDs = $matches[1];
			
				
			$recent_grades = array();
			
			for($i = 0; $i < count($modules); $i++) {
				$module_array= array(
					"module_code" => $modules[$i], 
					"module_name" => get_module_name($sid, $password, $modules[$i]), 
					"problem" => $problems[$i], 
					"grade" => $grades[$i]
					);
				$url = $problem_url.$courseIDs[$i]."&projectid=" . $projectIDs[$i];

				$html = get_html($sid, $password, $url);
				
				preg_match_all($attendance_pattern, $html, $matches);
			
				$recent_grades[] = $module_array;
			}
			
			if(count($recent_grades) > 0) {
				$this->response($recent_grades, 200);
			}
			else {
				$this->response(array("error" => "Invalid StudentID or password"), 404);
			}
		}
	}
	
	function recentUTGrades_get() {
		if(!($this->get('sid') && $this->get('password'))) {
			$this->response(NULL, 404);
		}
		else {
			$sid = $this->get('sid');
			$password = $this->get('password');
			$recent_grades_url = "http://leo.rp.edu.sg/workspace/studentGrades.asp";
			
			$html = get_html($sid, $password, $recent_grades_url);
			
			$utModules_pattern = "/'_blank'>(.{4})-\d-.{4}-\w<\/a>.{300,303}UT/";
			$utNo_pattern = "/UT ([1-3])/";
			$utGrades_pattern = "/}&order=1' target='_blank'>(.{1,2})</";
			$courseID_pattern = "/projectweb\/student_summary.asp\?courseid=(.{38})/";
			
			preg_match_all($utModules_pattern, $html, $matches);
			$utModules = $matches[1];
			preg_match_all($utNo_pattern, $html, $matches);
			$utNo = $matches[1];
			preg_match_all($utGrades_pattern, $html, $matches);
			$utGrades = $matches[1];
			preg_match_all($courseID_pattern, $html, $matches);
			$courseIDs = $matches[1];
			
			$recent_ut_grades = array();
			for($i = 0; $i < count($utModules); $i++) {
				$module_array = array("module_code" => $utModules[$i], "module_name" => get_module_name($sid, $password, $utModules[$i]) ,"ut_no" => $utNo[$i], "ut_grade" => $utGrades[$i]);
				$recent_ut_grades[] = $module_array;
			}
			
			if(count($recent_ut_grades) > 0) {
				$this->response($recent_ut_grades , 200);
			}
			else {
				$this->response(array("error" => "Invalid StudentID or password"), 404);
			}
		}
	}

}