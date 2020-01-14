<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrow.Slc</title>
</head>
<body>
    @section("header")
        <div id="HeaderContainer">
            <div id="LogoBinusTerlope">
                <img src="{{asset("../Asset/Binus.png")}}" alt="">
            </div>
            <div>
                Borrow
            </div>
        </div>
    @show
    @yield("nav_bar")
    @yield("content")
    @yield("footer")
</body>
</html>
