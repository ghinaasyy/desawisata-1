<header id="header" class="header d-flex align-items-center fixed-top">
	<div class="container-fluid container-xl position-relative d-flex align-items-center">

		<a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
			<!-- Uncomment and replace img if you want an image logo -->
			<!-- <img src="{{ asset('fe/assets/img/logo.png') }}" alt=""> -->
			<h1 class="sitename">Desa Arborek</h1>
		</a>

		{{-- Navmenu will be included here so CSS selectors like .header .navmenu apply correctly --}}
		@include('fe.navbar')

		<a class="cta-btn" href="#about">Get Started</a>

	</div>
</header>
