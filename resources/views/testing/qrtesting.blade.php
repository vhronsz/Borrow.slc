<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<div class="visible-print text-center">
    <h1>Laravel {{$name}}- QR Code Generator Example</h1>
    {{--  generate qr --}}
    {!! QrCode::size(500)->generate(["Key"=>$kunci,"Name"=>$name]) !!}
    <p>example Cuii=</p>
</div>

</body>
</html>
