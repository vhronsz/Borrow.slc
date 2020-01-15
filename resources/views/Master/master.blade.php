<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrow.Slc</title>
    @section('style')
        <link rel="stylesheet" href="{{asset("css/Master.css")}}">
    @show
</head>
<body>
    @include("Master.Header")
    @include("Master.navBar")
    @yield("content")
    @include("Master.Footer")
</body>
</html>
