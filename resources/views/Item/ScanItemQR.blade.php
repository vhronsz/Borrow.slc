@extends("Master.master")

@section("content")
    <div class="col-md-6" style="margin-left: 35%;margin-right: 35%;margin-top: 10px">
        <div class="col-md-6" style="margin-bottom: 10px">
            <select class="form-control" id="camera-select"></select>
            <div class="form-group" style="display: none">
                <button title="Decode Image" class="btn btn-default btn-sm" id="decode-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-upload"></span></button>
                <button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-picture"></span></button>
                <button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-play"></span></button>
                <button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-pause"></span></button>
                <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-stop"></span></button>
            </div>
        </div>

        <div class="well" id="canvasQR" style="position: relative;display: inline-block;">
            <canvas width="320px" height="240px" id="webcodecam-canvas" style="width: 400px;height: 320px"></canvas>
            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
        </div>
    </div>

    <div class="thumbnail" id="result" style="margin: 20px">
        <div class="well" style="display: none;">
            <img width="320" height="240" id="scanned-img" src="">
        </div>
        <div class="caption" style="text-align: center">
            <p id="scanned-QR"></p>
            <p id="scanned-Status"></p>
        </div>
    </div>

    <div class="container">

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" style="display: none" data-target="#myModal" id="modal">
            Open modal
        </button>

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title" style="color: green">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" id="modal-body" style="display: block">

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-footer">Close</button>
                    </div>

                </div>
            </div>
        </div>

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
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/filereader.js') }}"></script>
    <script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/qrcodelib.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/qrcode/option2/js/webcodecamjs.js ') }}"></script>

    <script>
        $(document).ready(function () {
            $("#modal-footer").click(function () {
                $("#canvasQR").css("display", "inline-block");
            });
        });
    </script>

    <script>
        function CallAjaxLoginQr(code) {
            console.log(code)
            $("#canvasQR").css("display", "none");
            $.ajax({
                type: "POST",
                cache: false,
                url : "/item/updateTransactionStatus",
                data: {code:code},
                success: function(data) {
                    if(data.status == "Taken"){
                        $('#modal-title').text('Success')
                    }
                    else{
                        $('#modal-title').text('Returned')
                    }
                    var startDate = data.startDate;
                    var endDate = data.endDate;
                    var startDate = "Start Date : "+startDate
                    var endDate = "End Date : "+endDate;
                    var itemName = "Item Name : "+data.itemName;
                    var text = String(startDate) + "<br>" +
                            String(endDate) + "<br>" +
                            String(itemName)
                    $("#modal-body").text(text);
                    jQuery(function(){
                        jQuery('#modal').click();
                    });
                },
                error : function (data) {
                    console.log('error');
                    console.log(data)
                }
            });
        }

        (function(undefined) {
            "use strict";
            function Q(el) {
                if (typeof el === "string") {
                    var els = document.querySelectorAll(el);
                    return typeof els === "undefined" ? undefined : els.length > 1 ? els : els[0];
                }
                return el;
            }
            var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
            var scannerLaser = Q(".scanner-laser"),
                imageUrl = new Q("#image-url"),
                play = Q("#play"),
                scannedImg = Q("#scanned-img"),
                scannedQR = Q("#scanned-QR"),
                grabImg = Q("#grab-img"),
                decodeLocal = Q("#decode-img"),
                pause = Q("#pause"),
                stop = Q("#stop");

            var args = {
                //Set Camera Brightness
                autoBrightnessValue: 100,
                zoom:-0, //-1 for optimized zoom,0-x to zoom camera
                //For Result Processing
                resultFunction: function(res) {
                    [].forEach.call(scannerLaser, function(el) {
                    });
                    scannedImg.src = res.imgData;
                    CallAjaxLoginQr(res.code);
                    // scannedQR[txt] = res.format + ": " + res.code;
                },
                getDevicesError: function(error) {
                    var p, message = "Error detected with the following parameters:\n";
                    for (p in error) {
                        message += p + ": " + error[p] + "\n";
                    }
                    alert(message);
                },
                getUserMediaError: function(error) {
                    var p, message = "Error detected with the following parameters:\n";
                    for (p in error) {
                        message += p + ": " + error[p] + "\n";
                    }
                    alert(message);
                },
                cameraError: function(error) {
                    var p, message = "Error detected with the following parameters:\n";
                    if (error.name == "NotSupportedError") {
                        alert("Browser not supported");
                    } else {
                        for (p in error) {
                            message += p + ": " + error[p] + "\n";
                        }
                        alert(message);
                    }
                },
                cameraSuccess: function() {
                    grabImg.classList.remove("disabled");
                }
            };

            //Initialized Camera
            //Decoder used to control the camera
            var decoder = new WebCodeCamJS("#webcodecam-canvas").buildSelectMenu("#camera-select", "environment|back").init(args);
            window.addEventListener("load",function(){
                decoder.play();
            });

            grabImg.addEventListener("click", function() {
                if (!decoder.isInitialized()) {
                    return;
                }
                var src = decoder.getLastImageSrc();
                scannedImg.setAttribute("src", src);
            }, false);

            document.querySelector("#camera-select").addEventListener("change", function() {
                if (decoder.isInitialized()) {
                    decoder.stop().play();
                }
            });
        }).call(window.Page = window.Page || {});

        //Inisialisasi, pas ke load jalan dulu
        //Trigger Click
        $("document").ready(function() {
            setTimeout(function() {
                $("#play").trigger('click');
            },10);
        });

    </script>
@endsection