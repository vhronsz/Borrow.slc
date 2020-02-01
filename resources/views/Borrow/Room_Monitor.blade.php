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
    <div class="MonitorRoomContainer">
        <form action="{{url("room/Room_Monitor")}}" method="POST">
            <select class="form-control form-control-l" type="select" name="floor" id="">
                <option disabled selected hidden>Select Floor</option>
                <option value=6>6</option>
                <option value=7>7</option>
            </select>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="MonitorRoomContainer">
{{--        @if(isset($details))--}}
{{--            <div>No Room</div>--}}
{{--        @else--}}
{{--            @foreach($details ?? '' as $detail)--}}
{{--                @foreach($detail["StatusDetails"] as $status)--}}
{{--                    @if(sizeof($status) !== 0)--}}
{{--                        <div class="roomAvailable">--}}
{{--                            <span>{{$detail["RoomName"]}}</span>--}}
{{--                        </div>--}}
{{--                    @elseif(sizeof($status) === 0)--}}
{{--                        <div class="roomNotAvailable">--}}
{{--                            <span>{{$detail["RoomName"]}}</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            @endforeach--}}
{{--        @endif--}}
    </div>
@endsection
