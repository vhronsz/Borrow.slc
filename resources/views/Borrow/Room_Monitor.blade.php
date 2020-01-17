@extends("Master.master")

@section("style")
    <link rel="stylesheet" href="{{asset("/css/monitorRoomStyle.css")}}"/>
@endsection

@section("content")
    <div class="MonitorRoomContainer">
        <form action="{{url("ChangeDateRA")}}" method="POST">
            <input type="date" name="date" id="">
            <button type="submit">Submit</button>
        </form>
    </div>
    <div class="MonitorRoomContainer">
        @if($details === null)
            <div>sdad</div>
        @else
            @foreach($details as $detail)
                @foreach($detail["StatusDetails"] as $status)
                    @if(sizeof($status) !== 0)
                        <div class="roomAvailable">
                            <span>{{$detail["RoomName"]}}</span>
                        </div>
                    @elseif(sizeof($status) === 0)
                        <div class="roomNotAvailable">
                            <span>{{$detail["RoomName"]}}</span>
                        </div>
                    @endif
                @endforeach
            @endforeach
        @endif
    </div>
@endsection
