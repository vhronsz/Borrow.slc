<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrow.Slc</title>
    <link rel="stylesheet" href="{{asset("css/Master.css")}}">
    @yield('style')
</head>

<body>
    @include("Master.Header")
    @include("Master.navBar")
    @yield("content")
    @include("Master.Footer")
</body>
    @yield("script")

<!--===============================================================================================-->
<script src="{{asset("Borrow/vendor/jquery/jquery-3.2.1.min.js")}}"></script>
<!--===============================================================================================-->
<script src="{{asset("Borrow/vendor/bootstrap/js/popper.js")}}"></script>
<script src="{{asset("Borrow/vendor/bootstrap/js/bootstrap.min.js")}}"></script>
<!--===============================================================================================-->
<script src="{{asset("Borrow/vendor/select2/select2.min.js")}}"></script>
<script>
    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });
</script>
<!--===============================================================================================-->
<script src="{{asset("Borrow/js/main.js")}}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/filereader.js') }}"></script>
<script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/qrcodelib.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/qrcode/option2/js/webcodecamjs.js ') }}"></script>

<!--===============================================================================================-->
<script src="{{asset("Borrow/vendor/jquery/jquery-3.2.1.min.js")}}"></script>
<!--===============================================================================================-->
<script src="{{asset("Borrow/vendor/bootstrap/js/popper.js")}}"></script>
<script src="{{asset("Borrow/vendor/bootstrap/js/bootstrap.min.js")}}"></script>
<!--===============================================================================================-->
<script src="{{asset("Borrow/vendor/select2/select2.min.js")}}"></script>
<script>
    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });
</script>
<!--===============================================================================================-->
<script src="{{asset("Borrow/js/main.js")}}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/filereader.js') }}"></script>
<script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/qrcodelib.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/qrcode/option2/js/webcodecamjs.js ') }}"></script>
</html>

