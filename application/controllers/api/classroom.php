<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

class Classroom  extends REST_Controller 
{	
	public function classSchedule_post()
	{
		if(!($this->post('sid') && $this->post('password')))
		{
			$this->response(null, 404);
		}
		else
		{
			$sid = $this->post('sid');
			$password = $this->post('password');
			$timetable_url = "http://leo.rp.edu.sg/workspace/studentTimeTable.asp";
			$detail_timetable_url = "http://leo.rp.edu.sg/workspace/timetable.asp";
			
			$html = get_html($sid, $password, $timetable_url);
			$detail_html = get_html($sid, $password, $detail_timetable_url);
			
			$module_code_pattern = "/<font size=1>PB(\w\d{3})-\d-\w\d\d\w-[ABC]<\/font>/";
			preg_match_all($module_code_pattern, $html, $matches);
			$module_codes = $matches[1];
			
			$module_names = array();
			foreach($module_codes as $mc)
			{
				$module_name_pattern = "/<font color=darkgreen>$mc-\d-\w\d\d\w-[ABC]<\/font><\/b><br>(.*)<small>/";
				preg_match_all($module_name_pattern, $detail_html, $matches);
				$result = explode("<small>",$matches[1][0]);
				$module_names[] = $result[0];

			}
			
			$problem_code_pattern = "/<b>Problem:<\/b> (\d{1,2})<\/i>/";
			preg_match_all($problem_code_pattern, $detail_html, $matches);
			$problems = $matches[1];
			
			$module_time_pattern = "/<font size=1>PB\w\d{3}-\d-\w\d\d\w-([ABC])<\/font>/";
			preg_match_all($module_time_pattern, $html, $matches);
			$module_times = $matches[1];
			
			$venue_pattern = "/<font size=1>PB\w\d{3}-\d-(\w\d\d\w)-[ABC]<\/font>/";
			preg_match_all($venue_pattern, $html, $matches);
			$venues = $matches[1];
			
			$date_pattern = "/<font size=1>(\d{1,2}\/\d{1,2})<\/font><\/td><td align=left><font size=1>PB\w\d{3}-\d-\w\d\d\w-[ABC]<\/font>/";
			preg_match_all($date_pattern, $html, $matches);
			$dates = $matches[1];
			
			$days_pattern = "/\(<i>([MTFWS]\w\w)<\/i>\)<\/td><td><b><font color=darkgreen>/";
			preg_match_all($days_pattern, $detail_html, $matches);
			$days = $matches[1];
			
			$times = array();
			if($module_times)
			{
				
				foreach ($module_times as $mt)
				{
					$letter = $mt[strlen($mt) -1];
					if($letter == "A")
					{
						$times[] = "8:30";
					}
					else if($letter == "B")
					{
						$times[] = "9:15";
					}
					else if($letter == "C")
					{
						$times[] = "9:45";
					}
				}
			}
			
			if($module_codes && $module_names && $venues && $dates && $times && $problems && $days) {
				$result = array();
				for($i = 0; $i < count($module_codes); $i++)
				{
					$result[] = array(
						"module_code" => $module_codes[$i],
						"module_name" => $module_names[$i],
						"problem_no" => $problems[$i], 
						"venue" => $venues[$i],
						"date" => $dates[$i],
						"day" => $days[$i],
						"time" => $times[$i]
					);
				}
				$this->response($result, 200);
			}
			else {
				$this->response(array("error"=>"Wrong Student ID/password combination"),404);
			}
			
		}
	}
	
	public function utSchedule_post()
	{
		if(!($this->post('sid') && $this->post('password')))
		{
			$this->response(null, 404);
		}
		else
		{
			$sid = $this->post('sid');
			$password = $this->post('password');
			$ut_schedule_url = "http://leo.rp.edu.sg//workspace/UT3timetable.asp";
			$html = get_html($sid, $password, $ut_schedule_url);
			
			$ut_name_pattern = "/<font color=darkblue>(\w\d{3} Understanding Test [1-3]{1})<\/font>/s";
			preg_match_all($ut_name_pattern, $html, $matches);
			$ut_names = $matches[1];
			
			$ut_no_pattern = "/<font color=darkblue>\w\d{3} Understanding Test ([1-3]{1})<\/font>/";
			preg_match_all($ut_no_pattern, $html, $matches);
			$ut_nos = $matches[1];
			
			$module_code_pattern = "/<font color=darkblue>(\w\d{3}) Understanding Test [1-3]{1}<\/font>/";
			preg_match_all($module_code_pattern, $html, $matches);
			$module_codes = $matches[1];
			
			$venues_pattern = "/<b>Venue:<\/b> (\w\d\d\w)<\/i>/";
			preg_match_all($venues_pattern, $html, $matches);
			$venues = $matches[1];
			
			$times_pattern = "/<b>Time:<\/b> (\d{1,2}:\d{1,2})<\/i>/";
			preg_match_all($times_pattern, $html, $matches);
			$times = $matches[1];
			
			$dates_pattern = "/<td align=center>(\d{1,2}\/\d{1,2}\/\d{4}) <small>\(<i>\w*<\/i>\)<\/td>/";
			preg_match_all($dates_pattern, $html, $matches);
			$dates = $matches[1];
			
			$days_pattern = "/<td align=center>\d{1,2}\/\d{1,2}\/\d{4} <small>\(<i>(\w*)<\/i>\)<\/td>/";
			preg_match_all($days_pattern, $html, $matches);
			$days = $matches[1];
			
			
			if($ut_names && $ut_nos && $module_codes && $venues && $times && $dates && $days)
			{
				$result = array();
				for($i = 0; $i < count($ut_names); $i++)
				{
					$result[] = array(
						"ut_name" => $ut_names[$i],
						"ut_no" => $ut_nos[$i],
						"module_code" => $module_codes[$i],
						"module_name" => get_module_name($sid,$password, $module_codes[$i]),
						"venue" => $venues[$i],
						"time" => $times[$i],
						"date" => $dates[$i],
						"day" => $days[$i]
					);
				}
				return $this->response($result, 200);
			}
			else
			{
				return $this->response(array("error"=>"Wrong Student ID/password combination"), 404);
			}
		}	
	}
}