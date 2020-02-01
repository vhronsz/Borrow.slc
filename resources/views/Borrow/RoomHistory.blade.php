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
        <table class="table">

            <thead>
                <tr class="bg-primary" id="ItemTitle">
                    <th scope="col" id="Title">Campus</th>
                    <th scope="col" id="Title">Transaction Status</th>
                    <th scope="col" id="Title">Room Number</th>
                    <th scope="col" id="Title">Borrower Name</th>
                    <th scope="col" id="Title">Borrower Email</th>
                    <th scope="col" id="Title">Borrower Phone</th>
                    <th scope="col" id="Title">Borrower Reason</th>
                    <th scope="col" id="Title">Internet</th>
                    <th scope="col" id="Title">Date</th>
                    <th scope="col" id="Title">Start</th>
                    <th scope="col" id="Title">End</th>
                    <th scope="col" id="Title">Assistant</th>
                    <th scope="col" id="Title">Action</th>
                </tr>
            </thead>

            @foreach($item as $i)
                <tr id="ItemBox">
                    <td id="Item">{{$i->campus}}</td>
                    <td id="Item">{{$i->transactionStatus}}</td>
                    <td id="Item">{{$i->roomID}}</td>
                    <td id="Item">{{$i->borrowerName}}</td>
                    <td id="Item">{{$i->borrowerEmail}}</td>
                    <td id="Item">{{$i->borrowerPhone}}</td>
                    @if($i->borrowerReason === null)
                        <td id="Item">{{$i->borrowReason}}</td>
                    @else
                        <td id="Item"> - </td>
                    @endif
                    @if($i->internetRequest === true)
                        <td id="Item"> Yes </td>
                    @else
                        <td id="Item"> No </td>
                    @endif
                    <td id="Item">{{date('d/M/Y',strtotime($i->transactionDate))}}</td>
                    <td id="Item">{{$i->timeStart}}</td>
                    <td id="Item">{{$i->timeEnd}}</td>

                    @if(isset($i->assistant))
                        <td id="Item">{{$i->assistant}}</td>
                    @else
                        <td id="Item">No Assistant</td>
                    @endif

                    <td>
                        <a id="ButtonContainer" href="{{url("/transaction/Delete_Room_Transaction/".$i->roomTransactionID)}}">
                            <button class="btn btn-danger">Delete</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        <div id="links">
            {{$item->links("pagination::bootstrap-4")}}
        </div>
    </div>
@endsection
