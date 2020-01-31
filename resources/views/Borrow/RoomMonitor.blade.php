@extends("Master.master")

@section("style")
    <link rel="stylesheet" href="{{asset("/css/monitorRoomStyle.css")}}"/>
@endsection

@section("content")
    <div id="Parent">
        <div id="Container">
            @if(isset($rooms))
                @for($i=0;$i<10;$i++)
                    @if($rooms[$i]["roomID"] === "610")
                        <div>
                            sadds
                        </div>
                    @endif
                    <div>
                        asd
                    </div>
                @endfor
            @else
                <div>
                    No Room Found
                </div>
            @endif

        </div>
    </div>
@endsection
