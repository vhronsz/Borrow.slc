<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<div class="visible-print text-center">
<h1>QR Code Generator</h1>
{{--  generate qr --}}
{!! QrCode::size(300)->generate("4f3c73c7-88d8-3e86-8b91-b85519e75892") !!}
{{--    <p>1f16f75b-cce0-3dc3-84b5-e3b9d80e5593</p>--}}
    <img src="data:image/png;base64,{{$qr}}" alt="" srcset="">
</div>


</body>
</html>
