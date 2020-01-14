@extends("navBar")
    @section("style")
        <link rel="stylesheet" type="text/css" href="{{asset('css/loginStyle.css')}}"/>
    @endsection
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
    @endsection
