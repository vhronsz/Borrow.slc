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

        <div class="well" style="position: relative;display: inline-block;">
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/filereader.js') }}"></script>
    <script type="text/javascript" src=" {{ URL::asset('/qrcode/option2/js/qrcodelib.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/qrcode/option2/js/webcodecamjs.js ') }}"></script>

    <script>

        function CallAjaxLoginQr(code) {
            $.ajax({
                type: "Get",
                cache: false,
                url : "/transaction/Update_Room",
                data: {data:code},
                success: function(data) {
                    console.log(data);
                    $("#scanned-Status").text("");
                    $("#scanned-QR").css("color",data.color);
                    $("#scanned-QR").text(data.message);
                    $("#scanned-Status").css("color",data.color);
                    if(data.status != null){
                        $("#scanned-Status").text("Transaction Status : " + data.status);
                    }
                },
                error : function (data) {
                    console.log(data);
                }
            })
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
{{--//Code That not Used--}}
{{--

            //Used
            contrast = Q("#contrast"),
            contrastValue = Q("#contrast-value"),
            zoom = Q("#zoom"),
            zoomValue = Q("#zoom-value"),
            brightness = Q("#brightness"),
            brightnessValue = Q("#brightness-value"),
            threshold = Q("#threshold"),
            thresholdValue = Q("#threshold-value"),
            sharpness = Q("#sharpness"),
            sharpnessValue = Q("#sharpness-value"),
            grayscale = Q("#grayscale"),
            grayscaleValue = Q("#grayscale-value"),
            flipVertical = Q("#flipVertical"),
            flipVerticalValue = Q("#flipVertical-value"),
            flipHorizontal = Q("#flipHorizontal"),
            flipHorizontalValue = Q("#flipHorizontal-value");

            Buat Efek doang pas dia selesai scan qr
        // function fadeOut(el, v) {
        //     el.style.opacity = 1;
        //     (function fade() {
        //         if ((el.style.opacity -= 0.1) < v) {
        //             el.style.display = "none";
        //             el.classList.add("is-hidden");
        //         } else {
        //             requestAnimationFrame(fade);
        //         }
        //     })();
        // }
        //
        // function fadeIn(el, v, display) {
        //     if (el.classList.contains("is-hidden")) {
        //         el.classList.remove("is-hidden");
        //     }
        //     el.style.opacity = 0;
        //     el.style.display = display || "block";
        //     (function fade() {
        //         var val = parseFloat(el.style.opacity);
        //         if (!((val += 0.1) > v)) {
        //             el.style.opacity = val;
        //             requestAnimationFrame(fade);
        //         }
        //     })();
        // }

            Start Camera
        // play.addEventListener("click", function() {
        //     if (!decoder.isInitialized()) {
        //         scannedQR[txt] = "Scanning ...";
        //     } else {
        //
        //         scannedQR[txt] = "Scanning ...";
        //         decoder.play();
        //     }
        // }, false);

        // Page.decodeLocalImage = function() {
        //     if (decoder.isInitialized()) {
        //         decoder.decodeLocalImage(imageUrl.value);
        //     }
        //     imageUrl.value = null;
        // };

        // decodeLocal.addEventListener("click", function() {
        //     Page.decodeLocalImage();
        // }, false);

            //Set zoom value di page
        // Page.changeZoom = function(a) {
        //     if (decoder.isInitialized()) {
        //         var value = typeof a !== "undefined" ? parseFloat(a.toPrecision(2)) : zoom.value / 10;
        //         // zoomValue[txt] = zoomValue[txt].split(":")[0] + ": " + value.toString();
        //         decoder.options.zoom = value;
        //         if (typeof a != "undefined") {
        //             // zoom.value = a * 10;
        //         }
        //     }
        // };
        // var getZomm = setInterval(function() {
        //     var a;
        //     try {
        //         a = decoder.getOptimalZoom();
        //     } catch (e) {
        //         a = 0;
        //     }
        //     if (!!a && a !== 0) {
        //         Page.changeZoom(a);
        //         clearInterval(getZomm);
        //     }
        // }, 500);
--}}
