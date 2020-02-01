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

            <div class="itemOddContainer">
                @foreach($rooms as $room)
                    @if((int)$room->roomID %2 !== 0)
                        <div class="item"}}> {{$room->roomID}}</div>
                    @endif
                @endforeach
            </div>

            <div class="itemEvenContainer">
                @foreach($rooms as $room)
                    @if((int)$room->roomID %2 === 0)
                        <div class="item"> {{$room->roomID}}</div>
                    @endif
                @endforeach
            </div>
            <a href="{{url("/view/room/Room_Monitor?floor=".$rooms[0]->roomFloor)}}" style="margin-left: 5px">
                <button type="button" class="btn btn-warning" style="color: #ffffff">Refresh</button>
            </a>
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
                Transaction Over
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
@endsection
