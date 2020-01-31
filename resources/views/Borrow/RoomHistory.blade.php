@extends("Master.master")

@section("style")
    <link rel="stylesheet" href="{{asset("/css/monitorRoomStyle.css")}}"/>
@endsection

@section("content")
    <div id="Parent">
        <div id="Container">
            @foreach($item as $i)
            @endforeach
        </div>
    </div>
@endsection
