<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div>
        Kepada Bapak/Ibu {{$header->borrowerName}}
    </div>
    <div>
        Berikut kami infokan detail peminjaman ruang anda sebagai berikut :
        <ul>
            <li>
                Ruang : {{$header->roomID}}
            </li>
            <li>
                Shift : {{$header->shiftStart}} - {{$header->shiftEnd}}
            </li>
            <li>
                Waktu : {{$header->timeStart}} - {{$header->timeEnd}}
            </li>
        </ul>
        Kunci ruangan dapat diambil dan dikembalikan menggunakan qrcode terlampir pada attachment email.
    </div>
</body>
</html>
