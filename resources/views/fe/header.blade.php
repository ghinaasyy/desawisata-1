<header id="header" class="header d-flex align-items-center fixed-top">
	<div class="container-fluid container-xl position-relative d-flex align-items-center">

		<a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
			<h1 class="sitename">Desa Arborek</h1>
		</a>

		{{-- WRAPPER BIAR NAV GAK NEMPEL KANAN --}}
		<div style="
			padding:6px 15px;
			backdrop-filter: blur(6px);
			margin-right:47px;
		">
			@include('fe.navbar')
		</div>

		@guest
		<a class="cta-btn" href="{{ route('login') }}" style="margin-left:6px;">
			Get Started
		</a>
		@endguest

	</div>
</header>