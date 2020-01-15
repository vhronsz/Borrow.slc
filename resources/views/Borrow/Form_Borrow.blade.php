<!DOCTYPE html>
<html lang="en">

<head>
	<title>Form Peminjaman Ruang</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
</head>

<body>

	<div class="bg-contact3" style="background-image: url('{{asset("/Borrow/images/bg-01.jpg")}}');">
		<div class="container-contact3">
			<div class="wrap-contact3">
				<form class="contact3-form validate-form" action="{{url("/")}}" method="POST">
					<span class="contact3-form-title">
						Form Peminjaman Ruang SLC
					</span>

					<div class="wrap-input3 validate-input" data-validate="Name is required">
						<input class="input3" type="text" name="name" placeholder="Your Name">
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input3" type="text" name="email" placeholder="Your Email">
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Phone is required">
						<input class="input3" type="text" name="phone" placeholder="Your Phone">
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Room is required">
						<div>
							<select class="selection-2" name="room" placeholder="Room">
								<option disabled selected hidden>Room</option>
								<option value="601">601</option>
								<option value="602">602</option>
								<option value="603">603</option>
								<option value="604">604</option>
								<option value="605">605</option>
								<option value="606">606</option>
							</select>
						</div>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Room is required">
						<div>
							<select class="selection-2" name="shift">
								<option disabled selected hidden>Shift</option>
								<option value=1>1</option>
								<option value=2>2</option>
								<option value=3>3</option>
								<option value=4>4</option>
								<option value=5>5</option>
								<option value=6>6</option>
							</select>
						</div>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3">
						<input class="input3" type="date" name="date" placeholder="Date">
						<span class="focus-input3"></span>
					</div>

					<div>
						<span class="input3">Need Internet ?</span>
						<br>
					</div>

					<div class="wrap-contact3-form-radio">
						<div class="contact3-form-radio m-r-42">
							<input class="input-radio3" id="radio1" type="radio" name="choice" value="say-hi">
							<label class="label-radio3" for="radio1">
								Yes
							</label>
						</div>

						<div class="contact3-form-radio">
							<input class="input-radio3" id="radio2" type="radio" name="choice" value="get-quote"
								checked="checked">
							<label class="label-radio3" for="radio2">
								No
							</label>
						</div>
					</div>

					<div class="wrap-input3 input3-select" data-validate="Message is required">
						<textarea class="input3" name="message" placeholder="Internet Reason Description"></textarea>
						<span class="focus-input3"></span>
					</div>

					<div class="container-contact3-form-btn">
						<button class="contact3-form-btn">
							Submit
						</button>
					</div>
				</form>
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

</body>

</html>
