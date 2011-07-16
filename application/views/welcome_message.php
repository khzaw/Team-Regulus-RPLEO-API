<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Project Regulus API</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, serif;
 font-size: 16px;
 color: #4F5155;
}

#notice {
 color: red;
 font-family:
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
 text-decoration: none;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 18px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}



</style>
</head>
<body>

<h1>Welcome to Project Regulus API Documentation</h1>
<p><b><i>"Regulus is the brightest star in the LEO constellation."</b></i></p>
<p id="notice">Please note that I do not <b>STORE</b> nor <b>LOG</b> any of your credentials.</p>

<h1>Recent Updates</h1>
  <p>*  Removed support for GET requests. Every request is to be done via POST. The data you need to pass in are <b>sid</b> and <b>password</b>. Please feel free to visit the code repository for verification.</p>
 <p>*  Support for retrieving UT Schedules and Class Timetable.</p>
 
 <p>For latest news and updates, follow <a href="http://twitter.com/#!/geeksatrp">@GeeksAtRP</a> <a href="http://twitter.com/#!/rpleoapp">@RPLeoApp</a> <a href="http://twitter.com/#!/emoosx">@emoosx</a> <a href="http://twitter.com/#!/yemyat91">@yemyat91</a> <a href="http://twitter.com/#!/ruqqq">@ruqqq</a> on twitter.</p>

<h1>Personal Particulars</h1>

<code>http://emoosx.me/regulus/api/academic/particulars/</code>
<ul>
			<li>name</li>
			<li>diploma</li>
			<li>gpa</li>
				<li>phno</li>
				<li>fin</li>
				<li>ce_diploma</li>
				<li>ce_nondiploma</li>
		</ul>
<h1>UT Schedule and Class Timetable</h1>
<code>http://emoosx.me/regulus/api/classroom/classSchedule/</code>
<ul>
		<li>module_code</li>
		<li>module_name</li>
		<li>problem_no</li>
		<li>venue</li>
		<li>date</li>
		<li>day</li>
		<li>time</li>
</ul>
<code>http://emoosx.me/regulus/api/classroom/utSchedule/</code>
<ul>
		<li>ut_name</li>
		<li>ut_no</li>
		<li>module_code</li>
		<li>venue</li>
		<li>time</li>
		<li>date</li>
		<li>day</li>
</ul>
<h1>Daily Problem and RJ Question</h1>
<code>http://emoosx.me/regulus/api/dailyProblem/rjquestion/</code>
<ul>
			<li>problem_name</li>
			<li>rj_question</li>
		</ul>
<h1>Recently Published Grades and UT Grades</h1>
<code>http://emoosx.me/regulus/api/grades/recentGrades/</code>
<ul>
		<li>module_code</li>
		<li>problem</li>
		<li>grade</li>
		<li>individual_comment</li>
		<li>team_comment</li>
		<li>attendance</li>
</ul>
<code>http://emoosx.me/regulus/api/grades/recentUTGrades/</code>
		<ul>
			<li>module_code</li>
			<li>ut_no</li>
			<li>ut_grade</li>
		</ul>
	
<h1>Related Projects</h1>
<h4>LeoApp for Android</h4>
<p>For Android users, <a href="https://market.android.com/details?id=sg.rp.geeks.leoapp">LeoApp</a> is available on the android market.</p>
<h4>LeoApp for iOS</h4>
<p>For iOS users, search for LeoApp in the appstore</p>
<h4>RP Facemash</h4>
<p>Visit <a href="http://rpfacemash.appspot.com">RP Facemash</a> and have fun! Inspired by the film, Social Network.</p>
<h4>RP LEO BOT</h4>
<p>For a handy Google Chat bot supporting these features, add <a href="http://rpleobot.appspot.com">rpleobot@appspot.com</a> in your Google Talk</p>

<p>This project is fully <b>Open-Source!</b> <a href="https://github.com/emoosx/Team-Regulus-RPLEO-API">Fork me, fork me hard!</a>.</p>

</body>
</html>