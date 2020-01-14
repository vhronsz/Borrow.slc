<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Testing Scan</title>
    <link rel="stylesheet" href="{{asset("/css/qrLogin.css")}}">
</head>
<body>
    <a href="https://api.whatsapp.com/send?phone=6281929562608&text=Halo%20kami%20dari%20%3CTest%3E%0d%0amemberitahukan%20kepada%20bapak%20%0d%0abahwa%201%2b1%20%3d%202&source=&data=">Klik boi</a>

    <div id="center">
        <div id="reader">
        </div>

        <div id="message">
            Test Message
        </div>
    </div>

</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('/qrcode/jsqrcode-combined.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/qrcode/html5-qrcode.min.js') }}"></script>
<script type="text/javascript">
    $('#reader').html5_qrcode(function(data){
            $('#message').html('<span class="text-success send-true">Scanning now....</span>');
            if (data!='') {

                $.ajax({
                    type: "POST",
                    cache: false,
                    url : "",
                    data: {data:data},
                    success: function(data) {
                        console.log(data);
                        if (data==1) {
                            //location.reload()
                            $(location).attr('href', '{{url('/testing/a')}}');
                        }else{
                            return confirm('There is no user with this qr code');
                        }
                        //
                    }
                })

            }else{return confirm('There is no  data');}
        },
        function(error){
            $('#message').html('Scaning now ....'  );
        }, function(videoError){
            $('#message').html('<span class="text-danger camera_problem"> there was a problem with your camera </span>');
        }
    );
</script>

</html>
