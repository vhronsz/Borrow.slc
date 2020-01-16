@extends("Master.master")
@section("content")
    <div class="MonitorRoomContainer">
        <form action="controllerDate.php" method="POST">
            <input type="date" name="datePicker" id="">
            <button type="submit">Submit</button>
        </form>
    </div>
    <div class="MonitorRoomContainer">
        <?php
        session_start();
        if(!isset($_SESSION["Date"])){
            $_SESSION["Date"] = "09/23/2019";
        }
        $date = $_SESSION["Date"];
        // echo $_SESSION["sate"];
        echo ($date);
        $url = file_get_contents("https://laboratory.binus.ac.id/lapi/api/Room/GetTransactions?startDate=$date&endDate=$date&includeUnapproved=true");
        $json = json_decode($url, true);

        $details = $json["Details"];

        foreach ($details as $detailss) {

        $statusDetails = $detailss["StatusDetails"];
        $i = 1;
        foreach ($statusDetails as $statusDetailss) {
        if (sizeof($statusDetailss) !== 0) {
        ?>
        <div class="roomAvailable">
            <span><?php echo $detailss["RoomName"]; ?></span>
        </div>
        <?php
        } else {
        ?>
        <div class="roomNotAvailable">
            <span><?php echo $detailss["RoomName"]; ?></span>
        </div>
        <?php
        }
        $i++;
        }
        }
        ?>
    </div>
@endsection
