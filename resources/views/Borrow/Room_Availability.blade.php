@extends("Master.master")

@section("style")
    <link rel="stylesheet" href="{{asset("/css/roomAvailability.css")}}"/>
@endsection

@section("content")
    <br>
    <div class="MonitorRoomContainer">
        <form action="{{url("/room/Room_Availability")}}" method="POST">
            <input type="date" name="date" id="">
            <button type="submit">Submit</button>
        </form>
    </div>

    <div style="margin: 20px">
        <br>
        Showing Data for : {{date("d/m/y",strtotime($date[0]))}}
    </div>

    <div class="MonitorRoomContainer">

        @if($details === null)
            <div>
                No Transaction
            </div>
        @else

            <?php $index = 0; ?>

            @foreach($details as $detail)
                    @foreach($detail["StatusDetails"] as $status)
                        @if($index === 7)
                            <?php
                            $index = 0;
                            ?>
                            <div id="break"></div> <!-- Temporary-->
                        @endif

                        @if(sizeof($status) !== 0)
                            <div class="roomAvailable">
                                <span>{{$detail["RoomName"]}}</span>
                            </div>

                        @elseif(sizeof($status) === 0)
                            <div class="roomNotAvailable">
                                <span>{{$detail["RoomName"]}}</span>
                            </div>

                        @endif
                        <?php $index++; ?>
                    @endforeach
            @endforeach

        @endif
    </div>
@endsection
