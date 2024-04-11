<!DOCTYPE html>
<html language="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Recommendation Letter</title>
    <style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.page {
    width: 21cm;
    min-height: 29.7cm;
    padding: 2cm;
    margin: 1cm auto;
    border: 1px solid #ddd;
    box-shadow: 0 0 0.5cm rgba(0,0,0,0.2);
}

.header {
    text-align: center;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50px;
    border-bottom: 1px solid #ddd;
}

.header h1 {
    margin: 0;
    padding: 0;
    color: #333;
    font-size: 24px;
    line-height: 50px;
}

.logo {
    max-width: 200px;
    margin-right: 20px;
}

.title {
    text-align: center;
    margin-top: 30px;
    margin-bottom: 30px;
}

.title h3 {
    margin: 0;
    padding: 0;
    color: #333;
    font-size: 18px;
    line-height: 1.5;
}

.content {
    text-align: justify;
    line-height: 1.5;
    margin-bottom: 30px;
}

.content p {
    margin: 0;
    padding: 0;
}

.footer {
    text-align: right;
    margin-top: 30px;
}

.footer p {
    margin: 0;
    padding: 0;
    color: #333;
}
</style>
	
</head>
<body>
	<div class="page">
		<div class="header">
			<div class="logo">
				<img src="{{ asset('uploads/uta_letter.png') }}" alt="Institution Logo">
			</div>
		</div>
        <div class="title">
            <h1>Recommendation Letter</h1>
        </div>
		<div class="title">
			<u><h3>To Whom It May Concern,</h3></u>
		</div>
		<div class="content">
			<p>I am writing to recommend {{ $data['student_name'] }} for your company. As a {{$data['professor_designation']}} at University of Texas at Arlington, I have had the pleasure of Volunteering {{$data['student_name']}} in ISV Program and have been consistently impressed by their dedication and hard work.</p>
            <br>
			<p>{{ $data['student_name'] }} has always shown a keen interest and has consistently demonstrated a deep understanding of the subject matter. Their ability to grasp complex concepts and apply them in practical situations is truly commendable.</p>
            <br>
			<p>Furthermore, {{ $data['student_name'] }} has excellent communication skills and has always been able to articulate their thoughts and ideas clearly and effectively. They are a team player and have always been willing to help their peers and contribute to the class discussions.</p>
            <br>
			<p>I have no doubt that {{ $data['student_name'] }} will be avaluable asset to your company and I highly recommend them for the same. If you require any further information, please do not hesitate to contact me.</p>
            <br>
			<p>Sincerely,</p>
			<p>{{ $data['professor_name'] }}</p>
			<p>{{$data['professor_designation']}}</p>
		</div>
		<div class="footer">
			<p>{{$data['today_date']}}</p>
		</div>
	</div>
</body>
</html>