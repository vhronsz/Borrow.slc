<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>

<body>
    <img src="http://127.0.0.1:8000/storage/{{$uuid}}.png" alt="">

    <form name="upload" action="{{action('ItemTransactionController@addQr')}}" method="post" enctype="multipart/form-data">
        <input name="uniqs" type="text" placeholder="name">
        <input type="file" name="qr_code">
        <input type="submit">
    </form>

    <script src="{{asset("Borrow/vendor/jquery/jquery-3.2.1.min.js")}}"></script>

    <script>
        $(document).ready(function () {
            $('input[name="qr_code"]').submit();
            $('#butons').click(function (e) {
                console.log(e);
            });
        });
    </script>

</body>
</html>