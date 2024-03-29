<x-mail::message>
# Introduction

Hello {{$details['name']}},<br>

Welcome to ISVP! We are delighted to have you on board. Your commitment to supervising the students during this challenging time is greatly appreciated.<br> 
To access the portal, kindly use your email and the provided password: {{$details['password']}}.<br>
We advise you to change your password for security purposes upon login. <br>
Please don't hesitate to contact us with any queries or concerns. 

<x-mail::button :url="'https://lbk9537.uta.cloud'">
Explore More
</x-mail::button>

Thanks,<br>
Admin {{ config('app.name') }}
</x-mail::message>
