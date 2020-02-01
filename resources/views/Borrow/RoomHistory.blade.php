@extends("Master.master")

@section("style")
    <link rel="stylesheet" href="{{asset("/css/BorrowRoom.css")}}"/>
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
    <div id="Parent">
        <div id="Container">

            @foreach($item as $i)
                <div id="ItemBox">
                    <div id="Item">{{$i->roomID}}</div>
                    <div id="Item">{{$i->borrowerName}}</div>
                    <div id="Item">{{$i->roomID}}</div>

                    <a href="{{url("/DeleteTransaction/".$i->roomTransactionId)}}">
                        <button class="btn btn-danger">Delete</button>
                    </a>
                </div>
            @endforeach
        </div>
        <div id="links">
            {{$item->links("pagination::bootstrap-4")}}
        </div>
    </div>
@endsection
