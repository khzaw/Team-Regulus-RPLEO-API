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