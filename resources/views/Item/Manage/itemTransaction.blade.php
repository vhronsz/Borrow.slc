<!doctype html>
<html lang="en">
<head>
    <title>View Barang Transaction</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset("/Borrow/images/icons/favicon.ico")}}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("/Borrow/vendor/bootstrap/css/bootstrap.min.css")}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="{{asset("/Borrow/fonts/font-awesome-4.7.0/css/font-awesome.min.css")}}">
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
</head>
<body>
<div class="container">
    <h2>Item Transaction</h2>
    <p>Detail of Item Transaction on the table below : </p>

    <br>
    <form>
        <fieldset>
            <legend>Status:</legend>
                <div class="table-warning" style="width: 20px; height: 20px;"></div>Registered
                <div class="table-danger" style="width: 20px; height: 20px;"></div>Taken
                <div class="table-success" style="width: 20px; height: 20px;"></div>Done
        </fieldset>
    </form>
    <br>

    <div class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            Filter
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/view/item/transaction">All</a>
            <a class="dropdown-item" href="/view/item/filterTransaction/Registered">Registered</a>
            <a class="dropdown-item" href="/view/item/filterTransaction/Taken">Taken</a>
            <a class="dropdown-item" href="/view/item/filterTransaction/Done">Done</a>
        </div>
    </div>
    <br>

    <table class="table table-dark table-hover">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Item</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $headerItem)
            @foreach($headerItem['detailItemTransaction'] as $detailItem)
                @if($detailItem['status'] === 'Registered')
                    <tr class="table-warning">
                @endif
                @if($detailItem['status'] === 'Taken')
                    <tr class="table-danger">
                @endif
                @if($detailItem['status'] === 'Done')
                    <tr class="table-success">
                        @endif
                        <td>{{$headerItem['username']}}</td>
                        <td>{{$headerItem['userEmail']}}</td>
                        <td>{{$headerItem['userPhone']}}</td>
                        <td>{{$detailItem['shiftStart']}}</td>
                        <td>{{$detailItem['shiftEnd']}}</td>
                        <td>{{$detailItem["item"]["itemID"]}} - {{$detailItem["item"]["itemName"]}}</td>
                        @endforeach
                    </tr>
                    @endforeach()
        </tbody>
    </table>
</div>
</table>
</div>
<div id="dropDownSelect1"></div>

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

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
{{--{{dd($data[0]['detailItemTransaction'][0]["item"]['itemName'])}}--}}