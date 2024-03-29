<x-mail::message>
# Introduction
Hello {{$details["name"]}},<br>
 
As you requested you forgot your password !!!<br> your password is: <h1>{{$details["password"]}}</h1><br> 
This mail is confedential and not disclosable.Also advised you to change your password.

<x-mail::button :url="'https://lbk9537.uta.cloud/signIn'">
Login Here
</x-mail::button>

Thanks,<br>
 Admin {{ config('app.name') }}
</x-mail::message>
