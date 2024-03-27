<x-mail::message>
# Introduction

Hello {{$details['name']}},<br>

 Welcome to ISVP!!!<br> we are very excited to have you in ISVP and happy to help you to reach your goal. 
 Please feel free to reach us out for any queries. 

<x-mail::button :url="'https://lbk9537.uta.cloud'">
Explore More
</x-mail::button>

Thanks,<br>
Admin {{ config('app.name') }}
</x-mail::message>
