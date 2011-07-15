<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

class Academic extends REST_Controller {

	function particulars_post() 
	{
		if(!($this->post('sid') && $this->post('password'))) {
			$this->response(NULL, 404);
		}
		else {
			$sid = $this->post('sid');
			$password = $this->post('password');
			$url = "http://myrp.sg/sass-student/AcademicInformation.aspx";
			
			
			$html = get_html($sid, $password, $url);
			
			$ce_diploma_pattern = '/id="ctl00_ContentPlaceHolderMain_lblCEDiploma" class="gen12"><b>(.*)<\/b>/';
			$ce_nondiploma_pattern = '/id="ctl00_ContentPlaceHolderMain_lblCENDiploma" class="gen12"><b>(.*)<\/b>/';
			$gpa_pattern = '/id="ctl00_ContentPlaceHolderMain_lblGPA" class="gen12"><b>(.*)<\/b>/';
			$name_pattern = '/id="ctl00_ContentPlaceHolderMain_lblName" class="gen12">(.*)<\/span>/';
			$diploma_pattern = '/id="ctl00_ContentPlaceHolderMain_lblDiploma" class="gen12">(.*)<\/span>/';
			$fin_pattern = '/id="ctl00_ContentPlaceHolderMain_lblUIN" class="gen12">(.*)<\/span>/';
			$phno_pattern = '/id="ctl00_ContentPlaceHolderMain_lblContactNo" class="gen12">(.*)<\/span>/';
			
			preg_match_all($name_pattern, $html, $matches);
			$name = $matches[1][0];
			preg_match_all($diploma_pattern, $html, $matches);
			$diploma = $matches[1][0];
			preg_match_all($gpa_pattern, $html, $matches);
			$gpa = $matches[1][0];
			preg_match_all($phno_pattern, $html, $matches);
			$phno = $matches[1][0];
			preg_match_all($fin_pattern, $html, $matches);
			$fin = $matches[1][0];
			preg_match_all($ce_diploma_pattern, $html, $matches);
			$ce_diploma = $matches[1][0];
			preg_match_all($ce_nondiploma_pattern, $html, $matches);
			$ce_nondiploma = $matches[1][0];


			if($name && $diploma && $gpa && $phno && $ce_diploma && $ce_nondiploma) {
				$this->response(array("name" => $name, "diploma" => $diploma, "gpa" => $gpa, "phno" => $phno, "fin" => $fin,"ce_diploma" => $ce_diploma, "ce_nondiploma" => $ce_nondiploma), 200);
			}
			else {
				$this->response(array("error"=>"Wrong Student ID/password combination"), 404);
			}		
		}
	}
}