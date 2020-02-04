<!DOCTYPE html>
<html lang="en">

<head>
	<title>Delete Barang</title>
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
@include('Master.navBar')
	<div class="bg-contact3" style="background-image: {{asset('Borrow/images/bg-01.jpg')}};">
		<div class="container-contact3">
			<div class="wrap-contact3">
				<form class="contact3-form delete-validate-form" action="{{action('ItemController@destroy')}}" method="post">
					<span class="contact3-form-title">
						Delete Barang SLC
					</span>

					<div class="wrap-input3 validate-input" data-validate="Barang is required">
						<input class="input3" type="hidden" name="itemTemp">
						<select class="selection-2" id="barang" name="barang">
							<option disabled="disabled" selected="selected" value="Barang">Barang</option>
							@foreach($data as $item)
								<option value="{{$item->itemID}}">{{$item->itemID}} - {{$item->itemName}}</option>
							@endforeach
						</select>
						<span class="focus-input3"></span>
					</div>

					<div class="container-contact3-form-btn">
						<button class="contact3-form-btn">
							Delete
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

	<script>
		$('input[name="itemTemp"]').val('Barang')
		$(document).ready(function () {
			$('select').on('change', function() {
				var item = $('#barang').find(":selected").text();
				$('input[name="itemTemp"]').val(item)
			});
		});
	</script>

</body>

</html>
