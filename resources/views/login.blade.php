<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset('css/loginStyle.css')}}"/>
    <title>Borrow.Slc</title>
</head>
<body>
    @section('content')
       <div id="container">
           <form id="formLogin" action="{{url('auth/doLogin')}}">
               <div class="loginGroup" style="padding-top: 20px;">
                   <p>Username</p>
                   <input type="text" name="username" class="inputLogin"/>
               </div>
               <div class="loginGroup">
                   <p>Password</p>
                   <input type="password" name="password" class="passLogin"/>
               </div>
           </form>
       </div>
    @show
</body>
</html>
