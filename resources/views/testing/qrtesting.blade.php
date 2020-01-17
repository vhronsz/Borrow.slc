<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<div class="visible-print text-center">
    <h1>-QR Code Generator</h1>
    {{--  generate qr --}}
    {!! QrCode::size(300)->generate("27517e20-c7bb-31ed-87d7-05d57ab311af") !!}
    <p>1f16f75b-cce0-3dc3-84b5-e3b9d80e5593</p>
</div>

</body>
</html>
