<!DOCTYPE html>
<html lang="en" class="h-100">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="robots" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Eyethu LMS</title>
		
		<link rel="shortcut icon" type="image/png" href="images/favicon.png">
		<link href="{{ asset('n_assets/css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('n_assets/css/custom.css') }}" rel="stylesheet">
	</head>
	<body @if(request()->segment(1) == 'auth') class="h-100" @endif>
		@if(request()->segment(1) == 'auth')
			{{ $slot }}
		@else
			<div id="preloader">
				<div class="sk-three-bounce">
					<div class="sk-child sk-bounce1"></div>
					<div class="sk-child sk-bounce2"></div>
					<div class="sk-child sk-bounce3"></div>
				</div>
			</div>
			@include('livewire.partials.shared')
		@endif

		<script src="{{ asset('n_assets/vendor/global/global.min.js') }}"></script>
		<script src="{{ asset('n_assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
		<script src="{{ asset('n_assets/vendor/chart-js/chart.bundle.min.js') }}"></script>
		<script src="{{ asset('n_assets/js/custom.min.js') }}"></script>
		<script src="{{ asset('n_assets/js/deznav-init.js') }}"></script>
     	<script src="{{ asset('n_assets/vendor/svganimation/vivus.min.js') }}"></script>
		<script src="{{ asset('n_assets/vendor/svganimation/svg.animation.js') }}"></script>
		@stack('scripts')
	</body>
</html>