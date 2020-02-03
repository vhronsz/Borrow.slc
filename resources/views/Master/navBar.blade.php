
{{--<div id="NavBar">--}}

{{--    <a class="Item" href="{{url("/view/room/Home")}}">--}}
{{--        Home--}}
{{--    </a>--}}

{{--    <a class="Item" href="{{url("/view/room/Borrow_Room_Form")}}">--}}
{{--        Borrow--}}
{{--    </a>--}}

{{--    <a class="Item" href="{{url("/view/room/Room_Monitor")}}">--}}
{{--        Room Monitor--}}
{{--    </a>--}}

{{--    <a class="nav-item" href="{{url("/view/room/Room_Availability")}}">--}}
{{--        Available Room--}}
{{--    </a>--}}

{{--    <li class="nav-item dropdown">--}}
{{--        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">--}}
{{--            Dropdown link--}}
{{--        </a>--}}
{{--        <div class="dropdown-menu">--}}
{{--            <a class="dropdown-item" href="#">Link 1</a>--}}
{{--            <a class="dropdown-item" href="#">Link 2</a>--}}
{{--            <a class="dropdown-item" href="#">Link 3</a>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--</div>--}}

<nav class="navbar navbar-expand-sm">
    <!-- Brand -->
    <a class="navbar-brand" href="/view/room/Home">Home</a>

    <!-- Links -->
    <ul class="navbar-nav">
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#">Link 1</a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#">Link 2</a>--}}
{{--        </li>--}}

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Scan
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Room</a>
                <a class="dropdown-item" href="/view/item/ScanItem">Item</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Borrowing
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/view/room/Borrow_Room">Room</a>
                <a class="dropdown-item" href="/view/item/formItem">Item</a>
            </div>
        </li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Item
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/view/item/addItem">Add</a>
                <a class="dropdown-item" href="/view/item/updateItem">Update</a>
                <a class="dropdown-item" href="/view/item/deleteItem">Delete</a>
                <a class="dropdown-item" href="/view/item/transaction">Transaction</a>
            </div>
        </li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Room
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/view/room/Borrow_Room">Borrow</a>
                <a class="dropdown-item" href="/view/room/Room_Monitor">Monitor Room</a>
                <a class="dropdown-item" href="/view/room/History_Room">History Room</a>
                <a class="dropdown-item" href="/view/room/Room_Availability">Room Transaction</a>
            </div>
        </li>

    </ul>
</nav>
