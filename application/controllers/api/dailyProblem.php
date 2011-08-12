<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

class DailyProblem extends REST_Controller {
	
	public function rjquestion_post() {
		
		if(!($this->post('sid') && $this->post('password'))) {
			$this->response(NULL, 404);
		}
		else {

			$today_problem_url = "http://leo.rp.edu.sg/workspace/studentModule.asp?site=3&disp=";

			$sid = $this->post('sid');
			$password = $this->post('password');
			
			/* Need courseID and projectID to access today's RJ question */
			
			$problem_html = get_html($sid, $password, $today_problem_url);

			preg_match_all("/courseid=(.{38})/", $problem_html, $matches);
			if(!$matches[1])
			{
				$this->response(array("error" => "No Problem Statement Today"), 404); 
			}
			$courseid = $matches[1][0];
		
			preg_match_all("/projectid=(.{38})/", $problem_html, $matches);
			$flur = $matches[count($matches)-1];
			$projectid = $flur[count($flur)-1];
			
			
			$rj_url = "http://leo3.rp.edu.sg/projectweb/daily_grade.asp?courseid=$courseid&projectid=$projectid&lang=ISO-8859-1";
			$html = get_html($sid, $password, $rj_url);
			
			$problem_list_pattern = "/SELECTED> (.+)<\/OPTION>/";
			preg_match_all($problem_list_pattern, $html, $matches);
			$problem_name = $matches[1][0];
			
			$rj_question_pattern = "/<font class=iContent>Question:(.*)<\/font><BR><br>/s";
			preg_match_all($rj_question_pattern, $html, $matches);
			
			if(!$matches[1]) {
				$rj_question = "No Reflection Journal Assigned Yet";
			}
			else {
				$rj_question = $matches[1][0];
			}
			
			$rj_submission_pattern = "/<font class=iContent>Response: (.*) <\/font>/";
			preg_match_all($rj_submission_pattern, $html, $matches);
			$response = $matches[1][0];
			
			if($response == "No Submission") $response = "Not Submitted";
			else $response = "Submitted";
			
			if($problem_name) {
				$result = array (
					"problem_name" => $problem_name,
					"rj_question" => $rj_question,
					"status" => $response
				);
				$this->response($result, 200);
			}
			else {
				$this->response(array("error"=>"Wrong Student ID/password combination"), 404);
			}
		}
	}
}