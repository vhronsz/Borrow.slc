<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<div class="visible-print text-center">
    <h1>-QR Code Generator</h1>
    {{--  generate qr --}}
    {!! QrCode::size(300)->generate($key) !!}
    <p>example Cuii=</p>
</div>

</body>
</html>
