@extends("Master.master")

@section("style")
    <link rel="stylesheet" href="{{asset("/css/monitorRoomStyle.css")}}"/>
@endsection

@section("content")
    <div id="Parent">
        <div id="Container">
            @if(isset($rooms))
                @foreach($rooms as $room)
                    <div>
                        asd
                    </div>
                @endforeach
            @else
                <div>
                    No Room Found
                </div>
            @endif

        </div>
    </div>
@endsection
