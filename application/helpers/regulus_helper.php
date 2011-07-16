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
	{
		$url = "http://leo.rp.edu.sg/workspace/studentModule.asp?disp=all";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_USERPWD, "$sid:$password");
		$html = curl_exec($ch);
		curl_close($ch);
		
		$pattern = "/$module_code-\d-\w\d\d\w-[ABC]<\/a>&nbsp;&nbsp;<a href='javascript:\/\/' class=ttitle onMouseOver=\"popup\('<font color=darkblue> Owner: .*<\/font>', '#F1F1F1', '280'\);\" OnMouseOut='kill\(\)'><i>(.*)<\/i>/";
		preg_match_all($pattern, $html, $matches);
		return $matches[1][0];
	}

}