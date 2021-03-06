@extends("Master.master")

@section("style")
    <link rel="stylesheet" href="{{asset("/css/monitorRoomStyle.css")}}"/>
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset("/Borrow/images/icons/favicon.ico")}}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/vendor/bootstrap/css/bootstrap.min.css")}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/fonts/font-awesome-4.7.0/css/font-awesome.min.css")}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/vendor/animate/animate.css")}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/vendor/css-hamburgers/hamburgers.min.css")}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/vendor/select2/select2.min.css")}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/css/util.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/css/main.css")}}">
    <!--===============================================================================================-->
@endsection

@section("content")

    <div class="FormContainer">
        <form action="{{url("view/room/Room_Monitor")}}" method="Get">
            <select class="form-control form-control-l" type="select" name="floor" id="select">
                <option disabled selected hidden>Select Floor</option>
                <option value=6>6</option>
                <option value=7>7</option>
            </select>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="Parent">
        <div id="MonitorRoomContainer">
            @if(isset($data))
            <div class="itemOddContainer">
                @foreach($data as $d)
                    @if((int)$d["room"]->roomID %2 !== 0)
                        <div class="item" style="background-color:{{$d["color"]}};"> {{(int)$d["room"]->roomID}}</div>
                    @endif
                @endforeach
            </div>

            <div class="itemEvenContainer">
                @foreach($data as $d)
                    @if((int)$d["room"]->roomID %2 === 0)
                        <div class="item" style="background-color:{{$d["color"]}};"> {{(int)$d["room"]->roomID}}</div>
                    @endif
                @endforeach
            </div>
            <a href="{{url("/view/room/Room_Monitor?floor=".$data[0]["room"]->roomFloor)}}" style="margin-left: 5px">
                <button type="button" class="btn btn-warning" style="color: #ffffff">Refresh</button>
            </a>
            @else
                <div>
                    All Transaction are Done
                </div>
            @endif
        </div>
    </div>

    <div id="Description">
        Legend
        <div class="descriptionItem">
            <div id="descriptionText">
                No Transaction
            </div>
            <div id="colorBox" style="background-color: #2ab94c">

            </div>
        </div>

        <div class="descriptionItem">
            <div id="descriptionText">
                On Transaction
            </div>
            <div id="colorBox" style="background-color: #0f61ff">

            </div>
        </div>

        <div class="descriptionItem">
            <div id="descriptionText">
                Next Shift on Queue
            </div>
            <div id="colorBox" style="background-color: #ffc107">

            </div>
        </div>

        <div class="descriptionItem">
            <div id="descriptionText">
                Transaction Key not Returned
            </div>
            <div id="colorBox" style="background-color: #e72537">

            </div>
        </div>

    </div>

@endsection

@section("script")
    <script src="{{asset("Borrow/vendor/jquery/jquery-3.2.1.min.js")}}"></script>
    <script>

        let odd = $('.itemOddContainer').children();
        let even = $('.itemEvenContainer').children();
        let select = document.getElementById("select");
        let value = select.options[select.selectedIndex].value;
        let floor = 0;
        let refreshTime = (1000*60) * 30;

        window.addEventListener("load",()=>{
            if(value === 6){
                floor = 6;
            }else if(value === 7){
                floor = 7;
            }else{
                floor = 6;
            }
        });

        // window.setInterval(()=>{
        //     $.ajax({
        //         type:"get",
        //         url:"/transaction/getMonitorData",
        //         data :{data:floor},
        //         success: (data)=>{
        //             console.log(data);
        //         },
        //         error: (data)=>{
        //             console.log(data);
        //         }
        //     })
        // },refreshTime);

    </script>
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
@endsection
